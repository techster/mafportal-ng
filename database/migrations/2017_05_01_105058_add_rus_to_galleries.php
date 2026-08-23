<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRusToGalleries extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo_galleries', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('title');
        });
        Schema::table('video_galleries', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('title');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('photo_galleries', function (Blueprint $table) {
            $table->dropColumn('title_ru');
        });
        Schema::table('video_galleries', function (Blueprint $table) {
            $table->dropColumn('title_ru');
        });
    }
}
