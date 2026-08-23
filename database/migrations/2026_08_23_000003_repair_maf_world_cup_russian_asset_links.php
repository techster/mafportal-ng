<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairMafWorldCupRussianAssetLinks extends Migration
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
        $replacements = [
            'http://www.mafworldcup.com/uploads/admin/thumbnails/tournaments/vegas2020/vegas%20maf%209th6-9.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            'http://www.mafworldcup.com/uploads/admin/thumbnails/tournaments/vegas2020/9thVegasFinal.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
        ];

        foreach (DB::table('pages')->whereIn('slug', $this->slugs)->get() as $page) {
            DB::table('pages')->where('id', $page->id)->update([
                'content' => str_replace(array_keys($replacements), array_values($replacements), $page->content),
            ]);
        }
    }

    public function down()
    {
        // The original files are not present in the migrated asset tree.
    }
}