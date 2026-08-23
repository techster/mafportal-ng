<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMetasToTournaments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->text('meta_description')->nullable();
            $table->text('meta_description_ru')->nullable();
            $table->text('meta_title')->nullable();
            $table->text('meta_title_ru')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('meta_description')->nullable();
            $table->dropColumn('meta_description_ru')->nullable();
            $table->dropColumn('meta_title')->nullable();
            $table->dropColumn('meta_title_ru')->nullable();
        });
    }
}
