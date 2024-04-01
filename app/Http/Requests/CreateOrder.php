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
        // validate here, các ô id trên form tạo
        return [
            'status' => 'required',
            'receiver_name' => 'required',
            'address' => 'required',
            'phone_number' => 'required',
            'customer_id' => 'required|exists:users,user_id',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'status.required' => 'The status field is required',
            'receiver_name.required' => 'The customer name field is required',
            'address.required' => 'The address field is required',
            'phone_number.required' => 'The phone number field is required',
            'customer_id.required' => 'The customer field is required',
            'customer_id.exists' => 'The customer doesnt exist',
        ];
    }
}
