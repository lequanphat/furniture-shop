<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSupplier extends FormRequest
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
            'name'=>'required',
            'description'=>'required',
            'address'=>'required',
            'phone_number' => 'required|string|numeric',
        ];
    }


    public function messages()
    {
        return
        [
            'name.required'=>'The name is required',
            'description.required'=>'This Description Is required',
            'address.required'=>'This address Is required',
            'phone_number.required'=>'This address Is required',
            'phone_number.max' => 'The phone number field is required.',
            'phone_number.numeric' => 'The phone number only contains number',
        ];
    }
}
