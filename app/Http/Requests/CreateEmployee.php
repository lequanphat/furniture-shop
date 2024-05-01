<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class CreateEmployee extends FormRequest
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
            'email' => 'required|email|unique:users,email',
            'gender' => 'required',
            'address' => 'required',
            'birth_date' => 'required|date',
            'phone_number' => ['required', 'regex:/^0[0-9]{9,10}$/'],
            'first_name' => ['required', 'min:2', 'max:20', new AlphaSpace()],
            'last_name' => ['required', 'min:2', 'max:20', new AlphaSpace()],
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'first_name.required' => 'First name field is required.',
            'first_name.min' => 'First name must be at least 8 characters.',
            'first_name.max' => 'First name must not exceed 20 characters.',
            'last_name.required' => 'Last name field is required.',
            'last_name.min' => 'Last must be at least 8 characters.',
            'last_name.max' => 'Last name must not exceed 20 characters.',
            'gender.max' => 'The gender field is required.',
            'address.max' => 'The address field is required.',
            'birth_date.max' => 'The birth date field is required.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.regex' => 'The phone number format is invalid.',
        ];
    }
}
