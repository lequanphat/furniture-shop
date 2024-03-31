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
            'orderID' => 'required',
            'productDetailId' => 'required|unique:order_details,sku',//dòng unique kiếm trong model
            'quantity'=> 'required',
            'unitPrice' => 'required',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'orderID.required'=> 'The order id field is required.',
            'productDetailId.unique' => 'The product have already existed in the detail.',
            'productDetailID.required' => 'The product detail field is required.',
            'quantity.required'=> 'The quantity field is required.',
            'unitPrice.required'=> 'The unit price field is required.',
        ];
    }
}
