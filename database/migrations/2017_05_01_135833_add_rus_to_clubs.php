<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddRusToClubs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->text('text_ru')->nullable()->after('text');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->text('title_ru')->nullable()->after('description');
            $table->text('description_ru')->nullable()->after('title_ru');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->dropColumn('text_ru');
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->dropColumn('title_ru');
            $table->dropColumn('description_ru');
        });
    }
}
