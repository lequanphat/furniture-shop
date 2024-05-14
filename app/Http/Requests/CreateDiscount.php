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
            'percentage' => 'required|numeric',
            'startdate' => 'required|date',
            'enddate' => 'required|date|after:startdate',
        ];
    }
    public function messages()
    {
        // response message here
        return [
            'title.required' => 'The title field is required.',
            'percentage.required' => 'The percentage field is required.',
            'percentage.numeric' => 'The percentage must be a number.',
            'startdate.required' => 'Start date is required',
            'startdate.date' => 'Start date must be date',
            'enddate.required' => 'End date is required',
            'enddate.date' => 'End date must be date',
            'enddate.after' => "The end date must be a date after start date.",
        ];
    }
}
