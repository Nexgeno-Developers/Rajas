<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingValidation extends FormRequest
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
            'custom_field_text' => 'nullable',
            'custom_field_category' => 'nullable',
            'custom_field_service' => 'nullable',
            'custom_time_slot' => 'nullable',
            'currency' => 'nullable',
            'currency_icon' => 'nullable',
            'timezone' => 'nullable',
            'date_format' => 'nullable',
            'smtp_mail' => 'nullable',
            'smtp_email' => 'required_if:smtp_mail,1',
            'smtp_password' => 'required_if:smtp_mail,1',
            'smtp_host' => 'required_if:smtp_mail,1',
            'smtp_port' => 'required_if:smtp_mail,1',
            'is_stripe' => 'nullable',
            'stripe_key' => 'required_if:is_stripe,1',
            'stripe_secret' => 'required_if:is_stripe,1',
            'stripe_live_key' => 'required_if:is_stripe,1',
            'stripe_secret_live' => 'required_if:is_stripe,1',
            'is_paypal' => 'nullable',
            'paypal_client_id' => 'required_if:is_paypal,1',
            'paypal_client_secret' => 'required_if:is_paypal,1',
            'paypal_locale' => 'required_if:is_paypal,1',
            'paypal_live_client_id' => 'required_if:is_paypal,1',
            'paypal_client_secret_live' => 'required_if:is_paypal,1',
            'is_razorpay' => 'nullable',
            'razorpay_test_key' => 'required_if:is_razorpay,1',
            'razorpay_test_secret' => 'required_if:is_razorpay,1',
            'razorpay_live_key' => 'required_if:is_razorpay,1',
            'razorpay_live_secret' => 'required_if:is_razorpay,1',
            'stripe_active_mode' => 'nullable',
            'paypal_active_mode' => 'nullable',
            'razorpay_active_mode' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'smtp_email.required_if' => trans('Please enter email'),
            'smtp_password.required_if' => trans('Please enter email password'),
            'smtp_host.required_if' => trans('Please enter email host name'),
            'smtp_port.required_if' => trans('Please enter email port number'),
            'stripe_key.required_if' => trans('Please enter stripe test key'),
            'stripe_secret.required_if' => trans('Please enter stripe test secret'),
            'stripe_live_key.required_if' => trans('Please enter stripe live key'),
            'stripe_secret_live.required_if' => trans('Please enter stripe live secret'),
            'paypal_client_id.required_if' => trans('Please enter paypal test client id'),
            'paypal_client_secret.required_if' => trans('Please enter paypal test client secret'),
            'paypal_locale.required_if' => trans('Please enter paypal locale langauge'),
            'paypal_live_client_id.required_if' => trans('Please enter paypal live client id'),
            'paypal_client_secret_live.required_if' => trans('Please enter paypal live client secret'),
            'razorpay_test_key.required_if' => trans('Please enter rozarpay test key'),
            'razorpay_test_secret.required_if' => trans('Please enter razorpay test secret'),
            'razorpay_live_key.required_if' => trans('Please enter razorpay live key'),
            'razorpay_live_secret.required_if' => trans('Please enter razorpay live secret'),
        ];
    }
}
