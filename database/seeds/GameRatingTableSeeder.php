<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class GameRatingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('game_ratings')->insert([
            'title'          => "First game",
            'slug'           => "first_game",
            'club_id'        => 1,
            'tournament_id'  => NULL,
            'moderator'      => 1,
            'best_move'      => 2,
            'best_move2'     => 3,
            'best_player'    => 4,
            'cool_citizen'   => 5,
            'prima_nota'     => 5,
            'select_prima'   => 2,
            'results'        => '[{"key_id":0,"role":"3","player":"2"},{"key_id":1,"role":"1","player":"3"},{"key_id":2,"role":"1","player":"4"},{"key_id":3,"role":"1","player":"5"},{"key_id":4,"role":"2","player":"6"},{"key_id":5,"role":"3","player":"7"},{"key_id":6,"role":"1","player":"8"},{"key_id":7,"role":"1","player":"9"},{"key_id":8,"role":"1","player":"10"},{"key_id":9,"role":"4","player":"11"}]',
            'sentence'       => 1,
            'created_at'     => "2018-05-21 21:09:51",
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('game_ratings')->insert([
            'title'          => "Second game",
            'slug'           => "second_game",
            'club_id'        => 2,
            'tournament_id'  => NULL,
            'moderator'      => 1,
            'best_move'      => 2,
            'best_move2'     => 3,
            'best_player'    => 4,
            'cool_citizen'   => 5,
            'results'        => '[{"key_id":0,"role":"3","player":"2"},{"key_id":1,"role":"1","player":"3"},{"key_id":2,"role":"1","player":"4"},{"key_id":3,"role":"1","player":"5"},{"key_id":4,"role":"2","player":"6"},{"key_id":5,"role":"3","player":"7"},{"key_id":6,"role":"1","player":"8"},{"key_id":7,"role":"1","player":"9"},{"key_id":8,"role":"1","player":"10"},{"key_id":9,"role":"4","player":"11"}]',
            'sentence'       => 1,
            'created_at'     => "2018-05-22 21:09:51",
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('game_ratings')->insert([
            'title'          => "Tournament first game",
            'slug'           => "tournament_first_game",
            'club_id'        => NULL,
            'tournament_id'  => 1,
            'moderator'      => 1,
            'best_move'      => 2,
            'best_move2'     => 3,
            'best_player'    => 4,
            'cool_citizen'   => 5,
            'results'        => '[{"key_id":0,"role":"3","player":"2"},{"key_id":1,"role":"1","player":"3"},{"key_id":2,"role":"1","player":"4"},{"key_id":3,"role":"1","player":"5"},{"key_id":4,"role":"2","player":"6"},{"key_id":5,"role":"3","player":"7"},{"key_id":6,"role":"1","player":"8"},{"key_id":7,"role":"1","player":"9"},{"key_id":8,"role":"1","player":"10"},{"key_id":9,"role":"4","player":"11"}]',
            'extra_field'    => '"{\"extra_12\":\"1\",\"extra_13\":\"0\",\"extra_14\":\"1\"}"',
            'sentence'       => 1,
            'created_at'     => "2018-05-23 21:09:51",
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('game_ratings')->insert([
            'title'          => "Tournament second game",
            'slug'           => "tournament_second_game",
            'club_id'        => NULL,
            'tournament_id'  => 1,
            'moderator'      => 1,
            'best_move'      => 2,
            'best_move2'     => 3,
            'best_player'    => 4,
            'cool_citizen'   => 5,
            'results'        => '[{"key_id":0,"role":"3","player":"2"},{"key_id":1,"role":"1","player":"3"},{"key_id":2,"role":"1","player":"4"},{"key_id":3,"role":"1","player":"5"},{"key_id":4,"role":"2","player":"6"},{"key_id":5,"role":"3","player":"7"},{"key_id":6,"role":"1","player":"8"},{"key_id":7,"role":"1","player":"9"},{"key_id":8,"role":"1","player":"10"},{"key_id":9,"role":"4","player":"11"}]',
            'sentence'       => 1,
            'created_at'     => "2018-05-24 21:09:51",
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('game_ratings')->insert([
            'title'          => "Tournament third game",
            'slug'           => "tournament_third_game",
            'club_id'        => NULL,
            'tournament_id'  => 1,
            'moderator'      => 1,
            'best_move'      => 2,
            'best_move2'     => 3,
            'best_player'    => 4,
            'cool_citizen'   => 5,
            'results'        => '[{"key_id":0,"role":"3","player":"2"},{"key_id":1,"role":"1","player":"3"},{"key_id":2,"role":"1","player":"4"},{"key_id":3,"role":"1","player":"5"},{"key_id":4,"role":"2","player":"6"},{"key_id":5,"role":"3","player":"7"},{"key_id":6,"role":"1","player":"8"},{"key_id":7,"role":"1","player":"9"},{"key_id":8,"role":"1","player":"10"},{"key_id":9,"role":"4","player":"11"}]',
            'sentence'       => 1,
            'created_at'     => "2018-05-25 21:09:51",
            'updated_at'     => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
