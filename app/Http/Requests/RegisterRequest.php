<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
            'email' => 'required|email',
            'password' => 'required|min:6|max:20',
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
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'first_name.required' => 'First name field is required.',
            'first_name.min' => 'First name must be at least 8 characters.',
            'first_name.max' => 'First name must not exceed 20 characters.',
            'last_name.required' => 'Last name field is required.',
            'last_name.min' => 'Last must be at least 8 characters.',
            'last_name.max' => 'Last name must not exceed 20 characters.',
        ];
    }
}
