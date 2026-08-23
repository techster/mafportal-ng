<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemoveNewsNewTabTargets extends Migration
{
    public function up()
    {
        foreach (DB::table('news')->get() as $news) {
            $updates = [];

            foreach (['title', 'description', 'text', 'title_ru', 'description_ru', 'text_ru'] as $field) {
                if (isset($news->$field)) {
                    $updates[$field] = str_replace(
                        [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                        '',
                        $news->$field
                    );
                }
            }

            $metas = json_decode($news->metas, true);
            if (is_array($metas)) {
                array_walk_recursive($metas, function (&$value) {
                    if (is_string($value)) {
                        $value = str_replace(
                            [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                            '',
                            $value
                        );
                    }
                });
                $updates['metas'] = json_encode($metas);
            }

            if ($updates) {
                DB::table('news')->where('id', $news->id)->update($updates);
            }
        }
    }

    public function down()
    {
        // New-tab target attributes are intentionally not restored.
    }
}