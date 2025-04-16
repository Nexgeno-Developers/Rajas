<?php

namespace App\Http\Controllers\Front;

use App\Entities\User;
use App\Entities\Payment;
use App\Entities\Setting;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Services\Interfaces\IPaymentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;


class PaymentController extends Controller
{

    protected $payment, $custom;

    public function __construct(IpaymentService $paymentService)
    {
      
        $this->payment = $paymentService;
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->flash('success', trans('Your appointment has been booked successfully'));
        return view('theme.thank-you');
    } 

    public function stripeSuccess(Request $request, $id) {
        if($request->redirect_status == "succeeded" && !empty($id)) {
            $appointment = Appointment::find($id);
            $payment = Payment::where('appointment_id',$id)->first();
            $custom = Setting::first();
            if(!$payment) {
                return redirect()->route('appointment.book');
            } else {
                $payment->id = $payment->id;
                $payment->payment_method = 'stripe';
                $payment->payment_id = $request->payment_intent;
                $payment->amount = $appointment->payment->amount;
                $payment->currency = $custom->currency;
                $payment->status = 'succeeded';
                $payment->update();
                if($custom->smtp_mail == 1) {
                    $site = DB::table('site_configs')->first();
                    $user = User::where('id', $appointment->user_id)->first();
                    $admin = User::where('id', $appointment->admin_id)->first();
                    $employee = User::where('id', $appointment->employee_id)->first();
                    $template = 'mail.customer_appointment';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, $user->email);
                    $template = 'mail.admin_email';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, '', $admin);
                }
                return redirect()->route('success');
            }
        }
    }
    public function intent(Request $request) 
    {
        $custom = Setting::first();
        $stripe =  \Stripe\Stripe::setApiKey($custom->stripe_secret);
        $amount =$request->price;
        if($custom->currency == 'inr' || $custom->currency == 'INR') {
            $amount = (int) $amount * 100;
        } else {
            $amount = (int) $amount;
        }
        $payment_intent  = \Stripe\PaymentIntent::create ([
            'description' => trans('Stripe Payment'),
			'amount' => $amount,
			'currency' => strtoupper($custom->currency),
			'description' => trans('Payment From Codehunger'),
			'payment_method_types' => ['card'],
            'shipping' => [
              'name' => $request->customer,
              'address' => [
                'line1' => '510 Townsend St',
                'postal_code' => '98140',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
              ],
            ],
        ]);
       
       return $intent = $payment_intent->client_secret;
    }

    public function afterPayment(Request $request)
    {
        $custom = Setting::first();
        $post['appointment_id'] = $request->appointment_id;
        foreach ($request['appointment'] as $key => $value) {
            foreach ($value as $k => $v) {
                
               if($v == 'payment_method'){
                   
                    $post['payment_method'] = $value['value'];
               }
            } 
        }
        $post['payment_id'] = $request->payment['paymentIntent']['id'];
        $post['amount'] = $request->payment['paymentIntent']['amount'];
        $post['currency'] =   $request->payment['paymentIntent']['currency'];
        $post['status'] =  $request->payment['paymentIntent']['status'];

        $paymentdata = $this->payment->insert(new Payment($post));
        return response()->json(['data' => trans('Thank you! Your Booking is Completed. You have successfully booked an appointment')]);
    }

    public function proceed(Request $request)
    {
        $custom = Setting::first();
        $payment = Payment::where('appointment_id',$request->appointment_id)->first();
        if(!$payment) {
            return response()->json(['error' => trans('Payment Time is over. Please Select Another Booking')]);
        } else {
            $payment->id = $payment->id;
            $payment->payment_method = 'paypal';
            $payment->payment_id = $request->payment_intent;
            $payment->amount = $request->amount;
            $payment->currency = $custom->currency;
            $payment->status = 'succeeded';
            $payment->update();
            if($custom->smtp_mail == 1) {
                $appointment = Appointment::find($request->appointment_id);
                $site = DB::table('site_configs')->first();
                $user = User::where('id', $appointment->user_id)->first();
                $admin = User::where('id', $appointment->admin_id)->first();
                $employee = User::where('id', $appointment->employee_id)->first();
                $template = 'mail.customer_appointment';
                $this->sendEmail($user, $employee, $appointment, $site, $template, $user->email);
                $template = 'mail.admin_email';
                $this->sendEmail($user, $employee, $appointment, $site, $template, '', $admin);
            }
            $redirectUrl = route('success');
            return response()->json(['data' => trans('Thank you! Your Booking is Successfully Booked'),'redirect' => $redirectUrl]);
        }
    }

    
    public function razorpay(Request $request)
    {
        $custom = Setting::first();
        $payment = Payment::where('appointment_id',$request->appointment_id)->first();
        if(!$payment) {
            return response()->json(['error' => trans('Payment Time is over. Please Select Another Booking')]);
        } else {
            $payment->id = $payment->id;
            $payment->payment_method = 'razorpay';
            $payment->payment_id = $request->payment_id;
            $payment->amount = $request->amount;
            $payment->currency = $custom->currency;
            $payment->status = 'succeeded';
            $payment->update();
            if($custom->smtp_mail == 1) {
                $appointment = Appointment::find($request->appointment_id);
                $site = DB::table('site_configs')->first();
                $user = User::where('id', $appointment->user_id)->first();
                $admin = User::where('id', $appointment->admin_id)->first();
                $employee = User::where('id', $appointment->employee_id)->first();
                $template = 'mail.customer_appointment';
                $this->sendEmail($user, $employee, $appointment, $site, $template, $user->email);
                $template = 'mail.admin_email';
                $this->sendEmail($user, $employee, $appointment, $site, $template, '', $admin);
            }
            $redirectUrl = route('success');
            return response()->json(['data' => trans('Thank you! Your Booking is Successfully Booked'),'redirect' => $redirectUrl]);
        }
    }

    public function sendEmail($user, $employee, $appointment, $site, $template, $to = '', $admin = false)
    {
        $data = array(
            'name' => $user->first_name.' '.$user->last_name,
            'to' => $to,
            'title' => trans('Appointment Received'),
            'subject' => trans('Appointment Booked'),
            'template' => $template,
            'customer' => $user,
            'employee' => $employee,
            'appointment' => $appointment,
            'site' => $site
        );

        if($template == 'mail.admin_email') {
            $config = DB::table('site_configs')->first();
            $data['name'] = $admin->first_name.' '.$admin->last_name;
            $data['to'] = $config->email;
            $data['admin'] = $admin;
            $data['admin_email'] = $config;
        }
        \App\Helper\Helper::emailinformation($data);
        return true;
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function generatePayuHash(Request $request) {

        $MERCHANT_KEY = env("PAYUMONEY_KEY");
        $SALT = env("PAYUMONEY_SALT");
        $txnid = substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    
        $posted = [
            'key' => $MERCHANT_KEY,
            'txnid' => $txnid,
            'amount' => $request->amount,
            'productinfo' => $request->productinfo,
            'firstname' => $request->firstname,
            'email' => $request->email,
        ];
    
        $hashString = "{$posted['key']}|{$posted['txnid']}|{$posted['amount']}|{$posted['productinfo']}|{$posted['firstname']}|{$posted['email']}|||||||||||{$SALT}";
        $hash = strtolower(hash('sha512', $hashString));
    
        return response()->json([
            'key' => $MERCHANT_KEY,
            'txnid' => $txnid,
            'surl' => url('/payumoney/success'),
            'furl' => url('/payumoney/fail'),
            'hash' => $hash
        ]);
    }    

    public function payumoney_failure(Request $request)
    {
        $this->payumoney_error($request);

        session()->flash('error', trans('Your booking has been failed'));
        return view('theme.failure', compact('request'));        
    }    

    public function payumoney_success(Request $request)
    {
        //return $request->mode;
        //return $request->all();

        //return $this->validatePayUResponseHash($request->all(), env("PAYUMONEY_SALT"));
        
        $paymentStatus = $request->status;
        if( $paymentStatus == 'success' && $this->validatePayUResponseHash($request->all(), env("PAYUMONEY_SALT")) ) {

            $custom = Setting::first();

            $appointment_id = $request->productinfo;
    
            $payment = Payment::where('appointment_id',$appointment_id)->first();
            if(!$payment) {
                return response()->json(['error' => trans('Payment Time is over. Please Select Another Booking')]);
            } else {
                $payment->id = $payment->id;
                $payment->payment_method = 'payumoney';
                $payment->payment_id = $request->mihpayid;
                $payment->amount = $request->amount;
                $payment->currency = $custom->currency;
                $payment->status = 'succeeded';
                $payment->payment_gateway_response = json_encode($request->all());
                $payment->update();
                if($custom->smtp_mail == 1) {
                    $appointment = Appointment::find($appointment_id);
                    $site = DB::table('site_configs')->first();
                    $user = User::where('id', $appointment->user_id)->first();
                    $admin = User::where('id', $appointment->admin_id)->first();
                    $employee = User::where('id', $appointment->employee_id)->first();
                    $template = 'mail.customer_appointment';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, $user->email);
                    $template = 'mail.admin_email';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, '', $admin);
                }

                if (!Auth::check()) {
                    Auth::loginUsingId($appointment->user_id);
                }

                // $redirectUrl = route('success');
                // return response()->json(['data' => trans('Thank you! Your Booking is Successfully Booked'),'redirect' => $redirectUrl]);
                return redirect()->to('/customer/appointment/' . $appointment_id)
                ->with('message', 'Thank you! Service Booked Successfully!');             
            }
        }else{
            //failure
            $this->payumoney_error($request);

            session()->flash('error', trans('Your booking has been failed'));
            return view('theme.failure', compact('request'));               
        }        
    } 
    
    public function payumoney_webhook(Request $request)
    {
        sleep(5);

        Log::info('🚀 PayU Webhook Triggered');
        Log::info('🔍 Webhook Payload:', $request->all());

        $paymentStatus = $request->status;
        $custom = Setting::first();
        $appointment_id = $request->productinfo;
        $payment = Payment::where('appointment_id',$appointment_id)->first();        
    
        if( $paymentStatus == 'success' && $this->validatePayUResponseHash($request->all(), env("PAYUMONEY_SALT")) ) {
    
            if($payment->status != 'succeeded') {
                $payment->payment_id = $request->mihpayid;
                $payment->status = 'succeeded';
                $payment->payment_gateway_response = json_encode($request->all());
                $payment->update();
                if($custom->smtp_mail == 1) {
                    $appointment = Appointment::find($appointment_id);
                    $site = DB::table('site_configs')->first();
                    $user = User::where('id', $appointment->user_id)->first();
                    $admin = User::where('id', $appointment->admin_id)->first();
                    $employee = User::where('id', $appointment->employee_id)->first();
                    $template = 'mail.customer_appointment';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, $user->email);
                    $template = 'mail.admin_email';
                    $this->sendEmail($user, $employee, $appointment, $site, $template, '', $admin);
                }
                
                Log::info('🚀 PayU Webhook Updated The Appointment - PAID : '. $appointment_id);
            }else{
                Log::info('🚀 PayU Webhook Updated The Appointment - ALREADY PAID : '. $appointment_id);
            }
        } else {
                
            $payment->payment_id = $request->mihpayid;
            $payment->status = 'pending';
            $payment->payment_gateway_response = json_encode($request->all());
            $payment->update();

            Log::info('🚀 PayU Webhook Updated The Appointment - FAILED : '. $appointment_id);
        }       
    }     

    function validatePayUResponseHash($responseData, $SALT)
    {
        // Required fields from response (must exist)
        $requiredKeys = ['status', 'email', 'firstname', 'productinfo', 'amount', 'txnid', 'key', 'hash'];
    
        foreach ($requiredKeys as $key) {
            if (!isset($responseData[$key])) {
                return false;
            }
        }
    
        // Extract the response hash to compare later
        $receivedHash = strtolower($responseData['hash']);
    
        // Construct hash sequence as per PayU reverse hash formula
        $hashSequence = "{$SALT}|{$responseData['status']}|||||||||||{$responseData['email']}|{$responseData['firstname']}|{$responseData['productinfo']}|{$responseData['amount']}|{$responseData['txnid']}|{$responseData['key']}";
    
        // Calculate hash
        $generatedHash = strtolower(hash('sha512', $hashSequence));

        // var_dump($responseData);
        // var_dump($generatedHash);
        // var_dump($receivedHash);
    
        // Compare generated hash with received hash
        return $generatedHash === $receivedHash;
    }    

    public function payumoney_error($request)
    {
        $appointment_id = $request->productinfo;
    
        $payment = Payment::where('appointment_id',$appointment_id)->first();
        $appointment = Appointment::find($appointment_id);

        if (!Auth::check()) {
            Auth::loginUsingId($appointment->user_id);
        }

        if(!$payment) {
            return response()->json(['error' => trans('Payment Time is over. Please Select Another Booking')]);
        } else {
            $payment->payment_id = $request->mihpayid ?? '';
            $payment->payment_gateway_response = json_encode($request->all());
            $payment->update();           
        }      
    }
    
    
}
