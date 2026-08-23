<?php

use Illuminate\Database\Seeder;

class SlidesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('slides')->insert([
            'title'          => '6th MAF World Cup',
            'description'    => 'MAF World Cup in Las Vegas is an open annual tournament for all MAFIA players around the World.',
            'btn_text'       => 'Join MWC',
            'btn_link'       => 'http://mafworldcup.com/',
            'image'          => '/uploads/homepage/_MG_7548-min.jpg',
            'title_ru'       => '6-й ежегодный MAF World Cup',
            'description_ru' => 'MAF World Cup в Лас-Вегасе это открытый ежегодный турнир для игроков в мафию со всего мира.',
            'btn_text_ru'    => 'Присоединяйтесь',
        ]);

        DB::table('slides')->insert([
            'title' => 'History of World Cups',
            'description' => 'Mafia in Las Vegas? What a novel idea! But the mafiozi of our World Cup are not hiding from the law! Quite the opposite, they brag about their game and the best wins! Click on a link below to view a recap of each World Cup.',
            'btn_text' => 'Back in time',
            'btn_link' => 'http://mafworldcup.com/history.html',
            'image' => '/uploads/homepage/_MG_7715-min.jpg',
            'title_ru'       => 'История Кубков мира',
            'description_ru' => 'Мафия в Лас-Вегасе? Какая оригинальная идея! Но мафиози нашего чемпионата мира не скрывается от закона! Совсем наоборот, они хвастаются своей игрой и лучшими победами!',
            'btn_text_ru'    => 'Узнать',
        ]);

        DB::table('slides')->insert([
            'title' => '',
            'description' => 'The first friendly tournament between MAF clubs from VAncouver (Canada), Seattle (WAshington), San Francisco & Los Angeles (CAlifornia)',
            'btn_text' => 'FOLLOW',
            'btn_link' => 'http://mafiaclub.us/vawaca/',
            'image' => '/uploads/homepage/vawaca-banner.jpg',
            'title_ru'       => '',
            'description_ru' => 'Первый дружеский турнир между MAF-клубами из Ванкувера (Канада), Сиэтла (штат Вашингтон), Сан-Франциско и Лос-Анджелеса (Калифорния)',
            'btn_text_ru'    => 'Следовать',
        ]);

    }
}
