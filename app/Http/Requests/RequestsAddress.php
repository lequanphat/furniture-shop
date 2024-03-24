<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class RequestsAddress extends FormRequest
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
            'receiver_name' => 'required',
            'address' => 'required',
            'phone_number' => 'required|string|numeric',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'receiver_name.required' => 'First name field is required.',
            'address.max' => 'The address field is required.',
            'phone_number.max' => 'The phone number field is required.',
            'phone_number.numeric' => 'The phone number only contains number',
        ];
    }
}
