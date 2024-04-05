<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateWarranty extends FormRequest
{

    public function authorize(): bool
    {
        // check permission here
        return true;
    }
    public function rules()
    {
        // validate here, là id các ô trên form tạo
        return [
            'orderID' => 'required',
            'product_detail_ID'=> 'required',
            'start_date' => 'required',
            'description'=> 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'orderID.required' => 'The order ID field is required',
            'product_detail_ID.required' => 'The product detail ID field is required',
            'start_date.required' => 'The start date field is required',
            'description.required' => 'The description field is required',
        ];
    }
}
