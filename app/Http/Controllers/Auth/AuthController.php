<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Routing\Controller;
use Auth;
use Socialite;
use Request;

class AuthController extends Controller
{
    /**
     * Redirect the user to the Google authentication page.
     *
     * @return Response
     */
    public function login()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Obtain the user information from Google.
     *
     * @return Response
     */
    public function auth()
    {
        try {
            $oauthUser = Socialite::driver('google')->user();
        }
        catch (\Exception $e) {
             dd($e);
        }

        $user = $this->findOrCreateUser($oauthUser);

        Auth::login($user, true);
        
        return redirect()->route('blog', ['nickname' => $user->nickname ]);
    }

    /**
     * Logout from Venom.
     *
     * @return Response
     */
    public function logout()
    {
        Auth::logout();
        
        return redirect()->route('home');
    }

    /**
     * Update user info.
     *
     * @return Response
     */
    public function updateUser()
    {
        Auth::user()->name = Request::input('name');
        Auth::user()->nickname = Request::input('nickname');
        Auth::user()->theme_id = Request::input('theme_id');
        Auth::user()->save();
        
        return redirect()->route('blog', ['nickname' => Auth::user()->nickname ]);
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
        
        $user = new User([
            'id' => $oauthUser->id,
            'name' => $oauthUser->name,
            'nickname' => explode('@', $oauthUser->email)[0]
        ]);
        $user->save();
        
        return $user;
    }
}
