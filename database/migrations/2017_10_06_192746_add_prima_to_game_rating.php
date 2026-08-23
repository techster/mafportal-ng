<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrimaToGameRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_ratings', function (Blueprint $table) {
            $table->text('prima_nota')->nullable()->after('cool_citizen');
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
            $table->dropColumn('prima_nota');
        });
    }
}
