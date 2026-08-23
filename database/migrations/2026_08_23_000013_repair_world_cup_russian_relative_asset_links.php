<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairWorldCupRussianRelativeAssetLinks extends Migration
{
    public function up()
    {
        $replacements = [
            '../img/history/8th_mwc.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '/img/history/8th_mwc.jpg' => '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
            '../img/history/7th_mwc.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
            '/img/history/7th_mwc.jpg' => '/uploads/maf-world-cup-history/img/vegas-maf-7th.jpeg',
        ];

        foreach (DB::table('pages')->get() as $page) {
            $extras = json_decode($page->extras, true);
            if (!is_array($extras) || !isset($extras['content_rus'])) {
                continue;
            }

            $content = str_replace(array_keys($replacements), array_values($replacements), $extras['content_rus']);
            if ($content !== $extras['content_rus']) {
                $extras['content_rus'] = $content;
                DB::table('pages')->where('id', $page->id)->update(['extras' => json_encode($extras)]);
            }
        }
    }

    public function down()
    {
        // The original archive paths are not present in the migrated asset tree.
    }
}