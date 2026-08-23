<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class PhotosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('photo_galleries')->insert([
            'title'      => 'Mafia World Cup 2014',
            'slug'       => 'wmc2014',
            'preview'    => '/uploads/gallery/mwc2014/slider_2.jpg',
            'photos'     => '',
            'club_id'    => 1,
            'check_glob' => 1,
            'created_at'  => '2017-04-03 21:09:51',
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('photo_galleries')->insert([
            'title'      => 'Mafia World Cups 2012-2014',
            'slug'       => 'mwc2012',
            'preview'    => '/uploads/gallery/mwc_history/17521898_1622828757732413_1904289643_o.jpg',
            'photos'     => '',
            'club_id'    => NULL,
            'check_glob' => 1,
            'created_at'  => "2017-04-09 02:43:56",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);


        DB::table('photo_galleries')->insert([
            'title'      => 'World Championships in Erevan',
            'slug'       => 'wmc_armenia_history',
            'preview'    => '/uploads/gallery/mwc_armenia_history/17521877_1622845187730770_197734048_o.jpg',
            'photos'     => '',
            'club_id'    => 6,
            'check_glob' => 1,
            'created_at'  => "2017-04-09 03:26:26",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
