<?php

namespace App\Http\Controllers;

use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class FacebookController extends Controller
{
    public function redirectToFacebook()
    {
        return Socialite::driver('facebook')->redirect();
    }

    public function handleFacebookCallback()
    {
        try {
            $user = Socialite::driver('facebook')->user();
            $finduser = User::where('email', $user->id . '@facebook.com')->first();
            if ($finduser) {
                Auth::login($finduser);
            } else {
                $newUser = User::create([
                    'first_name' => $user->name,
                    'last_name' => '',
                    'email' => $user->id . '@facebook.com',
                    'password' => Hash::make($user->id),
                    'avatar' => $user->avatar,
                    'is_staff' => false,
                    'is_verified' => true,
                    'is_active' => true,
                ]);

                Auth::login($newUser);
            }
            return redirect('/');
        } catch (\Throwable $th) {
            abort(500, $th->getMessage());
        }
    }
}
