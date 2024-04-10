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
            'note' => 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'note.required' => 'The note field is required',
        ];
    }
}
