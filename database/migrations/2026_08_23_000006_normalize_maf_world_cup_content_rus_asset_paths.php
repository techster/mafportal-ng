<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class NormalizeMafWorldCupContentRusAssetPaths extends Migration
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
            $extras = json_decode($page->extras, true);

            if (!is_array($extras) || !isset($extras['content_rus'])) {
                continue;
            }

            $extras['content_rus'] = str_replace(
                'http://www.mafworldcup.com/uploads/admin/thumbnails/tournaments/vegas2020/_hero_background_worldcup.jpg',
                '/uploads/maf-world-cup-history/img/_hero_background_worldcup.jpg',
                $extras['content_rus']
            );

            DB::table('pages')->where('id', $page->id)->update([
                'extras' => json_encode($extras),
            ]);
        }
    }

    public function down()
    {
        // The original files are not present in the migrated asset tree.
    }
}