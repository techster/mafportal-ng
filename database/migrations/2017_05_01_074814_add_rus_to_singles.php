<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRusToSingles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('text');
            $table->text('description_ru')->nullable()->after('title_ru');
            $table->text('text_ru')->nullable()->after('description_ru');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('text');
            $table->text('description_ru')->nullable()->after('title_ru');
            $table->text('text_ru')->nullable()->after('description_ru');
        });
        Schema::table('tournaments', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('text');
            $table->text('description_ru')->nullable()->after('title_ru');
            $table->text('text_ru')->nullable()->after('description_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('news', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('text_ru');
        });
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('text_ru');
        });
        Schema::table('tournaments', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
            $table->dropColumn('text_ru');
        });
    }
}
