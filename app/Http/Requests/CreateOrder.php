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
            'phone_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
            'customer_id' => 'required',
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
            'phone_number.regex' => 'The phone number format is invalid',
            'customer_id.required' => 'The customer field is required',

        ];
    }
}
