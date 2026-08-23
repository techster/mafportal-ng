<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class NewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('news')->insert([
            'slug'        => '2017-04-08-mwc2017',
            'title'       => 'The 6th Annual MAF World Cup in Las Vegas',
            'description' => 'MAF World Cup in Las Vegas is an open annual tournament for all MAFIA players around the World. It\'s the only MAFIA tournament, where winners receive monetary prize. The best player is recognized as The DON and awarded a uniquely designed bracelet.',
            'text'        => '<p>The pre-registration for the 6th Annual MAF World Cup is now <a href="http://mafworldcup.com/index.html#registration" target="_blank">open</a>. Every registered participant will play 6 games in the first round on August 3 and 4. The best 20 players will play 3 more games in the second round on August 5. And the best 10 players will play 1 FINAL game on August 5 at 11 pm. The award ceremony and the post-Award Gala will take place immediately after the FINAL game. The best players will split the monetary prize. The best player, or DON, is decided by overall ranking and will received the bracelet of DON in addition to monetary prize.</p>',
            'image'       => '/uploads/homepage/wmc2017.png',
            'created_at'  => "2017-04-03 21:09:51",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('news')->insert([
            'slug'        => '2017-04-08-vawaca2017',
            'title'       => 'VaWacA 2017',
            'description' => 'Первый мини-турнир по классической спортивной игре "Мафия" между клубами из Ванкувера, Сиэтла, Лос Анджелеса и Сан-Франциско.',
            'text'        => "<p>Количество участников ограничено 25 игроками.<br /> Все, что не успеют отметиться Going, будут вынесены в Wait List.<br /> На турнире используется круговая система: 2 дня, 2 стола, по 5 игр за столом. Таким образом победитель и призеры будут определены по сумме набранных баллов.</p>",
            'image'       => '/uploads/img/vawaca-new-min.png',
            'created_at'  => "2017-04-03 21:09:52",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
