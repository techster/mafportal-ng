<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class TournamentsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('tournaments')->insert([
            'slug'        => 'slug1',
            'title'       => 'The 1th Annual MAF World Cup in Las Vegas',
            'preview'     => '/uploads/Bitmap11.jpg',
            'description' => 'He 1th Annual MAF World Cup will again take place at the incredible Wynn Las Vegas from August 18th to 23st. The games will be played in English and Russian. Each player will play 6 games in the first round on August 18 and 19. Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'table_ratings_id'  => "1",
            'created_at'  => "2018-04-01",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tournaments')->insert([
            'slug'        => 'slug2',
            'title'       => 'The 2th Annual MAF World Cup in Las Vegas',
            'preview'     => '/uploads/elitefon.ru_17856.jpg',
            'description' => 'He 2th Annual MAF World Cup will again take place at the incredible Wynn Las Vegas from August 18th to 23st. The games will be played in English and Russian. Each player will play 6 games in the first round on August 18 and 19. Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/Depos.jpg',
            'text'        => '<p>2 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-04-02",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tournaments')->insert([
            'slug'        => 'slug3',
            'title'       => 'The 3th Annual MAF World Cup in Las Vegas',
            'preview'     => '/uploads/Bitmap15.jpg',
            'description' => 'He 3th Annual MAF World Cup will again take place at the incredible Wynn Las Vegas from August 18th to 23st. The games will be played in English and Russian. Each player will play 6 games in the first round on August 18 and 19. Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>3 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-01",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tournaments')->insert([
            'slug'        => 'slug4',
            'title'       => 'The 4th Annual MAF World Cup in Las Vegas',
            'preview'     => '/uploads/Bitmap13.jpg',
            'description' => 'He 4th Annual MAF World Cup will again take place at the incredible Wynn Las Vegas from August 18th to 23st. The games will be played in English and Russian. Each player will play 6 games in the first round on August 18 and 19. Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/post.jpg',
            'text'        => '<p>4 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-02",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
    }
}
