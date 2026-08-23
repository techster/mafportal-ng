<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClubsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clubs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
            $table->string('slug');
            $table->string('city')->nullable();
            $table->integer('country_id')->nullable()->unsigned();
            $table->text('image')->nullable();
            $table->text('description')->nullable();
            $table->text('text')->nullable();
            $table->timestamps();

            // При удалении страны в которой есть клубы:
            // cascade (удалить также клубы),
            // set null (обнулить страну у клубов),
            // restrict (не давать удалить, если есть клубы)
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('clubs');
    }
}
