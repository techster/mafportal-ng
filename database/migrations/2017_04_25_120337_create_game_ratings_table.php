<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGameRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('club_id')->unsigned()->nullable();
            $table->integer('tournament_id')->unsigned()->nullable();

            $table->integer('moderator')->nullable();
            $table->text('results')->nullable();
            $table->integer('sentence')->nullable();
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
            $table->foreign('tournament_id')->references('id')->on('tournaments')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('game_ratings');
    }
}
