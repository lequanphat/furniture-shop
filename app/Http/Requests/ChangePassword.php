<?php

namespace App\Http\Requests;

use App\Rules\AlphaSpace;
use Illuminate\Foundation\Http\FormRequest;

class ChangePassword extends FormRequest
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
            'password' => 'required|min:6|max:20',
            'new_password' => 'required|min:6|max:20|different:password',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'password.required' => 'The password field is required.',
            'password.min' => 'The password must be at least 6 characters.',
            'password.max' => 'The password must not exceed 20 characters.',
            'new_password.required' => 'The new password field is required.',
            'new_password.min' => 'The new password must be at least 6 characters.',
            'new_password.max' => 'The new password must not exceed 20 characters.',
            'new_password.different' => 'The new password must be different with the password.',
        ];
    }
}
