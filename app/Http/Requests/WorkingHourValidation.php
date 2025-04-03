<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class WorkingHourValidation extends FormRequest
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
        return [
            'employee_id' => 'required',
            'date' => 'required|date',
            'start_time' => 'required',
            'finish_time' => 'required|after:start_time',
            'rest_time' => 'required',
            'break_start_time' => 'required',
            'break_end_time' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'employee_id.required' => trans('Please enter employee'),
            'date.required' => trans('Please enter date'),
            'date.date' => trans('Please enter valid date'),
            'start_time.required' => trans('Please select start time'),
            'finish_time.required' => trans('Please select finish time'),
            'rest_time.required' => trans('Please select rest time'),
            'break_start_time.required' => trans('Please select break start time'),
            'break_end_time.required' => trans('Please select break end time'),
            'finish_time.after' => trans('The finish time cannot be less than start time')
        ];
    }
}
