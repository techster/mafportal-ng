<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
         $this->call(CountriesTableSeeder::class);
         $this->call(ClubsTableSeeder::class);
         $this->call(UsersTableSeeder::class);
         $this->call(PermissionsTableSeeder::class);
         $this->call(MenuTableSeeder::class);
         $this->call(NewsTableSeeder::class);
         $this->call(PagesTableSeeder::class);
         $this->call(PartnersTableSeeder::class);
         $this->call(PhotosTableSeeder::class);
         $this->call(SlidesTableSeeder::class);
         $this->call(TestimonialsTableSeeder::class);
         $this->call(TournamentsTableSeeder::class);
         $this->call(EventsTableSeeder::class);
         $this->call(VideosTableSeeder::class);
         $this->call(TableRatingsTableSeeder::class);
         $this->call(GameRatingTableSeeder::class);
         $this->call(ProductsTableSeeder::class);
    }
}
