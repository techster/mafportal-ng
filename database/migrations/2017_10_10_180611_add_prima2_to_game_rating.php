<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrima2ToGameRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_ratings', function (Blueprint $table) {
            $table->tinyInteger('select_prima')->nullable()->after('prima_nota');
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
            $table->dropColumn('select_prima');
        });
    }
}
