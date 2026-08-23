<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ImportMafWorldCupArchive extends Migration
{
    private $slugs = [
        'mafworldcup-history',
        '1st-annual-maf-world-cup',
        '2nd-annual-maf-world-cup',
        '3rd-annual-maf-world-cup',
        '4th-annual-maf-world-cup',
        'the-5th-annual-maf-world-cup',
        'the-6th-annual-maf-world-cup',
        'the-7th-annual-maf-world-cup',
        'the-8th-annual-maf-world-cup',
        'the-9th-annual-maf-world-cup',
    ];

    public function up()
    {
        $pages = $this->archivePages();

        foreach ($this->slugs as $slug) {
            if (!isset($pages[$slug])) {
                throw new RuntimeException('Missing MAF World Cup archive page: '.$slug);
            }

            if (DB::table('pages')->where('slug', $slug)->exists()) {
                DB::table('pages')->where('slug', $slug)->update([
                    'content' => $this->normalizeContent($pages[$slug][5]),
                ]);
                continue;
            }

            $page = $pages[$slug];
            $values = [
                'template' => $page[1],
                'name' => $page[2],
                'title' => $page[3],
                'slug' => $page[4],
                'content' => $this->normalizeContent($page[5]),
                'extras' => $page[6],
                'created_at' => $page[7],
                'updated_at' => $page[8],
                'deleted_at' => $page[9],
            ];

            DB::table('pages')->updateOrInsert(['slug' => $slug], $values);
        }

        $this->addCatalogMenuItem();
    }

    public function down()
    {
        DB::table('menu_items')->where('link', 'mafworldcup-history')->delete();
        DB::table('pages')->whereIn('slug', $this->slugs)->delete();
    }

    private function archivePages()
    {
        $sql = file_get_contents(base_path('dbBackups/mafportal-2025-12.sql'));
        $rows = [];
        $offset = 0;

        while (($start = strpos($sql, 'INSERT INTO `pages` VALUES ', $offset)) !== false) {
            $end = $this->statementEnd($sql, $start);
            if ($end === false) {
                break;
            }

            $prefixLength = strlen('INSERT INTO `pages` VALUES ');
            $statement = substr($sql, $start + $prefixLength, $end - $start - $prefixLength);
            foreach ($this->parseRows($statement) as $row) {
                if (count($row) === 10 && in_array($row[4], $this->slugs, true)) {
                    $rows[$row[4]] = $row;
                }
            }

            $offset = $end + 1;
        }

        return $rows;
    }

    private function statementEnd($sql, $start)
    {
        $inString = false;
        $escaped = false;
        $length = strlen($sql);

        for ($index = $start; $index < $length; $index++) {
            $character = $sql[$index];
            if ($inString) {
                if ($escaped) {
                    $escaped = false;
                } elseif ($character === '\\') {
                    $escaped = true;
                } elseif ($character === "'") {
                    $inString = false;
                }
            } elseif ($character === "'") {
                $inString = true;
            } elseif ($character === ';') {
                return $index;
            }
        }

        return false;
    }

    private function parseRows($statement)
    {
        $rows = [];
        $row = [];
        $value = '';
        $inString = false;
        $escaped = false;
        $depth = 0;
        $length = strlen($statement);

        for ($index = 0; $index < $length; $index++) {
            $character = $statement[$index];

            if ($inString) {
                if ($escaped) {
                    $value .= $character;
                    $escaped = false;
                } elseif ($character === '\\') {
                    $escaped = true;
                } elseif ($character === "'") {
                    $inString = false;
                } else {
                    $value .= $character;
                }
                continue;
            }

            if ($character === "'") {
                $inString = true;
            } elseif ($character === '(') {
                $depth++;
                if ($depth === 1) {
                    $row = [];
                    $value = '';
                }
            } elseif ($character === ')' && $depth === 1) {
                $row[] = $this->sqlValue($value);
                $rows[] = $row;
                $depth = 0;
                $value = '';
            } elseif ($character === ',' && $depth === 1) {
                $row[] = $this->sqlValue($value);
                $value = '';
            } elseif ($depth > 0) {
                $value .= $character;
            }
        }

        return $rows;
    }

    private function sqlValue($value)
    {
        $value = trim($value);

        if (strtoupper($value) === 'NULL') {
            return null;
        }

        return str_replace(
            ['\\\\\\\'', '\\\\\\"', '\\\\\\\\', '\\\\/', '\\\\r', '\\\\n', '\\\\t'],
            ["'", '"', '\\', '/', "\r", "\n", "\t"],
            $value
        );
    }

    private function normalizeContent($content)
    {
        return preg_replace(
            '~(?:https?://[^"\']+)?(?:\.\./|/)?img/([^"\']+)~i',
            '/uploads/maf-world-cup-history/img/$1',
            $content
        );
    }

    private function addCatalogMenuItem()
    {
        $page = DB::table('pages')->where('slug', 'mafworldcup-history')->first();
        if (!$page) {
            return;
        }

        $item = DB::table('menu_items')
            ->where(function ($query) {
                $query->where('link', 'mafworldcup-history')
                    ->orWhere('link', 'like', '%/mafworldcup-history/%');
            })
            ->first();
        $values = [
            'name' => 'MAF WORLD CUP',
            'name_rus' => 'КУБОК МИРА MAF',
            'type' => 'page_link',
            'link' => 'mafworldcup-history',
            'page_id' => $page->id,
            'depth' => 1,
        ];

        if ($item) {
            DB::table('menu_items')->where('id', $item->id)->update($values);
            return;
        }

        $right = (int) DB::table('menu_items')->max('rgt');
        $values['lft'] = $right + 1;
        $values['rgt'] = $right + 2;
        DB::table('menu_items')->insert($values);
    }
}
