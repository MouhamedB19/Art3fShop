<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SocialiteController extends Controller
{
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    public function callback()
    {
        $googleUser = Socialite::driver('google')->user();

        $user = User::firstOrCreate(
            ['email' => $googleUser->getEmail()],
            [
                'name' => $googleUser->getName(),
            ]
        );

        Auth::login($user);

        return redirect('/dashboard');
    }

    public function redirectFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }
    
    public function callbackFacebook()
    {
        $facebookUser = Socialite::driver('facebook')->user();
    
        $user = User::firstOrCreate(
            ['email' => $facebookUser->getEmail()],
            [
                'name' => $facebookUser->getName(),
            ]
        );
    
        Auth::login($user);
    
        return redirect('/dashboard');
    }
}
