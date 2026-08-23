<?php

use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('permissions')->insert(['name' => 'menu item']);
        DB::table('permissions')->insert(['name' => 'club']);
        DB::table('permissions')->insert(['name' => 'country']);
        DB::table('permissions')->insert(['name' => 'news']);
        DB::table('permissions')->insert(['name' => 'page']);
        DB::table('permissions')->insert(['name' => 'partner']);
        DB::table('permissions')->insert(['name' => 'slide']);
        DB::table('permissions')->insert(['name' => 'testimonial']);
        DB::table('permissions')->insert(['name' => 'role']);
        DB::table('permissions')->insert(['name' => 'user']);
        DB::table('permissions')->insert(['name' => 'tournament']);
        DB::table('permissions')->insert(['name' => 'permission']);
        DB::table('permissions')->insert(['name' => 'photo gallery']);
        DB::table('permissions')->insert(['name' => 'event']);
        DB::table('permissions')->insert(['name' => 'video gallery']);
        DB::table('permissions')->insert(['name' => 'table rating']);
        DB::table('permissions')->insert(['name' => 'game rating']);
        DB::table('permissions')->insert(['name' => 'product']);
        DB::table('permissions')->insert(['name' => 'order']);
        //================================
        //================================
        DB::table('roles')->insert(['name' => 'Technical Admin']);
        DB::table('roles')->insert(['name' => 'Portal Admin']);
        DB::table('roles')->insert(['name' => 'Club Admin']);
        DB::table('roles')->insert(['name' => 'Player']);
        //================================
        //================================
        DB::table('permission_roles')->insert(['permission_id' => 1, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 2, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 3, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 4, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 5, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 6, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 7, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 8, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 9, 'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 10,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 11,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 12,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 13,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 14,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 15,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 16,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 17,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 18,'role_id' => 1]);
        DB::table('permission_roles')->insert(['permission_id' => 19,'role_id' => 1]);
        //================================
        //================================
        DB::table('permission_roles')->insert(['permission_id' => 1, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 4, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 5, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 6, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 7, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 8, 'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 10,'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 11,'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 13,'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 14,'role_id' => 2]);
        DB::table('permission_roles')->insert(['permission_id' => 15,'role_id' => 2]);
        //================================
        //================================
        DB::table('permission_roles')->insert(['permission_id' => 2,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 10,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 13,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 14,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 15,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 16,'role_id' => 3]);
        DB::table('permission_roles')->insert(['permission_id' => 17,'role_id' => 3]);
        //================================
        //================================
        DB::table('role_users')->insert(['role_id' => 1,'user_id' => 1]);
        DB::table('role_users')->insert(['role_id' => 1,'user_id' => 2]);
        DB::table('role_users')->insert(['role_id' => 1,'user_id' => 3]);
    }
}
