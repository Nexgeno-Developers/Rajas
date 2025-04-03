<?php

namespace App\Http\Requests;

use App\Entities\Setting;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ServiceValidation extends FormRequest
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
                'category_id'=>Rule::requiredIf(function () {
                        return Setting::first()->categories;
                    }),
                'name'=>'required',
                'price' =>'required',
                'description' => 'required',
                'duration' => 'required_if:duration_24,=,null|nullable|date_format:H:i',
                'duration_24hr' => 'required_if:duration,=,null|nullable',
                'cancel_before' => 'required|date_format:H:i',
                'image'=> 'required|mimes:png,jpg,jpeg',
            ];
            break;
        }
        case 'PATCH':
            case 'PUT':
                {
                    return [
                        'category_id'=>Rule::requiredIf(function () {
                            return Setting::first()->categories;
                        }),
                        'price' =>'required',
                        'description' => 'required',
                        'duration' => 'required_if:duration_24,=,null|nullable|date_format:H:i',
                        'duration_24hr' => 'required_if:duration,=,null|nullable',
                        'cancel_before' => 'required|date_format:H:i',
                        'image' => 'nullable|max:8000|mimes:png,jpg,jpeg'
                    ];
                    break;
                }
        }

    }

    public function messages()
    {
        return [
            'category_id.required' => trans('Please Select Category'),
            'price.required' => trans('Please Enter Service Price'),
            'description.required' => trans('Please Enter Service Description'),
            'duration.required' => trans('Please Enter Service Duration'),
            'duration.date_format' => trans('Please enter duration valid time'),
            'cancel_before.required' => trans('Please Enter Appointment Cancel Before the Appointment'),
            'cancel_before.date_format' => trans('Please enter cancel before valid time'),
            'image.required' => trans('Please Select Service Image'),
            'image.mimes' => trans('Service Image must be a file type of image jpg, jpeg and png'),
            'image.max' => trans('Service Image should be Maximum 8MB')
        ];
    }
        
}