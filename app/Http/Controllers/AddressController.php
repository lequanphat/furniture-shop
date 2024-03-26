<?php

namespace App\Http\Controllers;

use App\Http\Requests\RequestsAddress;
use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function update_address(RequestsAddress $request)
    {
        $id = $request->input('address_id');

        $address = Address::find($id);
        if ($address) {
            $user_id = $address->user_id;
            $default = $request->input('is_default');
            if ($address->is_default != $default) {
                if ($default == true) {
                    $defaultaddress = Address::where('user_id', $user_id)->where('is_default', 1)->first();
                    if ($defaultaddress) {
                        $defaultaddress->update([
                            'is_default' => false,
                        ]);
                    }
                    $address->update([
                        'is_default' => true,
                    ]);
                } else {
                    $message = 'Need 1 default card ';
                    abort(400, $message);
                }
            }
            $address->update([
                'receiver_name' => $request->input('receiver_name'),
                'address' => $request->input("address"),
                'phone_number' => $request->input('phone_number'),
            ]);
            return ['message' => 'Updateted address  successfully!', 'address' => $address];
        }
    }
    public function address_user(Request $request)
    {
        $user_id = $request->route('user_id');
        return Address::where('user_id', $user_id)
            ->orderBy('is_default', 'desc')->get();
    }
    public function create_address(RequestsAddress $request)
    {
        $address = Address::create([
            'receiver_name' => $request->input('receiver_name'),
            'address' => $request->input("address"),
            'phone_number' => $request->input('phone_number'),
            'is_default' => 0,
            'user_id' => $request->input("user_id"),
        ]);
        return ['message' => 'Created address  successfully!', 'address' => $address];
    }
}
