<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateEmployee;
use App\Http\Requests\UpdateEmployee;
use App\Http\Requests\UpdateCustomer;
use App\Models\Address;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{


    public function employee_ui()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $employee = User::where('is_staff', 1)
            ->when($type === 'active', function ($query) {
                $query->where('is_active', 1);
            })
            ->when($type === 'blocked', function ($query) {
                $query->where('is_active', 0);
            })
            ->whereNotIn('user_id', [Auth::user()->user_id])
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->with('default_address')
            ->paginate(6); // 6 elements per page

        $data = [
            'page' => 'Employee',
            'users' => $employee,
            'search' => $search,
            'type' => $type,
        ];
        return view('admin.users.employee', $data);
    }
    public function employee_pagination()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $employee = User::where('is_staff', 1)
            ->when($type === 'active', function ($query) {
                $query->where('is_active', 1);
            })
            ->when($type === 'blocked', function ($query) {
                $query->where('is_active', 0);
            })
            ->whereNotIn('user_id', [Auth::user()->user_id])
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->with('default_address')
            ->paginate(6); // 6 elements per page
        foreach ($employee as $user) {
            if ($user->created_at->diffInDays() < 7) {
                $user->new = true;
            }
        }
        $user = User::where('user_id', Auth::id())->first();
        $data = [
            'employee' => $employee,
            'can_update' => $user->can('update user'),
            'can_delete' => $user->can('delete user'),
        ];
        return response()->json($data);
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
            'avatar' => config('app.url') . 'images/default/default_avatar.jpg',
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
        $address = Address::create($addressData);

        $user->default_address = $address;

        // get permission from admin user
        $admin = User::where('user_id', Auth::id())->first();
        $data = [
            'message' => 'Created employee successfully!',
            'user' => $user,
            'address' => $address,
            'can_update' => $admin->can('update user'),
            'can_delete' => $admin->can('delete user'),
        ];
        // response
        return response()->json($data);
    }

    public function employee_details(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::where('user_id', $user_id)->with('default_address')->first();
        return response()->json(['user' => $user]);
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
    public function customer_details_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $data = [
            'page' => 'Customers',
            'user' => User::where('user_id', $user_id)->with('default_address')->first(),
        ];
        return view('admin.users.customer_details', $data);
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
                $user->default_address = $address;
                if ($user->created_at->diffInDays() < 7) {
                    $user->new = true;
                }
                // response

                // get permission from admin user
                $admin = User::where('user_id', Auth::id())->first();
                $data = [
                    'message' => 'Updateted employee successfully!',
                    'user' => $user,
                    'address' => $address,
                    'can_update' => $admin->can('update user'),
                    'can_delete' => $admin->can('delete user'),
                ];
                return response()->json($data);
            }
            return back()->withErrors(['address' => 'Address not found.'])->withInput($request->input());
        }
        return back()->withErrors(['email' => 'User not found.'])->withInput($request->input());
    }
    public function update_customer(UpdateCustomer $request)
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
                return ['message' => 'Updateted customer successfully!', 'user' => $user];
            }
            return back()->withErrors(['address' => 'Address not found.'])->withInput($request->input());
        }
        return back()->withErrors(['email' => 'User not found.'])->withInput($request->input());
    }
    public function customers_ui()
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $customers = User::where('is_staff', 0)
            ->when($type === 'active', function ($query) {
                $query->where('is_active', 1);
            })
            ->when($type === 'blocked', function ($query) {
                $query->where('is_active', 0);
            })
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->with('default_address')
            ->paginate(6); // 6 elements per page
        foreach ($customers as $user) {
            if ($user->created_at->diffInDays() < 7) {
                $user->new = true;
            }
        }

        $data = [
            'page' => 'Customers',
            'users' => $customers,
            'search' => $search,
            'type' => $type,
        ];
        return view('admin.users.customers', $data);
    }
    public function customers_pagination(Request $request)
    {
        $search = request()->query('search');
        $type = request()->query('type');
        $customers = User::where('is_staff', 0)
            ->when($type === 'active', function ($query) {
                $query->where('is_active', 1);
            })
            ->when($type === 'blocked', function ($query) {
                $query->where('is_active', 0);
            })
            ->where(function ($query) use ($search) {
                $query->where('first_name', 'like', '%' . $search . '%')
                    ->orWhere('last_name', 'like', '%' . $search . '%')
                    ->orWhere('email', 'like', '%' . $search . '%');
            })
            ->with('default_address')
            ->paginate(6); // 6 elements per page
        foreach ($customers as $user) {
            if ($user->created_at->diffInDays() < 7) {
                $user->new = true;
            }
        }
        $user = User::where('user_id', Auth::id())->first();
        $data = [
            'customers' => $customers,
            'can_delete' => $user->can('delete user'),
        ];
        return response()->json($data);
    }
}
