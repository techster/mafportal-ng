<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class ClearMissingCountryPathReference extends Migration
{
    public function up()
    {
        DB::table('countries')
            ->where('image', 'like', '%eb5c488b38a2e3364a21785c8f0755f3.jpg')
            ->update(['image' => null]);
    }

    public function down()
    {
        // The referenced image is not present in the checked-in public assets.
    }
}
