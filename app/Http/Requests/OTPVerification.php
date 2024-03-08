<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OTPVerification extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        // validate here
        return [
            'otp' => 'required|regex:/^\d{6}$/',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'otp.required' => 'The OTP field is required.',
            'otp.regex' => 'The OTP must be a 6-digit number.',
        ];
    }
}
