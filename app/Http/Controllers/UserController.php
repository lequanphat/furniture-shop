<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployee;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function customers_ui()
    {
        $data = [
            'page' => 'Customers',
            'users' => User::where('is_staff', 0)->get()
        ];
        return view('admin.users.customers', $data);
    }

    public function employee_ui()
    {
        $data = [
            'page' => 'Employee',
            'users' => User::where('is_staff', 1)->whereNotIn('user_id', [Auth::user()->user_id])->get()
        ];
        return view('admin.users.employee', $data);
    }

    public function create_employee(CreateEmployee $request)
    {
        // create user
        $userData = [
            'email' => $request->input('email'),
            'password' => Hash::make('123456'), // default password for new employee is 123456
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => ($request->input('gender') == 'female') ? 0 : 1,
            'birth_date' => $request->input('birth_date'),
            'is_staff' => 1,
            'is_verified' => 1,
        ];
        $user = User::create($userData);

        // create address
        $addressData = [
            'user_id' => $user->user_id,
            'receiver_name' => $user->first_name . ' ' . $user->last_name,
            'address' => $request->input('address'),
            'phone_number' => $request->input('phone_number'),
            'is_default' => 1,
        ];
        Address::create($addressData);

        // response
        return ['message' => 'Created employee successfully!', 'user' => $user];
    }

    public function employee_details_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $data = [
            'page' => 'Employee',
            'action' => 'Details' . $user_id
        ];
        return view('admin.users.employee_details', $data);
    }

    public function update_employee_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $data = [
            'page' => 'Employee',
            'action' => 'Update' . $user_id
        ];
        return view('admin.users.update_employee', $data);
    }

    public function ban_user(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::find($user_id);
        if ($user) {
            $user->update([
                'is_active' => false,
            ]);
        }
        // response
        return redirect('/admin/employee');
    }

    public function unban_user(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::find($user_id);
        if ($user) {
            $user->update([
                'is_active' => true,
            ]);
        }
        // response
        return redirect('/admin/employee');
    }
}
