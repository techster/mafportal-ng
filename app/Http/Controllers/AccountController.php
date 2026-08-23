<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\Game_rating;
use App\User;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AccountController extends Controller
{
	public function performLogout () {

		Auth::logout();
        Cart::destroy();
		return redirect(route('home'));
	}

	public function index()
    {
        return view('account', [

        ]);
    }

    public function edit_account(Request $request)
    {

        if($request->name != 'undefined')      Auth::user()->name = $request->name;
        if($request->email != 'undefined')     Auth::user()->email = $request->email;
        if($request->last_name != 'undefined') Auth::user()->last_name = $request->last_name;
        if($request->nickname != 'undefined')  Auth::user()->nickname = $request->nickname;
//        if($request->date != 'undefined')      Auth::user()->date = $request->date;


        if($request->date == 'null' || $request->date == 'undefined'){
            $date = NULL;
        }else{
            $date = $request->date;
        }

        Auth::user()->date = $date;

        if($request->password != 'undefined' && $request->password == $request->password_confirmation){
            Auth::user()->password = Hash::make($request->password);
        }



        Auth::user()->save();
    }

    public function clubs()
    {
        $current_clubs = Auth::user()->clubs;
        $other_clubs = Club::whereDoesntHave('users', function ($query) {
            $query->where('id', Auth::user()->id);
        })->get();
        return view('account_clubs', [
            'current_clubs' => $current_clubs,
            'other_clubs' => $other_clubs,
        ]);
    }

    public function apple_club(Request $request)
    {
        Auth::user()->clubs()->attach($request->club, ['confirm' => 0]);
        return back();
    }

    public function balance()
    {
        return view('account_balance', [
            'countrylist' => app('App\Http\Controllers\PaymentController')->countrylist(),
        ]);
    }


    public function games()
    {
        $gameRatings = Game_rating::where('results', 'like', '%' . Auth::user()->id . '%')->paginate(50);

        return view('games', compact('gameRatings'));
    }

    public function imageCropPost(Request $request)
    {
        $data = $request->image;

        if (strlen($data) > 2000){

            $disk = "uploads";
            $destination_path = "users/avatar";

            list($type, $data) = explode(';', $data);
            list(, $data)      = explode(',', $data);


            $data = base64_decode($data);
            $image_name= time().'.png';
            $path = public_path().'/'.$disk.'/'.$destination_path.'/'.$image_name;
            $db = '/'.$disk.'/'.$destination_path.'/'.$image_name;

            file_put_contents($path, $data);

            DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['avatar' => $db]);

            return response()->json(['success'=>true]);

        } else {
            return response()->json(['success'=>false]);
        }


    }

    public function imageDelete(Request $request) {

        $user = auth()->user();

        if (file_exists(public_path($user->avatar))) {
            unlink(public_path($user->avatar));
        }

        DB::table('users')
            ->where('id', $user->id)
            ->update(['avatar' => null]);

        return response()->json(['success'=>true]);
    }

}
