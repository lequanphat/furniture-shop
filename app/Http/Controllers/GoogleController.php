<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        $user = Socialite::driver('google')->user();
        $finduser = User::where('email', $user->email)->first();
        if ($finduser) {
            Auth::login($finduser);
        } else {
            $newUser = User::create([
                'first_name' => $user->name,
                'last_name' => '',
                'email' => $user->email,
                'password' => Hash::make($user->id),
                'avatar' => $user->avatar,
                'is_staff' => false,
                'is_verified' => true,
                'is_active' => true,
            ]);
            Auth::login($newUser);
        }
        return redirect('/');
    }
}
