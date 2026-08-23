<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTableRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->integer('table_ratings_id')->nullable()->after('text');
//            $table->foreign('table_ratings_id')->references('id')->on('table_ratings')->onDelete('cascade');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->integer('table_ratings_id')->nullable()->after('image');
//            $table->foreign('table_ratings_id')->references('id')->on('table_ratings')->onDelete('cascade');
        });
        Schema::table('tournaments', function (Blueprint $table) {
            $table->integer('table_ratings_id')->nullable()->after('image');
//            $table->foreign('table_ratings_id')->references('id')->on('table_ratings')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
//            $table->dropForeign('clubs_table_ratings_id_foreign');
            $table->dropColumn('table_ratings_id');
        });
        Schema::table('events', function (Blueprint $table) {
//            $table->dropForeign('events_table_ratings_id_foreign');
            $table->dropColumn('table_ratings_id');
        });
        Schema::table('tournaments', function (Blueprint $table) {
//            $table->dropForeign('tournaments_table_ratings_id_foreign');
            $table->dropColumn('table_ratings_id');
        });
    }
}
