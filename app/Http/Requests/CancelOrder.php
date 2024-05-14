<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CancelOrder extends FormRequest
{

    public function authorize(): bool
    {
        // check permission here
        return true;
    }
    public function rules()
    {
        return [
            'reason' => 'required|max:400',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'reason.required' => 'The reason field is required',
            'reason.max' => 'The reason may not be greater than 400 characters',
        ];
    }
}
