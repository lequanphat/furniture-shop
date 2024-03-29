<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateCategory extends FormRequest
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
            'name' => 'required',
            'description' => 'required',
            'index' => 'required',
            'parent_id' => 'required',

        ];
    }


    public function messages()
    {

        return
            [
                'name.required' => 'The name is required',
                'description.required' => 'This Description Is required',
                'index.required' => 'This index Is required',
                'parent_id.required' => 'This parent Is required',
            ];
    }
}
