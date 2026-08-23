<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRatings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('table_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->integer('club_id')->unsigned()->nullable();
            $table->boolean('check_glob')->nullable()->default(0);

            $table->float('best_player', 8, 2)->default(0);
            $table->float('best_step', 8, 2)->default(0);
            $table->float('win_citizen', 8, 2)->default(0);
            $table->float('win_sheriff', 8, 2)->default(0);
            $table->float('win_mafia', 8, 2)->default(0);
            $table->float('win_don', 8, 2)->default(0);
            $table->float('fail_citizen', 8, 2)->default(0);
            $table->float('fail_sheriff', 8, 2)->default(0);
            $table->float('fail_mafia', 8, 2)->default(0);
            $table->float('fail_don', 8, 2)->default(0);
            $table->float('citizen_killed', 8, 2)->default(0);

            $table->string('formula')->nullable();
            $table->timestamps();

            $table->foreign('club_id')->references('id')->on('clubs')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('table_ratings');
    }
}
