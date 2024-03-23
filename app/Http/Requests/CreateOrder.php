<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrder extends FormRequest
{

    public function authorize(): bool
    {
        // check permission here
        return true;
    }
    public function rules()
    {
        // validate here
        return [
            'totalPrice' =>'required',
            'paid'=> 'required',
            'customer'=> 'required|exists:users,user_id',
            'status' => 'required',
            'created_by'=> 'required|exists:users,user_id',
            'created_at' => 'required',
            'recipient_name' => 'required',
            'address' => 'required',
            'phone_number'=> 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'totalPrice.required'=> 'The total price field is required',
            'paid.required' => 'Paid money field is required',
            'customer.required'=> 'The customer field is required',
            'customer.exists'=> 'The customer doesnt exist',
            'status.required'=> 'The status field is required',
            'created_by.required'=> 'The employee field is required',
            'created_by.exists'=> 'The employee doesnt exist',
            'created_at.required' => 'The create at field is required',
            'recipient_name.required' => 'The recipient field is required',
            'address.required' => 'The address field is required',
            'phone_number.required'=> 'The phone number field is required',
        ];
    }
}
