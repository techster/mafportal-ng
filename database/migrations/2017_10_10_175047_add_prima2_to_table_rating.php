<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPrima2ToTableRating extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('table_ratings', function (Blueprint $table) {
            $table->renameColumn('prima_nota', 'prima_nota3');
            $table->float('prima_nota2', 8, 2)->after('best_step')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('table_ratings', function (Blueprint $table) {
            $table->renameColumn('prima_nota3', 'prima_nota');
            $table->dropColumn('prima_nota2');
        });
    }
}
