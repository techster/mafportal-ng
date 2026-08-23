<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairAllRelativeWorldCupAssetLinks extends Migration
{
    public function up()
    {
        $replacements = [
            '../img/history/8th_mwc.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/img/history/8th_mwc.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '../img/history/7th_mwc.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
            '/img/history/7th_mwc.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
        ];

        foreach ($replacements as $oldPath => $newPath) {
            foreach (DB::table('pages')->where('content', 'like', '%' . $oldPath . '%')->get() as $page) {
                DB::table('pages')->where('id', $page->id)->update([
                    'content' => str_replace($oldPath, $newPath, $page->content),
                ]);
            }
        }
    }

    public function down()
    {
        // The original archive paths are not present in the migrated asset tree.
    }
}