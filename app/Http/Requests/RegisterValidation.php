<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RegisterValidation extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|unique:users',
            'mobile' => 'required|numeric',
            'password' => 'required|min:6|max:20'
        ];
    }

    public function messages()
    {
       return [
            'first_name.required' => trans('Please enter first name'),
            'last_name.required' => trans('Please enter last name'),
            'mobile.required' => trans('Please enter phone number'),
            'mobile.numeric' => trans('Phone number must be numeric and digits'),
            // 'mobile.min' => trans('Phone number should be minimum 10 digits'),
            // 'mobile.starts_with' => trans('Phone number must be start with +'),
            'email.required' => trans('Please enter email'),
            'email.unique' => trans('Email already exists in the system'),
            'password.required' => trans('Please enter password'),
            'password.min' => trans('Password should be minimum 6 characters'),
            'password.max' => trans('Password should be maximum 20 characters')
       ];
    }
}
