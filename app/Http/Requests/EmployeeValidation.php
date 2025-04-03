<?php

namespace App\Http\Requests;

use App\Entities\Setting;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class EmployeeValidation extends FormRequest
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
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => 'required|email|unique:users',
                        'password' => [
                            'required',
                            'min:8',
                        ],
                        'phone' => [
                            'required',
                        ],
                        'category_id'=>Rule::requiredIf(function () {
                            return Setting::first()->categories;
                        }),
                        'service_id'=>'required',
                        'start_time' => 'required',
                        'finish_time' => 'required',
                        'rest_time' => 'required',
                        // 'break_start_time' => 'required',
                        // 'break_end_time' => 'required',
                        'days' => 'required'
                    ];
                    break;
                }
            case 'PATCH':
            case 'PUT':
                {
                    return [
                        'first_name' => 'required',
                        'last_name' => 'required',
                        'email' => ['required','email',Rule::unique('users')->ignore($this->route('employee'))],
                        'phone' => ['required','numeric',Rule::unique('users')->ignore($this->route('employee'))],
                        'category_id'=>Rule::requiredIf(function () {
                            return Setting::first()->categories;
                        }),
                        'start_time' => 'required',
                        'finish_time' => 'required',
                        'days' => 'required'
                    ];
                    break;
                }
        }

    }

    public function messages()
    {
        return [
            
            'first_name.required' => trans('Please enter first name'),
            'last_name.required' => trans('Please enter last name'),
            'email.required' => trans('Please enter email'),
            'email.email' => trans('Please enter valid email'),
            'email.unique' => trans('Email already exists in the system'),
            'phone.required' => trans('Please enter phone number'),
            'phone.numeric' => trans('Phone number must be numeric and digits'),
            // 'phone.min' => trans('Phone number should be minimum 10 digits'),
            // 'phone.starts_with' => trans('Phone number must be start with +'),
            'phone.unique' => trans('Phone number exists in the system'),
            'start_time.required' => trans('Please select start time'),
            'finish_time.required' => trans('Please select finish time'),
            'days.required' => trans('Please select working days'),
            'category_id.required'=> trans('Please select any category of employee'),
            'service_id.required'=> trans('Please select any service of employee'),
            'rest_time' => trans('Please select rest time'),
            'break_start_time' => trans('Please select break start time'),
            'break_end_time' => trans('Please select break end time')
        ];
    }
}
