<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Socialite;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OAuthController extends Controller
{
    /**
  * Redirect the user to the Google authentication page.
  *
  * @return \Illuminate\Http\Response
  */
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->with(["prompt" => "select_account"])->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return \Illuminate\Http\Response
     */
    public function handleProviderCallback(Request $request, $provider)
    {
        $state = $request->get('state');
        $request->session()->put('state',$state);

        if(Auth::check()==false){
            session()->regenerate();
        }
        
        $u = Socialite::driver($provider)->user();
        $user = User::where('email', $u->email)->first();

        if($user){
            Auth::login($user, true);
        } else {
            // Get next ID
            $statement = DB::select("show table status like 'users'");
            $id = $statement[0]->Auto_increment;
            $names = explode(' ', $u->name);

            // create a new user
            $user = new User;
            $user->firstname = $names[0];
            $user->lastname = (count($names) > 1) ? $names[1] : '';
            $user->username = 'beast_' . $id;
            $user->email = $u->email;
            $user->provider_id = $u->id;
            $user->provider = $provider;
            $user->avatar = NULL;
            $user->provider_avatar = $u->avatar_original;

            $user->save();
            Auth::login($user, true);
        }

        return redirect('/home');

        // try {
        //     $user = Socialite::driver($provider)->user();
        // } catch (\Exception $e) {
        //     return redirect('/login');
        // }

        // // only allow people with @company.com to login
        // if(explode("@", $user->email)[1] !== 'company.com'){
        //     return redirect()->to('/');
        // }
        // // check if they're an existing user
        // $existingUser = User::where('email', $user->email)->first();
        // if($existingUser){
        //     // log them in
        //     auth()->login($existingUser, true);
        // } else {
        //     // create a new user
        //     $newUser                  = new User;
        //     $newUser->name            = $user->name;
        //     $newUser->email           = $user->email;
        //     $newUser->google_id       = $user->id;
        //     $newUser->avatar          = $user->avatar;
        //     $newUser->avatar_original = $user->avatar_original;
        //     $newUser->save();            auth()->login($newUser, true);
        // }
        // return redirect()->to('/home');
    }
}