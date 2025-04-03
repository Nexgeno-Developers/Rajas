<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ResetPasswordValidation extends FormRequest
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
            'email'=>'required|email',
            'password' => 'required|min:8|regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[\d\x])(?=.*[!$#%]).*$/|confirmed',
            'password_confirmation' => 'required|min:8'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => trans('Please enter email'),
            'email.email' => trans('Please enter valid email'),
            'password.required' => trans(''),
            'password.min' => trans(''),
            'password.regex' => trans(''),
            'password.confirmed' => trans(''),
            'password_confirmation.required' => trans(''),
            'password_confirmation.min' => trans(''),
        ];
    }
}
