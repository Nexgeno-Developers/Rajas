<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class TwilioRequest extends FormRequest
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
            'twilio_sandbox_key' => 'required',
            'twilio_sandbox_secret' => 'required',
            'twilio_phone' => 'required|numeric|starts_with:+',
            // |min:10|starts_with:+,
            'twilio_live_key' => 'required',
            'use_twilio_service_id' => 'nullable',
            'twilio_live_secret' => 'required',
            'twilio_service_id' => 'required_if:use_twilio_service_id,1'
        ];
    }

    public function messages()
    {
        return [
            'twilio_sandbox_key.required' => trans('Please enter twilio sandbox key'),
            'twilio_sandbox_secret.required' => trans('Please enter twilio sandbox secret'),
            'twilio_phone.required' => trans('Please enter twilio phone'),
            'twilio_phone.numeric' => trans('Twilio phone number must be digit or numeric'),
            // 'twilio_phone.min' => trans('Twilio phone number minimum 10 digits'),
            'twilio_phone.starts_with' => trans('Twilio phone number must be start with +'),
            'twilio_live_key.required' => trans('Please enter twilio live key'),
            'twilio_live_secret.required' => trans('Please enter twilio live secret'),
            'twilio_service_id.required_if' => trans('Please enter twilio messaging service id'),
        ];
    }
}
