<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function login(Request $request)
    {
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            if (Hash::check($request->input('password'), $user->password)) {
                session(['user' => $user]);
                return redirect('/');
            } else {
                return back()->withErrors(['password' => 'Invalid password'])->withInput($request->input());
            }
        } else {
            return back()->withErrors(['email' => 'User not found'])->withInput($request->input());
        }
    }

    public function register(RegisterRequest $request)
    {
        // If RegisterRequest passes, create the user
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'displayName' => $request->input('displayName'),
            'type' => 'user'
        ]);
        session(['user' => $user]);
        return redirect('/');
    }
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
