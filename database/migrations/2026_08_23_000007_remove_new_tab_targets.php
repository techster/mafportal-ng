<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveNewTabTargets extends Migration
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
            $content = str_replace(
                [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                '',
                (string) $page->content
            );
            $extras = json_decode($page->extras, true);

            if (is_array($extras) && isset($extras['content_rus'])) {
                $extras['content_rus'] = str_replace(
                    [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                    '',
                    $extras['content_rus']
                );
            }

            DB::table('pages')->where('id', $page->id)->update([
                'content' => $content,
                'extras' => is_array($extras) ? json_encode($extras) : $page->extras,
            ]);
        }
    }

    public function down()
    {
        // New-tab target attributes are intentionally not restored.
    }
}
