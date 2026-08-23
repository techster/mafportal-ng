<?php

use Illuminate\Database\Seeder;

class CountriesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('countries')->insert([
            'title' => 'USA',
            'description' => 'The Los Angeles Maf Club returns to ROMANOV restaurant in Studio City, California every Thursday from 8 pm to 2 am.',
            'image' => '/uploads/Bitmap.jpg',
        ]);
        DB::table('countries')->insert([
            'title' => 'Russia',
            'description' => 'Although there are plenty of different clubs in Moscow, where the Mafia game is played, only few of them are associated with the International MAF Corporation. Only members of Maf Club Cocktail-Dynasty are allowed to sign-in here.',
            'image' => '/uploads/Bitmap2.jpg',
        ]);
        DB::table('countries')->insert([
            'title' => 'Armenia',
            'description' => 'MAF Club Yerevan was the first in the system of MAF Clubs established in 1996. It was declared an exclusive and  closed club in 1998. The Maf Club Yerevan is located on the second floor of the Cinema House at 18 Vardanants Street and open every Friday and Saturday.',
            'image' => '/uploads/Bitmap3.jpg',
        ]);
        DB::table('countries')->insert([
            'title' => 'Ukraine',
            'description' => 'The best Maf Club in Kiev - Big Ben - offers free games of Mafia daily! It also holds bi-monthly "masters" tournaments. Interestingly enough, a small city of Khmelnitski has one of the most active and entertaining clubs in Ukraine.',
            'image' => '/uploads/Bitmap4.jpg',
        ]);
    }
}
