<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDetailedOrder extends FormRequest
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
            'sku' => 'required',
            'quantities' => 'required',
            'unit_price' => 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'sku.required' => 'The sku field is required.',
            'quantities.required' => 'The quantities field is required.',
            'unit_price.required' => 'The unit price field is required.',
        ];
    }
}
