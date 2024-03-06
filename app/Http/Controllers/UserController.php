<?php

namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    //
    public function customers_ui()
    {
        $data = [
            'page' => 'Customers',
            'users' => User::where('is_staff', 1)->get()
        ];
        return view('admin.users.customers', $data);
    }
    public function employee_ui()
    {
        $data = [
            'page' => 'Employee',
            'users' => User::where('is_staff', 0)->get()
        ];
        return view('admin.users.employee', $data);
    }
}
