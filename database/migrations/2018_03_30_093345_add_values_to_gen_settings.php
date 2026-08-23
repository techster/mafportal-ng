<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddValuesToGenSettings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('gen_settings', function (Blueprint $table) {
            $table->text('description')->nullable();
            $table->text('title')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('gen_settings', function (Blueprint $table) {
            $table->dropColumn('description')->nullable();
            $table->dropColumn('title')->nullable();
        });
    }
}
