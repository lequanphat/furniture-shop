<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return view('admin.users.index', compact('users'));
    }
    public function user1()
    {
        return view('admin.users.user1');
    }
    public function createUser(Request $request)
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
            return back()
                ->withErrors($validator)
                ->withInput($request->input());
        }

        // If validation passes, create the user
        $user = User::create([
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'displayName' => $request->input('displayName')
        ]);
        $user->assignRole('admin');
        return back();
    }
    public function deleteUser(Request $request, string $id)
    {
        $user = User::find($id);
        $user->delete();
        return back();
    }
}
