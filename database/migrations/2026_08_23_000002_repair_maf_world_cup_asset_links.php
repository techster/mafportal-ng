<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairMafWorldCupAssetLinks extends Migration
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
            '/uploads/admin/thumbnails/tournaments/vegas2020/vegas%20maf%209th6-9.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/uploads/admin/thumbnails/tournaments/vegas2020/9thVegasFinal.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/uploads/maf-world-cup-history/img/history/7th_mwc.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
            '/uploads/maf-world-cup-history/img/history/7th_mwc_winner.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
            '/uploads/maf-world-cup-history/img/history/8th_mwc.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/uploads/maf-world-cup-history/img/history/maf_history_8th.jpeg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/uploads/maf-world-cup-history/img/divider.png' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            'http://127.0.0.1:8000/uploads/admin/thumbnails/5db8ca1a4a7e9249d9f658a976abae6b.jpg' => 'http://127.0.0.1:8000/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
        ];

        foreach (DB::table('pages')->whereIn('slug', $this->slugs)->get() as $page) {
            DB::table('pages')->where('id', $page->id)->update([
                'content' => str_replace(array_keys($replacements), array_values($replacements), $page->content),
            ]);
        }

        DB::table('gen_settings')->where('option', 'Meta Settings')->update([
            'value' => str_replace(
                '/uploads/admin/thumbnails/5db8ca1a4a7e9249d9f658a976abae6b.jpg',
                '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
                DB::table('gen_settings')->where('option', 'Meta Settings')->value('value')
            ),
        ]);
    }

    public function down()
    {
        // The original files are not present in the migrated asset tree.
    }
}