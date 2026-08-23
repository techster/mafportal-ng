<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RepairSixthWorldCupAssetLinks extends Migration
{
    private $oldPath = '../img/history/6th_mwc.png';
    private $newPath = '/uploads/maf-world-cup-history/img/history/6th_mwc.png';

    public function up()
    {
        foreach (DB::table('pages')->get() as $page) {
            $content = str_replace($this->oldPath, $this->newPath, $page->content);
            $extras = json_decode($page->extras, true);

            if (is_array($extras) && isset($extras['content_rus'])) {
                $extras['content_rus'] = str_replace($this->oldPath, $this->newPath, $extras['content_rus']);
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
        // The original relative archive path is not valid from every localized route.
    }
}
