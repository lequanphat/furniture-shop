<?php

namespace App\Http\Controllers;

use App\Models\User;

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
}
