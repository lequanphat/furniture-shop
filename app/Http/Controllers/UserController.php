<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Models\Address;
use App\Models\Category;
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
            'users' => User::where('is_staff', 0)->paginate(6) // 6 elements per page
        ];
        return view('admin.users.customers', $data);
    }

    public function employee_ui()
    {
        $data = [
            'page' => 'Employee',
            'users' => User::where('is_staff', 1)
                ->whereNotIn('user_id', [Auth::user()->user_id])
                ->with('default_address')
                ->paginate(6) // 6 elements per page
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
            'gender' => ($request->input('gender') == 'male'),
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
            'user' => User::where('user_id', $user_id)->with('default_address')->first(),
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
        return back();
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
        return back();
    }

    public function update_employee(UpdateEmployee $request)
    {
        // check existed user
        $user = User::where('email', $request->input('email'))->first();
        if ($user) {
            $user->update([
                'first_name' => $request->input('first_name'),
                'last_name' => $request->input('last_name'),
                'gender' => ($request->input('gender') == 'male'),
                'birth_date' => $request->input('birth_date'),
            ]);

            $address = Address::where('user_id', $user->user_id)->where('is_default', 1)->first();
            if ($address) {
                $address->update([
                    'address' => $request->input('address'),
                    'phone_number' => $request->input('phone_number'),
                ]);
                // response
                return ['message' => 'Updateted employee successfully!', 'user' => $user];
            }
            return back()->withErrors(['address' => 'Address not found.'])->withInput($request->input());
        }
        return back()->withErrors(['email' => 'User not found.'])->withInput($request->input());
    }
}
