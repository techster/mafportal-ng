<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizeMafWorldCupImagePaths extends Migration
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
        foreach (DB::table('pages')->whereIn('slug', $this->slugs)->get() as $page) {
            DB::table('pages')->where('id', $page->id)->update([
                'content' => $this->normalize($page->content),
            ]);
        }
    }

    public function down()
    {
        foreach (DB::table('pages')->whereIn('slug', $this->slugs)->get() as $page) {
            DB::table('pages')->where('id', $page->id)->update([
                'content' => str_replace(
                    '/uploads/maf-world-cup-history/img/',
                    '/uploads/maf-world-cup-history/',
                    $page->content
                ),
            ]);
        }
    }

    private function normalize($content)
    {
        $content = preg_replace(
            '~(?:https?://[^"\']+)?(?:\.\./|/)?img/([^"\']+)~i',
            '/uploads/maf-world-cup-history/img/$1',
            $content
        );

        return $content;
    }
}
