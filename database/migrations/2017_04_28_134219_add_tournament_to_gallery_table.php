<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTournamentToGalleryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('photo_galleries', function (Blueprint $table) {
            $table->integer('tournament_id')->nullable()->unsigned()->after('slug');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('set null');
        });
        Schema::table('video_galleries', function (Blueprint $table) {
            $table->integer('tournament_id')->nullable()->unsigned()->after('title');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('set null');
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
            $table->dropForeign('photo_galleries_tournament_id_foreign');
            $table->dropColumn('tournament_id');
        });
        Schema::table('video_galleries', function (Blueprint $table) {
            $table->dropForeign('video_galleries_tournament_id_foreign');
            $table->dropColumn('tournament_id');
    });
    }
}
