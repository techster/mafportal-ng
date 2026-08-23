<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestController extends Controller
{
    public function index()
    {
        $cms_page = DB::table('customer_entity')->get();


//        foreach($cms_page as $key => $item){
//            $user = new User;
//            $user->email     = $item->email;
//            $user->name      = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 5)->first()->value;
//            $user->last_name = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 7)->first()->value;
//            $user->password  = DB::table('customer_entity_varchar')->where("entity_id", $item->entity_id)->where("attribute_id", 12)->first()->value;
//            $user->save();
//        }


        return view('test', [
            'cms_page' => $cms_page
        ]);
    }
}
