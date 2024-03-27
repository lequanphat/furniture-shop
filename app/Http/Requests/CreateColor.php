<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateColor extends FormRequest
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
        return [
            'name' => 'required|unique:colors,name|max:20|min:3',
            'code' => 'required',
        ];
    }


    public function messages()
    {

        return  [
            'name.required' => 'The color name is required.',
            'name.unique' => 'The color name have already existed.',
            'name.max' => 'The color name must not exceed 20 characters.',
            'name.min' => 'The color name must be at least 3 characters.',
            'code.required' => 'The color code is required.',
        ];
    }
}
