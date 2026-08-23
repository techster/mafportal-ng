<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TableRatingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('table_ratings')->insert([
            'title'          => 'First table',
            'club_id'        => 1,
            'check_glob'     => 0,
            'best_player'    => 1,
            'best_step'      => 2,
            'win_citizen'    => 1,
            'win_sheriff'    => 2,
            'win_mafia'      => 3,
            'win_don'        => 4,
            'fail_citizen'   => -1,
            'fail_sheriff'   => -2,
            'fail_mafia'     => -3,
            'fail_don'       => -4,
            'citizen_killed' => 3,
            'prima_nota2'    => 2,
            'prima_nota3'    => 4,
            'extra_field'    => '[{"id":"12","name":"Citizens clean win","points":"1","condition1":"red","condition2":"win","type":"checkbox"},{"id":"13","name":"Mafia clean win","points":"1","condition1":"black","condition2":"win","type":"checkbox"},{"id":"14","name":"4 warnings","points":"1","type":"user"}]',
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('table_ratings')->insert([
            'title'          => 'Second table',
            'club_id'        => 2,
            'check_glob'     => 0,
            'best_player'    => 1,
            'best_step'      => 2,
            'win_citizen'    => 1,
            'win_sheriff'    => 2,
            'win_mafia'      => 3,
            'win_don'        => 4,
            'fail_citizen'   => -1,
            'fail_sheriff'   => -2,
            'fail_mafia'     => -3,
            'fail_don'       => -4,
            'citizen_killed' => 3,
            'prima_nota2'    => 2,
            'prima_nota3'    => 4,
            'created_at'     => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
