<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairMafWorldCupLegacyFilenames extends Migration
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
                'content' => str_replace(
                    ['vegas%20maf%209th6-9.jpg', '9thVegasFinal.jpg'],
                    ['_hero_background_worldcup.jpg', '_hero_background_worldcup.jpg'],
                    $page->content
                ),
            ]);
        }
    }

    public function down()
    {
        // The original files are not present in the migrated asset tree.
    }
}