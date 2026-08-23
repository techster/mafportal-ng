<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ClearOrphanedCountryImageReferences extends Migration
{
    public function up()
    {
        foreach (DB::table('countries')->whereNotNull('image')->get() as $country) {
            $path = parse_url($country->image, PHP_URL_PATH);
            $file = public_path(ltrim($path ?: $country->image, '/'));

            if (!is_file($file)) {
                DB::table('countries')->where('id', $country->id)->update(['image' => null]);
            }
        }
    }

    public function down()
    {
        // Orphaned image references cannot be restored without the original files.
    }
}
