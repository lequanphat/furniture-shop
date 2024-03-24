<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateCustomer;
use App\Http\Requests\UpdateEmployee;
use Illuminate\Http\Request;
use app\Models\User;

class ProfileController extends Controller
{
    private $user_controller;
    private $address_controller;
    public function __construct(UserController $user_controller,AddressController $address_controller)
    {
        $this->user_controller = $user_controller;
        $this->address_controller=$address_controller;
    }
    //
    public function user_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::where('user_id', $user_id)->first();
        if($user)
        {
            $data = [
                'page' => 'Profile',
                'user' => $user
            ];
        }
        return view("admin.profiles.profile",$data);
    }
    public function customer_ui(Request $request)
    {
        $user_id = $request->route('user_id');
        $user = User::where('user_id', $user_id)->first();
        $listaddress=$this->address_controller-> address_user($request);
        if($user)
        {
            $data = [
                'page' => 'Profile',
                'user' => $user,
                'address_cards'=>$listaddress 
            ];
        }
        return view("pages.account.profile",$data);
    }
    public function update_employee(Request $request)
    {
        $new_request= new UpdateEmployee( $request->all() );
        $result=$this->user_controller->update_employee($new_request);
        if($result instanceof RedirectResponse)
        {
            return $result;
        }
        $user=$result["user"];
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            if($file)
            {
                $path =$file->store('uploads/avatars', 'public');
                $user->update([
                    'avatar' => $path,
                ]);
            }
        }
        return $result;
       
    }
    public function update_customer(Request $request)
    {
        $new_request= new UpdateCustomer( $request->all() );
        $result=$this->user_controller->update_customer($new_request);
        return $result;
    }

}
