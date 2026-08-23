<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class EventsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('events')->insert([
            'slug'        => 'slug1',
            'title'       => 'The 1th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-20 21:09:51",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug2',
            'title'       => 'The 2th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-21 21:09:52",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug3',
            'title'       => 'The 3th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-22 21:09:53",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug4',
            'title'       => 'The 4th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-23 21:09:54",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug5',
            'title'       => 'The 5th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-23 21:09:55",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug6',
            'title'       => 'The 6th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-24 21:09:56",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug7',
            'title'       => 'The 7th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-25 21:09:57",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug8',
            'title'       => 'The 8th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-25 21:09:58",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('events')->insert([
            'slug'        => 'slug9',
            'title'       => 'The 9th Cup in Las Vegas',
            'description' => 'Twenty players with the best ranking will play 3 more games each in the second round on August 20. The best 10 players will play one FINAL game the same evening.',
            'image'       => '/uploads/elitefon.ru_17856.jpg',
            'text'        => '<p>1 WordPress, the premier free open-source blogging utility, has gone through several upgrades in its life. Today it&rsquo;s one of the most popular blogging tools on the Internet; it&rsquo;s easy to use, powerful, and very versatile. It also has a very active base of skilled users who are eager to improve the product and to help out those who haven&rsquo;t tried it before.</p><p>Though the Strayhorn 1.5 version is the favorite for many, it is not as stable or as secure as the newest version 2.0.3. The best part of the new version is the security patch; the new &ldquo;nonce&rdquo; security key reduces the chances of a malicious hacker finding a way into your admin panel. Besides the security patch, though, several minor bugs have been squashed with this version. Though a major upgrade to 2.1 is due out soon, the 2.0.3 is something you should definitely download and install if only because of the security fixes, which were actually backported from the major upgrade files.</p><p>In addition to the 2.0.3 install, you should be aware that some bugs have already been found, and that a plugin will need to be installed to repair those bugs. If you modify any of the files that this patch plugin fixes, you&rsquo;ll need to either merge the changes with the new files or make those changes manually once again. You can find these issues by running a diff to locate changes; if the only changes you find are your own, then you&rsquo;re fine, and otherwise you&rsquo;ll need to merge them manually into the new files.</p><p>The short list of what WordPress 2.0.3 fixes includes:</p>',
            'created_at'  => "2018-05-26 21:09:59",
            'updated_at'  => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('club_event')->insert(['event_id' => 1, 'club_id' => 1]);
        DB::table('club_event')->insert(['event_id' => 1, 'club_id' => 2]);
        DB::table('club_event')->insert(['event_id' => 2, 'club_id' => 2]);
        DB::table('club_event')->insert(['event_id' => 2, 'club_id' => 3]);
        DB::table('club_event')->insert(['event_id' => 3, 'club_id' => 3]);
        DB::table('club_event')->insert(['event_id' => 4, 'club_id' => 4]);
        DB::table('club_event')->insert(['event_id' => 5, 'club_id' => 5]);
        DB::table('club_event')->insert(['event_id' => 6, 'club_id' => 6]);
        DB::table('club_event')->insert(['event_id' => 6, 'club_id' => 1]);
//        DB::table('club_event')->insert(['event_id' => 7, 'club_id' => 7]);
//        DB::table('club_event')->insert(['event_id' => 8, 'club_id' => 8]);
//        DB::table('club_event')->insert(['event_id' => 9, 'club_id' => 9]);

    }
}
