<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerRequest extends FormRequest
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
                        'first_name' => 'required|string',
                        'last_name' => 'required|string',
                        'email' => 'required|email|unique:users',
                        'phone' => 'required'
                    ];
                    break;
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'first_name' => 'required|string',
                        'last_name' => 'required|string',
                        'email' => 'required|email|unique:users,email,'.$this->segment(2).',id',
                        'phone' => 'required'
                        // |starts_with:+
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
            'phone.unique' => trans('Phone number exists in the system')
        ];
    }
}
