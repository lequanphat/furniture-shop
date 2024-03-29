<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTag extends FormRequest
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
            'name' => 'required|max:20|min:3',
        ];
    }


    public function messages()
    {

        return  [
            'name.required' => 'The tag name is required',
            'name.max' => 'The tag name must not exceed 20 characters',
            'name.min' => 'The tag name must be at least 3 characters',
        ];
    }
}
