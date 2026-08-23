<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGlobalRatingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('global_ratings', function (Blueprint $table) {
            $table->increments('id');
            $table->string('rating_title_ru')->nullable();
            $table->string('rating_title')->nullable();
            $table->string('sub_heading')->nullable();
            $table->string('sub_heading_ru')->nullable();
            $table->longText('description')->nullable();
            $table->longText('description_ru')->nullable();
            $table->text('image')->nullable();
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
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
        Schema::dropIfExists('global_ratings');
    }
}
