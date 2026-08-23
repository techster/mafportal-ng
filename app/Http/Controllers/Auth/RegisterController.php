<?php

namespace App\Http\Controllers\Auth;

use App\Models\Club;
use App\User;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use PhpParser\Node\Expr\Cast\Object_;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use DB;
use Mail;
use Illuminate\Http\Request;
use App\Notifications\EmailVerification;
use Socialite;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function showRegistrationForm() {
        $clubs = Club::get();
        return view ('auth.register', compact('clubs'));
    }

    /**
     * Where to redirect users after login / registration.
     *
     * @var string
     */
    protected $redirectTo = '/account';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|max:255',
            'last_name' => 'required|max:255',
//            'nickname' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:1|confirmed',
            // 'g-recaptcha-response'=>'required|recaptcha'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        try{
            return User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'nickname' => $data['nickname'],
                'email' => $data['email'],
                'date' => $data['date'] == 'null' || $data['date'] == 'undefined' ?  NULL  : $data['date'],
                'password' => bcrypt($data['password']),
                'email_token' => "token_".str_random(20),
            ]);
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }
    }

    public function redirectToInstagram()
    {
        $appId = config('services.instagram.client_id');
        $redirectUri = urlencode(config('services.instagram.redirect'));
        return redirect()->to("https://api.instagram.com/oauth/authorize?app_id={$appId}&redirect_uri={$redirectUri}&scope=user_profile,user_media&response_type=code");
    }

    public function handleInstagramCallback(Request $request)
    {
        $code = $request->code;
        if (empty($code)) return redirect()->route('home')->with('error', 'Failed to login with Instagram.');

        $appId = config('services.instagram.client_id');
        $secret = config('services.instagram.client_secret');
        $redirectUri = config('services.instagram.redirect');

        $client = new Client();

        // Get access token
        $response = $client->request('POST', 'https://api.instagram.com/oauth/access_token', [
            'form_params' => [
                'app_id' => $appId,
                'app_secret' => $secret,
                'grant_type' => 'authorization_code',
                'redirect_uri' => $redirectUri,
                'code' => $code,
            ]
        ]);

        if ($response->getStatusCode() != 200) {
            return redirect()->route('home')->with('error', 'Unauthorized login to Instagram.');
        }

        $content = $response->getBody()->getContents();
        $content = json_decode($content);

        $accessToken = $content->access_token;

        // Get user info
        $response = $client->request('GET', "https://graph.instagram.com/me?fields=id,username,account_type&access_token={$accessToken}");

        $content = $response->getBody()->getContents();
            $oAuth = json_decode($content);

        try {

            $findUser = User::where('instagram_id', $oAuth->id)->first();

            if($findUser){

                Auth::login($findUser);

                return redirect('/');

            }else{

                $newUser = User::create([
                    'name' => $oAuth->username,
                    'last_name' => $oAuth->username,
                    'nickname'  => $oAuth->username,
                    'email' => $oAuth->username.'@'.$oAuth->id.'.com',
                    'instagram_id' => $oAuth->id,
                    'password' => Hash::make('instagram'),
                ]);

                Auth::login($newUser);

                return redirect('/');
            }

        } catch (Exception $e) {
            return redirect('auth/instagram');
        }

    }


    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {

            $user = Socialite::driver('google')->user();

            $findUserGoogleId = User::where('google_id', $user->id)->first();
            $findUserEmail = User::where('email', $user->user['email'])->first();

            if($findUserGoogleId || $findUserEmail){

                if($findUserGoogleId){
                    Auth::login($findUserGoogleId);
                }

                if($findUserEmail){
                    Auth::login($findUserEmail);
                }

               return redirect('/');

            }else{
                $findUser = User::where('email', $user->user['email'])->first();

                $newUser = User::create([
                    'name' => $user->user['given_name'],
                    'last_name' => $user->user['family_name'],
                    'email' => $user->user['email'],
                    'google_id' => $user->id,
                    'password' => Hash::make('google'),
                ]);

                Auth::login($newUser);

                return redirect('/');
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }


    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {

            $user = Socialite::driver('facebook')->user();

            $findUserFacebookId = User::where('facebook_id', $user->id)->first();
            $findUserEmail = User::where('email', $user->email)->first();

            if($findUserFacebookId || $findUserEmail){

                if($findUserFacebookId){
                    Auth::login($findUserFacebookId);
                }

                if($findUserEmail){
                    Auth::login($findUserEmail);
                }

                return redirect('/');

            }else{
                $findUser = User::where('email', $user->email)->first();

                $fullName = explode(" ", $user->name);

                $newUser = User::create([
                    'name' => $fullName[0],
                    'last_name' => $fullName[1],
                    'email' => $findUser ? 'f'.$user->email : $user->email,
                    'facebook_id' => $user->id,
                    'password' => Hash::make('facebook'),
                ]);

                Auth::login($newUser);

                return redirect('/');
            }

        } catch (Exception $e) {
            return redirect('auth/google');
        }
    }


    /**
     * Obtain the user information from Facebook.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        $mail = $request->email;
        $check = User::where('email', $mail)->get();

        if (isset($check[0])) {
            Auth::loginUsingId($check[0]->id);
            return "ok-log";
        }
        else {
            return 'reg';
        }


    }

    public function register(Request $request)
    {
        if($request->check == 'facebook') {

            $validator = $this->validator($request->all());
            if ($validator->fails())
            {
                $this->throwValidationException($request, $validator);
            }

            DB::beginTransaction();
            try
            {
                $user = $this->create($request->all());
                $id = User::where('email', $request->email)->get();
                if ($request->club == "" || $request->club == 'undefined') {

                }else {
                    DB::table('club_user')->insert(
                        ['user_id' => $id[0]->id, 'club_id' => $request->club, 'confirm' => 1, 'active' => 1 , 'admin' => 0]
                    );
                }

                $url_avatar = $request->avatar.'&height=200&width=200&ext='.$request->ext.'&hash='.$request->hash;
                $data = file_get_contents($url_avatar);
                $disk = "uploads";
                $destination_path = "users/avatar";
                $image_name= time().'.png';
                $path = public_path().'/'.$disk.'/'.$destination_path.'/'.$image_name;
                $db = '/'.$disk.'/'.$destination_path.'/'.$image_name;
                file_put_contents($path, $data);
                User::where('id',$id[0]->id)->update(['avatar' => $db]);

                $user->notify(new EmailVerification($user));
                DB::commit();
                return back();
            }
            catch(Exception $e)
            {
                DB::rollback();
                return back();
            }



        }
        else {
            $this->register_final($request);
        }
    }

    public function register_final(Request $request)
    {
        $validator = $this->validator($request->all());
        if ($validator->fails())
        {
            $this->throwValidationException($request, $validator);
        }

        DB::beginTransaction();
        try
        {
            $user = $this->create($request->all());
            if ($request->club == "" || $request->club == 'undefined') {

            }else {
                $id = User::where('email', $request->email)->get();

                DB::table('club_user')->insert(
                    ['user_id' => $id[0]->id, 'club_id' => $request->club, 'confirm' => 1, 'active' => 1 , 'admin' => 0]
                );
            }
            $user->notify(new EmailVerification($user));
            DB::commit();
            return back();
        }
        catch(Exception $e)
        {
            DB::rollback();
            return back();
        }
    }

}
