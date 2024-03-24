<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Address;

class AddressController extends Controller
{
    public function update_address(Request $request)
    {
        $id= $request->input('address_id');
        $user_id=$request->route('id');
        $address=Address::find($id);
        if($address)
        {
           
            $default=$request->input('is_default');
            if($address->is_default==1&&$default==0)
            {
                return back()->withErrors(['is_default' => 'Must have 1 default address card'])->withInput($request->input());
            }
            if($address->is_default==0&&$default==1)
            {
                $defaultaddress = Address::where('user_id', $user_id)->where('is_default', 1)->first();
                $defaultaddress->update([
                    'is_default'=>0,
                ]);
            }
            $address->update([
                'receiver_name'=>$request->input('receiver_name'),
                'address'=>$request->input("address"),
                'phone_number'=>$request->input('phone_number'),
                'is_default'=>$default,
            ]);
            return ['message' => 'Updateted address  successfully!', 'address' => $address];
        }
    }
    public function address_user(Request $request)
    {
        $user_id=$request->route('user_id');
        return Address::where('user_id', $user_id)->get();
    }
    public function create_address(Request $request)
    {
        $address=Address::create([
            'receiver_name'=>$request->input('receiver_name'),
            'address'=>$request->input("address"),
            'phone_number'=>$request->input('phone_number'),
            'is_default'=>$request->input('is_default'),
            'user_id'=>$request->route('user_id'),
        ]);
        return ['message' => 'Created address  successfully!', 'address' => $address];
    }
}
