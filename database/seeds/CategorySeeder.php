<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            [
                'name' => 'First',
                'number' => 1,
            ],

            [
                'name' => 'Second',
                'number' => 2,
            ],

            [
                'name' => 'Third',
                'number' => 3,
            ]
        ]);
    }
}
