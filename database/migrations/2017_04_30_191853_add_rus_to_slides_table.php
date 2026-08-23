<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRusToSlidesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('image');
            $table->text('description_ru')->nullable()->after('title_ru');
            $table->text('btn_text_ru')->nullable()->after('description_ru');
            $table->text('btn_link_ru')->nullable()->after('btn_text_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('slides', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('btn_text_ru');
            $table->dropColumn('btn_link_ru');
        });
    }
}
