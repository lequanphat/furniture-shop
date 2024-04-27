<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangePassword;
use App\Http\Requests\UpdateEmployee;
use App\Models\Address;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller

{
    public function index()
    {
        return view('admin.settings.index');
    }

    public function update_profile(UpdateEmployee $request)
    {
        $user = User::where('user_id', Auth::id())->first();
        $user->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'gender' => ($request->input('gender') == 'male' || $request->input('gender') == null),
            'birth_date' => $request->input('birth_date'),
        ]);

        $address = Address::where('user_id', $user->user_id)->where('is_default', 1)->first();
        if ($address) {
            $address->update([
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
            ]);
        } else {
            Address::create([
                'user_id' => $user->user_id,
                'address' => $request->input('address'),
                'phone_number' => $request->input('phone_number'),
                'receiver_name' => $request->input('first_name') . ' ' . $request->input('last_name'),
                'is_default' => 1,
            ]);
        }

        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $path = config('app.url') . 'storage/' . $file->store('uploads/avatars', 'public');
            $user->update(['avatar' => $path]);
        }
        return response()->json(['message' => 'Profile updated successfully!']);
    }

    public function changePasswordUI()
    {
        return view('admin.settings.change-password');
    }

    public function changePassword(ChangePassword $request)
    {

        $user = User::where('user_id', Auth::id())->first();
        if (Hash::check($request->input('password'), $user->password)) {
            $user->update([
                'password' => Hash::make($request->input('new_password')),
            ]);
            return response()->json(['message' => 'Password changed successfully!']);
        }
        return response()->json(['errors' => ['message' => ['Password is invalid']]], 400);
    }
}
