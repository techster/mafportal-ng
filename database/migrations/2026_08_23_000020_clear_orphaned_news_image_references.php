<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ClearOrphanedNewsImageReferences extends Migration
{
    public function up()
    {
        foreach (DB::table('news')->whereNotNull('image')->get() as $news) {
            $path = parse_url($news->image, PHP_URL_PATH);
            $file = public_path(ltrim($path ?: $news->image, '/'));

            if (!is_file($file)) {
                DB::table('news')->where('id', $news->id)->update(['image' => null]);
            }
        }
    }

    public function down()
    {
        // Orphaned image references cannot be restored without the original files.
    }
}
