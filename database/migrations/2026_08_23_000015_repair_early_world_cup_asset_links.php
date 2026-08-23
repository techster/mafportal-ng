<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairEarlyWorldCupAssetLinks extends Migration
{
    private $replacements = [
        '../img/history/1st_mwc.jpg' => '/uploads/maf-world-cup-history/img/history/1st_mwc.jpg',
        '../img/history/2nd_mwc.jpg' => '/uploads/maf-world-cup-history/img/history/2nd_mwc.jpg',
        '../img/history/3rd_mwc.jpg' => '/uploads/maf-world-cup-history/img/history/3rd_mwc.jpg',
        '../img/history/4th_mwc.jpg' => '/uploads/maf-world-cup-history/img/history/4th_mwc.jpg',
        '../img/history/5th_mwc.jpg' => '/uploads/maf-world-cup-history/img/history/5th_mwc.jpg',
    ];

    public function up()
    {
        foreach (DB::table('pages')->get() as $page) {
            $content = str_replace(array_keys($this->replacements), array_values($this->replacements), $page->content);
            $extras = json_decode($page->extras, true);

            if (is_array($extras) && isset($extras['content_rus'])) {
                $extras['content_rus'] = str_replace(array_keys($this->replacements), array_values($this->replacements), $extras['content_rus']);
            }

            $updates = [];
            if ($content !== $page->content) {
                $updates['content'] = $content;
            }
            if (is_array($extras) && json_encode($extras) !== $page->extras) {
                $updates['extras'] = json_encode($extras);
            }

            if (!empty($updates)) {
                DB::table('pages')->where('id', $page->id)->update($updates);
            }
        }
    }

    public function down()
    {
        // The original relative archive paths are not valid from every localized route.
    }
}
