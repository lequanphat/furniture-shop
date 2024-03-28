<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateDiscount extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'title' => 'required',
            'description' => 'required|alpha_num',
            'percentage' => 'required|numeric',
            'amount' => 'required|numeric',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after:startdate', // Đảm bảo enddate lớn hơn startdate
            'active' => 'required',
        ];

    }
    public function messages()
    {
        // response message here
        return [
            'title.required' => 'The title field is required.',
            'description.required' => 'The  Description field is required.',
            'percentage.required' => 'The percentage is Required.',
            'percentage.numeric' => 'The percentage is numeric.',
            'amount.required' => 'The amount field is required.',
            'amount.numeric'=> 'amount is numeric',
            'startdate.required'=> 'start date is required',
            'startdate.date'=> 'startdate must be date',
            'enddate.required'=> 'amount is numeric',
            'enddate.date' => 'Must be date',
            'enddate.after:startdate'=>"must be larger Than  Start Date",
            'active.required'=>"must be Fill",
        ];
    }
}
