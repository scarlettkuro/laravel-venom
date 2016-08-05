<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Socialite;

class AuthController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from GitHub.
     *
     * @return Response
     */
    public function handleProviderCallback(Request $request)
    {
        try {
            $oauthUser = Socialite::driver('google')->user();
        }
        catch (\Exception $e) {
             dd($e);
        }

        $user = $this->findOrCreateUser($oauthUser);
        
        //$user->save();
        
        //dd($user);

        Auth::login($user, true);
        //dd(Auth::getSession());
        //\Session::save();
        
        //Auth::loginUsingId($user->id, true);
        
        //dd(Auth::check());
      //dd(Auth::user());
        
        return redirect()->intended('/');
    }
    
    /**
     * Return user if exists; create and return if doesn't
     *
     * @param $oauthUser Google Data
     * @return User
     */
    private function findOrCreateUser($oauthUser)
    {
        $user = User::where('id', $oauthUser->id)->first();
        if ($user != NULL) {
            
            return $user;
        }
            //dd($user);
        
        $user = new User();
        $user->id = $oauthUser->id;
        $user->name = $oauthUser->name;
        $user->nickname = explode('@', $oauthUser->email)[0];
        $user->save();
        return $user;
    }
}
