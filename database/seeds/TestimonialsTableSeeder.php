<?php

use Illuminate\Database\Seeder;

class TestimonialsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('testimonials')->insert([
            'name' => 'Armen Hagopjanian',
            'text' => 'First we had to come to Vegas, the Entertainment Capital of the World, next we had to establish our World Cup in one of the best casinos in the World... We like what we have now, but I\'d like to see over 100 players competing in our next World Cup. Guillaume have prestigious attachments to research groups at several universities around the world, also matching him to potential supervisors that worked in fields he was specifically interested in.',
            'image' => '/uploads/homepage/testimonials/armen_portrait.jpg',
        ]);
    }
}
