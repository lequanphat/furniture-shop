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
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6|max:20',
            'displayName' => ['required', 'min:8', 'max:40', new AlphaSpace()],
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already taken.',
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'displayName.required' => 'The display name field is required.',
            'displayName.min' => 'The display must be at least 8 characters.',
            'displayName.max' => 'The display name must not exceed 40 characters.',
        ];
    }
}
