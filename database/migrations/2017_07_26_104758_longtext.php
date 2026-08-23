<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Longtext extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (DB::connection()->getDriverName() !== 'mysql') {
            return;
        }

        DB::statement('ALTER TABLE clubs CHANGE description description LONGTEXT;');
        DB::statement('ALTER TABLE clubs CHANGE text text LONGTEXT;');
        DB::statement('ALTER TABLE clubs CHANGE text_ru text_ru LONGTEXT;');

        DB::statement('ALTER TABLE countries CHANGE description description LONGTEXT;');
        DB::statement('ALTER TABLE countries CHANGE description_ru description_ru LONGTEXT;');

        DB::statement('ALTER TABLE events CHANGE description description LONGTEXT;');
        DB::statement('ALTER TABLE events CHANGE description_ru description_ru LONGTEXT;');
        DB::statement('ALTER TABLE events CHANGE text text LONGTEXT;');
        DB::statement('ALTER TABLE events CHANGE text_ru text_ru LONGTEXT;');

        DB::statement('ALTER TABLE game_ratings CHANGE results results LONGTEXT;');
        DB::statement('ALTER TABLE game_ratings CHANGE extra_field extra_field LONGTEXT;');

        DB::statement('ALTER TABLE news CHANGE description description LONGTEXT;');
        DB::statement('ALTER TABLE news CHANGE description_ru description_ru LONGTEXT;');
        DB::statement('ALTER TABLE news CHANGE text text LONGTEXT;');
        DB::statement('ALTER TABLE news CHANGE text_ru text_ru LONGTEXT;');
        DB::statement('ALTER TABLE news CHANGE metas metas LONGTEXT;');

        DB::statement('ALTER TABLE orders CHANGE cart cart LONGTEXT;');
        DB::statement('ALTER TABLE orders CHANGE payment_data payment_data LONGTEXT;');

        DB::statement('ALTER TABLE pages CHANGE content content LONGTEXT;');
        DB::statement('ALTER TABLE pages CHANGE extras extras LONGTEXT;');

        DB::statement('ALTER TABLE photo_galleries CHANGE photos photos LONGTEXT;');

        DB::statement('ALTER TABLE products CHANGE description description LONGTEXT;');

        DB::statement('ALTER TABLE table_ratings CHANGE extra_field extra_field LONGTEXT;');

        DB::statement('ALTER TABLE tournaments CHANGE description description LONGTEXT;');
        DB::statement('ALTER TABLE tournaments CHANGE description_ru description_ru LONGTEXT;');
        DB::statement('ALTER TABLE tournaments CHANGE text text LONGTEXT;');
        DB::statement('ALTER TABLE tournaments CHANGE text_ru text_ru LONGTEXT;');
        DB::statement('ALTER TABLE tournaments CHANGE metas metas LONGTEXT;');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clubs', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('text')->nullable()->change();
            $table->text('text_ru')->nullable()->change();
        });
        Schema::table('countries', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('description_ru')->nullable()->change();
        });
        Schema::table('events', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('description_ru')->nullable()->change();
            $table->text('text')->nullable()->change();
            $table->text('text_ru')->nullable()->change();
        });
        Schema::table('game_ratings', function (Blueprint $table) {
            $table->text('results')->nullable()->change();
            $table->text('extra_field')->nullable()->change();
        });
        Schema::table('news', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('description_ru')->nullable()->change();
            $table->text('text')->nullable()->change();
            $table->text('text_ru')->nullable()->change();
            $table->text('metas')->nullable()->change();
        });
        Schema::table('orders', function (Blueprint $table) {
            $table->text('cart')->nullable()->change();
            $table->text('payment_data')->nullable()->change();
        });
        Schema::table('pages', function (Blueprint $table) {
            $table->text('content')->nullable()->change();
            $table->text('extras')->nullable()->change();
        });
        Schema::table('photo_galleries', function (Blueprint $table) {
            $table->text('photos')->nullable()->change();
        });
        Schema::table('products', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
        });
        Schema::table('table_ratings', function (Blueprint $table) {
            $table->text('extra_field')->nullable()->change();
        });
        Schema::table('tournaments', function (Blueprint $table) {
            $table->text('description')->nullable()->change();
            $table->text('description_ru')->nullable()->change();
            $table->text('text')->nullable()->change();
            $table->text('text_ru')->nullable()->change();
            $table->text('metas')->nullable()->change();
        });
    }
}
