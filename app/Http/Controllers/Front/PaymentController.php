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
}
