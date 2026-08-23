<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class RemovePageNewTabTargets extends Migration
{
    public function up()
    {
        foreach (DB::table('pages')->get() as $page) {
            $content = str_replace(
                [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                '',
                (string) $page->content
            );
            $extras = json_decode($page->extras, true);

            if (is_array($extras)) {
                array_walk_recursive($extras, function (&$value) {
                    if (is_string($value)) {
                        $value = str_replace(
                            [' target="_blank"', ' target="_self"', " target='_blank'", " target='_self'"],
                            '',
                            $value
                        );
                    }
                });
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
