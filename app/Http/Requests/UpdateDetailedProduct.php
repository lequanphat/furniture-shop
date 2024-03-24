<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDetailedProduct extends FormRequest
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
            'name' => 'required',
            'color' => 'required',
            'size' => 'required',
            'original_price' => 'required',
            'warranty_month' => 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'sku.required' => 'The sku field is required.',
            'name.required' => 'The name field is required.',
            'color.required' => 'The color field is required.',
            'size.required' => 'The size field is required.',
            'original_price.required' => 'The original price field is required.',
            'warranty_month.required' => 'The warranty month field is required.',
        ];
    }
}
