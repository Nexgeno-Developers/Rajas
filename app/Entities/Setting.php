<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Setting extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'smtp_email','smtp_password','smtp_host','smtp_port','smtp_mail','stripe_key','stripe_secret','stripe_live_key','stripe_secret_live','is_stripe','currency','currency_icon','is_paypal',
        'paypal_client_id','paypal_client_secret','paypal_locale','paypal_live_client_id','paypal_client_secret_live',
        'custom_field_text','custom_field_category','custom_field_service','razorpay_test_key','razorpay_test_secret','razorpay_live_key','razorpay_live_secret','timezone','date_format','categories','is_payment_later',
        'notification','twilio_active_mode','twilio_sandbox_key','twilio_sandbox_secret','use_twilio_service_id', 'twilio_service_id','twilio_live_key','twilio_live_secret','twilio_phone','twilio_notify_customer','twilio_notify_employee','twilio_notify_admin',
        'country_code','country_name','google_client_id','google_client_secret'
    ];

    public function employeeServices()
    {
        return $this->hasMany('App\Entities\EmployeeService','service_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Entities\Appointment','service_id');
    }
}