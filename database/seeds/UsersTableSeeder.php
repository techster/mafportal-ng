<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'Denis',
            'last_name' => 'Kych',
            'date' => '2017-04-01',
            'email' => 'kychd@mail.ru',
            'password' => '$2y$10$OdSM.IwqH.q./7bdtZlXGOTTxUPUddLwcA7j8hlL3.MOkDyb6D8ze',
            'verified' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'Mafia',
            'last_name' => 'Maf',
            'date' => '2017-04-01',
            'email' => 'mafia@mafia.com',
            'password' => '$2y$10$wYx6IT7/UvcTlXvYLg7kV.loppABzPEw.vO34YpFYSQOyHRaJrowO',
            'verified' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'mes',
            'last_name' => 'mes',
            'date' => '2017-04-01',
            'email' => 'M_E_S@inbox.ru',
            'password' => '$2y$10$8..vZXQ2I94ji2uhpuooKuEUMSVC/Al4RMc.JrmOwUCMRop.FEMxq',
            'verified' => '1',
        ]);

        DB::table('club_user')->insert([
            'user_id' => '1',
            'club_id' => '1',
            'confirm' => '1',
            'active' => '1',
            'admin' => '1',
        ]);

        if( Schema::hasTable('customer_entity') and Schema::hasTable('customer_entity_varchar') ){
            $cms_page = DB::table('customer_entity')->get();
            foreach($cms_page as $key => $item){
                $user = new User;
                $user->email     = $item->email;
                $user->name      = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 5)->first()->value;
                $user->last_name = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 7)->first()->value;
                $user->password  = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 12)->first()->value;
                $user->verified  = "1";
                $user->save();

                if($item->group_id == 5) {$club_id = 1;  $active = 1;}
                if($item->group_id == 6) {$club_id = 10; $active = 1;}
                if($item->group_id == 7) {$club_id = 6;  $active = 1;}
                if($item->group_id == 8) {$club_id = 1;  $active = 0;}
                if($item->group_id == 9) {$club_id = 5;  $active = 0;}
                if($item->group_id == 10){$club_id = 6;  $active = 0;}
                if($item->group_id == 11){$club_id = 2;  $active = 1;}
                if($item->group_id == 12){$club_id = 5;  $active = 1;}
                if($item->group_id == 13){$club_id = 7;  $active = 1;}
                if($item->group_id == 14){$club_id = 8;  $active = 1;}
                if($item->group_id == 15){$club_id = 3;  $active = 1;}

                if(isset($club_id) && isset($active) && $active){
                    $user->clubs()->attach([$club_id], ['active' => $active]);
                }
            }
        }

        DB::table('users')->insert([
            'name' => 'Pavel',
            'last_name' => 'Lagutin',
            'date' => '1979-07-20',
            'email' => 'pavel.lagutin@gmail.com',
            'password' => '$2y$10$Lct4kmha7rQOcDvI8aJZG.g324sykLM/oVtLrcj0.o5Bi6cvvl7Tm',
            'verified' => '1',
        ]);
        DB::table('users')->insert([
            'name' => 'Mikael',
            'last_name' => 'Ayrapetyan',
            'date' => '2017-04-05',
            'email' => 'ayrapetyanmg@gmail.com',
            'password' => '$2y$10$swPwNaJxULvB.3W9t4FcVuJjDThmmHix8k0PW0K0Q8yfF941F9bvG',
            'verified' => '1',
        ]);

    }
}
