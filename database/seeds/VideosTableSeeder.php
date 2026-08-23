<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class VideosTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('video_galleries')->insert([
            'title'      => 'Video 1',
            'preview'    => '/build/img/v1.jpg',
            'id_youtube' => 'QyD4koQWVCk',
            'club_id'    => '1',
            'check_glob' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('video_galleries')->insert([
            'title'      => 'Video 2',
            'preview'    => '/build/img/v2.jpg',
            'id_youtube' => 'xX59JmrQHv4',
            'club_id'    => '3',
            'check_glob' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('video_galleries')->insert([
            'title'      => 'Video 3',
            'preview'    => '/build/img/v3.jpg',
            'id_youtube' => '089IRvkNAGg',
            'club_id'    => '3',
            'check_glob' => '1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
