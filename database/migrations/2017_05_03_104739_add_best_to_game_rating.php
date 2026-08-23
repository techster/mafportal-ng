<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBestToGameRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_ratings', function (Blueprint $table) {
            $table->text('best_move')->nullable()->after('moderator');
            $table->text('best_move2')->nullable()->after('best_move');
            $table->text('best_player')->nullable()->after('best_move2');
            $table->text('cool_citizen')->nullable()->after('best_player');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('game_ratings', function (Blueprint $table) {
            $table->dropColumn('best_move');
            $table->dropColumn('best_move2');
            $table->dropColumn('best_player');
            $table->dropColumn('cool_citizen');
        });
    }
}
