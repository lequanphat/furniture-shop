<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiscount extends FormRequest
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
        return [
            'title.required' => 'The title is eequired.',
            'percentage.required' => 'The percentage is required.',
            'percentage.numeric' => 'Percentage must be a number.',
            'startdate.required' => 'Start date is required.',
            'startdate.date' => 'Start date must be date.',
            'enddate.required' => 'End date is required.',
            'enddate.date' => 'End date must be date.',
            'enddate.after:startdate' => "End date must be after start date.",
        ];
    }
}
