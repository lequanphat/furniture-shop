<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    public function loginView()
    {
        return view('auth.login');
    }
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
    public function registerView()
    {
        return view('auth.register');
    }
    public function register(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'displayName' => 'required|alpha_spaces|min:8|max:40',
        ];

        $messages = [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'displayName.required' => 'The display name field is required.',
            'displayName.min' => 'The display must be at least 8 characters.',
            'displayName.max' => 'The display name must not exceed 40 characters.',
        ];

        Validator::extend('alpha_spaces', function ($attribute, $value, $parameters, $validator) {
            return preg_match('/^[\pL\s]+$/u', $value);
        }, 'The :attribute must contain only letters and spaces.');

        $validator = Validator::make($request->all(), $rules, $messages);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput($request->input());
        }
        // If validation passes, create the user
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'displayName' => $request->input('displayName'),
            'type' => 'user'
        ]);
        // $user->assignRole('user');
        session(['user' => $user]);
        return redirect('/');
    }
    public function logout()
    {
        session()->flush();
        return redirect('/login');
    }
}
