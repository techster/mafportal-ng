<?php

use Illuminate\Database\Seeder;

class MenuTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('menu_items')->insert([
            'name'       => 'CLUBS',
            'name_rus'   => 'КЛУБЫ',
            'type'       => 'internal_link',
            'link'       => 'clubs',
            'page_id'    => NULL,
            'lft'        => '2',
            'rgt'        => '3',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'THE GAME',
            'name_rus'   => 'ИГРА',
            'type'       => 'page_link',
            'link'       => 'the-game',
            'page_id'    => '1',
            'lft'        => '4',
            'rgt'        => '5',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'NEWS',
            'name_rus'   => 'НОВОСТИ',
            'type'       => 'internal_link',
            'link'       => 'news',
            'page_id'    => NULL,
            'lft'        => '6',
            'rgt'        => '7',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'TOURNAMENTS',
            'name_rus'   => 'ТУРНИРЫ',
            'type'       => 'internal_link',
            'link'       => 'tournaments',
            'page_id'    => NULL,
            'lft'        => '8',
            'rgt'        => '9',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'HISTORY',
            'name_rus'   => 'ИСТОРИЯ',
            'type'       => 'page_link',
            'link'       => 'history',
            'page_id'    => '2',
            'lft'        => '10',
            'rgt'        => '11',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'SHOP',
            'name_rus'   => 'МАГАЗИН',
            'type'       => 'internal_link',
            'link'       => 'shop',
            'page_id'    => NULL,
            'lft'        => '12',
            'rgt'        => '13',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'GALLERY',
            'name_rus'   => 'ГАЛЕРЕЯ',
            'type'       => 'internal_link',
            'link'       => 'gallery',
            'page_id'    => NULL,
            'lft'        => '14',
            'rgt'        => '15',
            'depth'      => '1',
        ]);

        DB::table('menu_items')->insert([
            'name'       => 'CONTACT',
            'name_rus'   => 'КОНТАКТЫ',
            'type'       => 'page_link',
            'link'       => 'contact',
            'page_id'    => '4',
            'lft'        => '16',
            'rgt'        => '17',
            'depth'      => '1',
        ]);

    }
}
