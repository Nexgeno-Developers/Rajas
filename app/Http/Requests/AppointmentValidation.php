<?php

namespace App\Http\Requests;

use App\Rules\DateRule;
use App\Entities\Setting;
use App\Entities\Employee;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentValidation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'category_id' => Rule::requiredIf(function () {
                        return Setting::first()->categories;
                    }),
                    'employee_id' => 'required',
                    'user_id' => 'required',
                    'comments' => 'required',
                    'service_id' => 'required',
                    'date' => ['required','date', new DateRule()],
                    'slots' => 'required',
                ];
                break;
            }
            case 'PATCH':
            case 'PUT':
            {
                return [
                    'category_id' => Rule::requiredIf(function () {
                        return Setting::first()->categories;
                    }),
                    'employee_id' => 'required',
                    'user_id' => 'required',
                    'comments' => 'required',
                    'service_id' => 'required',
                    'date' => ['required','date', new DateRule()],
                    'slots' => 'required',
                ];
                break;
            }
        
        }
    }
    public function messages()
    {
        return [
            'category_id.required' => trans('Please select category'),
            'service_id.required' => trans('Please select service'),
            'employee_id.required' => trans('Please select employee'),
            'user_id.required' => trans('Please select customer'),
            'date.required' => trans('Please select booking date'),
            'slots.required' => trans('Please select booking time'),
            'comments.required' => trans('Please enter comments')
        ];
    }
}
