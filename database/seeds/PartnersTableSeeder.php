<?php

use Illuminate\Database\Seeder;

class PartnersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('partners')->insert([
            'name'       => 'Mafia Live',
            'logo'       => '/uploads/homepage/partners/mafia_live_logo_white.jpg',
            'link'       => 'http://mafia.live/',
        ]);

        DB::table('partners')->insert([
            'name'       => 'The Black Cat',
            'logo'       => '/uploads/homepage/partners/the_black_cat_logo.png',
            'link'       => 'http://mafiaclub.us/',
        ]);

        DB::table('partners')->insert([
            'name'       => 'Mafia Ratings',
            'logo'       => '/uploads/homepage/partners/mafia_ratings_logo.jpg',
            'link'       => 'http://mafiaratings.com',
        ]);

        DB::table('partners')->insert([
            'name'       => 'Maf Club Yerevan',
            'logo'       => '/uploads/homepage/partners/maf_club_yerevan.png',
            'link'       => 'http://mafclub.am',
        ]);
    }
}
