<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ProductsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 1',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 2',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 3',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 4',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 5',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!s',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('products')->insert([
            'title'       => 'Maf Cards - 6',
            'image'       => '/public/build/img/Bitmap9.jpg',
            'description' => 'Beautifully made cards so you can play the Maf game at your next Party or practice for the next World Cup!',
            'price'       => 15,
            'created_at'  => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
