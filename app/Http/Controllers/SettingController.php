<?php

namespace App\Http\Controllers;

use App\Entities\Setting;
use Illuminate\Support\Str;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;
use App\Http\Requests\TwilioRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\SettingValidation;

class SettingController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }
    
    public function index(Request $request)
    {
        $this->authorize('settings',Auth::user());
        $smtp = Setting::first();
        $smtp_password = '';
        if(!empty($smtp->smtp_password)) {
            $smtp_password = decrypt($smtp->smtp_password);
        }
        return view('settings.general', compact(['smtp' ,'smtp_password']));
    } 
    
    public function update(SettingValidation $request,$id) 
    {
        $data = $request->except('_token');

        if(!isset($request->categories) && isset($data['admin_config'])) {
            $data['categories'] = 0;
        }
        if(!isset($request->employees) && isset($data['admin_config'])) {
            $data['employees'] = 0;
        }
        if(!isset($request->is_stripe) && isset($request->stripe_secret)) {
            $data['is_stripe'] = 0;
        }      
        if(!isset($request->smtp_mail) && isset($request->smtp_port)) {
            $data['smtp_mail'] = 0;
        }
        if(!isset($request->is_paypal) && isset($request->paypal_client_id)) {
            $data['is_paypal'] = 0;
        }
        if(!isset($request->is_razorpay) && isset($request->razorpay_test_secret)) {
            $data['is_razorpay'] = 0;
        }
        if(!isset($request->stripe_active_mode) && isset($request->stripe_secret)) {
            $data['stripe_active_mode'] = 0;
        }
        if(!isset($request->paypal_active_mode) && isset($request->paypal_client_id)) {
            $data['paypal_active_mode'] = 0;
        }
        if(!isset($request->razorpay_active_mode) && isset($request->razorpay_test_secret)) {
            $data['razorpay_active_mode'] = 0;
        }
        if(!isset($request->is_payment_later) && isset($data['categories'])) {
            $check = Setting::where([
                ['is_stripe',0],
                ['is_paypal',0],
                ['is_razorpay',0]
            ])->first();
            if(!empty($check)) {
                session()->flash('error-message', trans('Appointment Payment Method at least ones activated'));
                return redirect()->to(URL::previous());
            }
            $data['is_payment_later'] = 0;
            
        }

        if(isset($data['admin_config'])) {
            unset($data['admin_config']);
        }

        if(isset($data['is_stripe']) && $data['is_stripe'] == 1) {
            if(isset($data['stripe_key']) && isset($data['stripe_secret']) && isset($data['stripe_active_mode']) && $data['stripe_active_mode'] == 0) {
                $auth = \Stripe\Stripe::setApiKey($data['stripe_secret']);
                try {
                    $customer = \Stripe\Customer::all();
                } catch (\Stripe\Exception\AuthenticationException $th) {
                    session()->flash('error-message', 'Invalid Stripe Api Secret.');   
                    return redirect()->to(URL::previous());
                }
            } else if(isset($data['stripe_live_key']) && isset($data['stripe_secret_live']) && isset($data['stripe_active_mode']) && $data['stripe_active_mode'] == 1) {
                $auth = \Stripe\Stripe::setApiKey($data['stripe_secret_live']);
                try {
                    $customer = \Stripe\Customer::all();
                } catch (\Stripe\Exception\AuthenticationException $th) {
                    session()->flash('error-message', trans('Invalid Stripe Live Api Secret'));   
                    return redirect()->to(URL::previous());
                }
            }
        }
        if(isset($data['is_paypal']) && $data['is_paypal'] == 1) {
            $paypalUrl = 'https://api-m.sandbox.paypal.com/v1/oauth2/token';
            if(isset($data['paypal_client_id']) && isset($data['paypal_client_secret']) && isset($data['paypal_active_mode']) && $data['paypal_active_mode'] == 0) {
                $userpwd = $data['paypal_client_id'].':'.$data['paypal_client_secret'];
                $check = $this->paypalCheck($paypalUrl, $userpwd);
                if(!$check) {
                    session()->flash('error-message', trans('Paypal SandBox Credentials is not valid'));   
                    return redirect()->to(URL::previous());
                }
            }

            if(isset($data['paypal_live_client_id']) && isset($data['paypal_client_secret_live']) && isset($data['paypal_active_mode']) && $data['paypal_active_mode'] == 1) {
                $userpwd = $data['paypal_live_client_id'].':'.$data['paypal_client_secret_live'];
                $check = $this->paypalCheck($paypalUrl, $userpwd);
                if(!$check) {
                    session()->flash('error-message', trans('Paypal Live Credentials is not valid'));   
                    return redirect()->to(URL::previous());
                }
            }
        }
        if(isset($data['is_razorpay']) && $data['is_razorpay'] == 1) {
            if(isset($data['razorpay_test_key']) && isset($data['razorpay_test_secret']) && isset($data['razorpay_active_mode']) && $data['razorpay_active_mode'] == 0) {
                $userpwd = $data['razorpay_test_key'].':'.$data['razorpay_test_secret'];
                $check = $this->checkRozarpay($userpwd);
                if(!$check) {
                    session()->flash('error-message', trans('Razorpay Sandbox Credentials is not valid'));   
                    return redirect()->to(URL::previous());
                }
            }

            if(isset($data['razorpay_live_key']) && isset($data['razorpay_live_secret']) && isset($data['razorpay_active_mode']) && $data['razorpay_active_mode'] == 1) {
                $userpwd = $data['razorpay_live_key'].':'.$data['razorpay_live_secret'];
                $check = $this->checkRozarpay($userpwd);
                if(!$check) {
                    session()->flash('error-message', trans('Razorpay Live Credentials is not valid'));   
                    return redirect()->to(URL::previous());
                }
            }
        }

        if($request->currency && strtoupper($request->currency) == "INR") {
            $data['currency'] = strtoupper($request->currency);
            $data['paypal_active_mode'] = 0;
            $data['is_paypal'] = 0;
        }

        if($request->has('smtp_email') && $request->has('smtp_password')) {
            if($data["smtp_password"] != '') {
                $data["smtp_password"] = encrypt($data["smtp_password"]);
            }
        }
        Setting::where('id',$id)->update($data);
        session()->flash('message', trans('Settings updated successfully'));   
        return redirect()->to(URL::previous());
    }

    public function payment(Request $request)
    {
        $this->authorize('settings',Auth::user());
        $smtp = Setting::first();
        return view('settings.payment', compact('smtp'));
    } 
    public function site(Request $request)
    {
        $this->authorize('settings',Auth::user());
        $site = SiteConfig::first();
        return view('settings.site', compact('site'));
    } 

    public function siteUpdate(Request $request,$id)
    {
        $this->authorize('settings',Auth::user());
        $data = $request->except('_token');
        if ($request->hasFile('logo') && $request->hasFile('logo')) {
            $file = $request->file('logo');
            $image = 'site-logo-'.time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('img/logo/');
            $file->move($destinationPath,$image);
            $data["logo"] = $image;
        }
        if ($request->hasFile('favicon') && $request->hasFile('favicon')) {
            $file = $request->file('favicon');
            $img = 'favicon-'.time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('img/favicons/');
            $file->move($destinationPath,$img);
            $data["favicon"] = $img;
        } 
        
        SiteConfig::where('id',$id)
                                ->update($data);
                              
        session()->flash('message', trans('Settings updated successfully'));
        return redirect()->back();
    }

    public function paypalCheck($paypalUrl, $userpwd)
    {
        $curl = curl_init();

        curl_setopt_array($curl, [
            CURLOPT_URL => $paypalUrl,
            CURLOPT_USERPWD => $userpwd,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => 'grant_type=client_credentials',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Content-Type: application/x-www-form-urlencoded'
            )
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if($error) {
            return false;
        } else {
            $decoded_response = json_decode($response);
            if(isset($decoded_response->error))
                return false;
            return true;
        }
    }

    public function checkRozarpay($userpwd) {
        $curl = curl_init();
        $url = 'https://api.razorpay.com/v1/customers';
        $base64token = base64_encode($userpwd);
        curl_setopt_array($curl, [
            CURLOPT_URL => $url,
            CURLOPT_POST => true,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER => array(
                'Authorization: Basic '.$base64token
            )
        ]);
        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);
        if($error) {
            return false;
        } else {
            $decoded_response = json_decode($response);
            if(isset($decoded_response->error))
                return false;
            return true;
        }
    }

    public function changeLangauge(Request $request, $lang) {
        if(empty($lang)) {
            session()->flash('error-message', trans('Can not change language successfully'));
            return redirect()->back();
        }

        App::setLocale($lang);
        session()->put('locale', $lang);
        session()->flash('message', trans('Change language successfully'));
        return redirect()->back();
    }

    public function notificationSetting(Request $request)
    {   // Hi Kate, your appointment for haircut at 9:00 AM on Jan 15th, 2023 is confirmed with John Mayers
        // $response = array(
        //     'to' => '+919727962413',
        //     'body' => trans_choice('customer_appointment_notification', 0, [
        //         'customer' => 'Gaurang',
        //         'service' => 'Treatment',
        //         'time' => date('h:i a'),
        //         'date' => date('F j, Y'),
        //         'employee' => 'Hashmukh Kalsariya'
        //     ])
        // );
        // \App\Helper\Helper::notification($response);
        $this->authorize('settings',Auth::user());
        $smtp = Setting::first();
        $country = SiteConfig::first();
        return view('settings.notification', compact('smtp','country'));
    }

    public function smsConfigUpdate(TwilioRequest $request) {
        $data = $request->except('_token');
        if(!isset($request->notification)) {
            $data['notification'] = 0;
        }
        if(!isset($request->twilio_active_mode) && isset($data['twilio_sandbox_secret'])) {
            $data['twilio_active_mode'] = 0;
        }
        if(!isset($request->twilio_notify_customer)) {
            $data['twilio_notify_customer'] = 0;
        }
        if(!isset($request->twilio_notify_employee)) {
            $data['twilio_notify_employee'] = 0;
        }
        if(!isset($request->twilio_notify_admin)) {
            $data['twilio_notify_admin'] = 0;
        }
        if(!isset($request->use_twilio_service_id)) {
            $data['use_twilio_service_id'] = 0;
        }
        Setting::where('id', 1)->update($data);
        session()->flash('message', trans('Notification Setting updated successfully'));
        return redirect()->back();
    }

    public function verifySmtp(Request $request) {
        $this->validate($request, [
            'to' => 'required|email'
        ], [
            'to.required' => trans('Please enter email'),
            'to.email' => trans('Please enter valid email')
        ]);

        try {
            $site = SiteConfig::first();
            $data = array(
                'to' => $request->to,
                'title' => trans('Checking Mail Configuration'),
                'subject'=> trans('Verify Mail Configuration'),
                'name' => $site->site_title,
                'site_name' => $site->site_title,
                'company_name' => $site->company_name,
                'template'=> 'mail.verify_smtp',
            );
            \App\Helper\Helper::emailinformation($data);

            return response()->json([
                'status' => true,
                'messages' => trans('Mail Configuration Verified Successfully')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'messages' => $th->getMessage()
            ]);
        }
    }

 
    
}
