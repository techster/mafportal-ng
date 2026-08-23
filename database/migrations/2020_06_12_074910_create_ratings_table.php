<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('club');
            $table->string('player');
            $table->integer('game')->nullable();
            $table->integer('win')->nullable();
            $table->integer('wr')->nullable();
            $table->integer('wb')->nullable();
            $table->integer('fail')->nullable();
            $table->integer('citizen')->nullable();
            $table->integer('mafia')->nullable();
            $table->integer('sheriff')->nullable();
            $table->integer('sheriff_win')->nullable();
            $table->integer('don')->nullable();
            $table->integer('don_win')->nullable();
            $table->integer('bm')->nullable();
            $table->integer('bp')->nullable();
            $table->string('balls')->nullable();
            $table->string('score')->nullable();
            $table->timestamps();
        });

    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ratings');
    }
}
