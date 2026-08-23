<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVideoGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('video_galleries', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title')->unique();
            $table->text('preview')->nullable();
            $table->string('id_youtube');
            $table->integer('club_id')->nullable()->unsigned();
            $table->boolean('check_glob')->nullable();
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
        Schema::drop('video_galleries');
    }
}
