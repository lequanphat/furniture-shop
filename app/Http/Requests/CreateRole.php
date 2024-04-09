<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateRole extends FormRequest
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
            'role_name' => 'required|unique:roles,name',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'role_name.required' => 'The role name field is required',
            'role_name.unique' => 'The role name have already existed.',
        ];
    }
}
