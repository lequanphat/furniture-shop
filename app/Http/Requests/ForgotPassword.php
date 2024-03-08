<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPassword extends FormRequest
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
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'email.required' => 'The email field is required.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }
}
