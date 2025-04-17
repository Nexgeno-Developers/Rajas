<?php

namespace App\Http\Controllers;

use App\Entities\Payment;
use App\Entities\Setting;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PaymentController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }

    public function index(Request $request)
    {
        $this->authorize('payments', Auth::user());
        $site = DB::table('site_configs')->first();
        $custom = Setting::first();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        // $payment_history = Appointment::select('payments.id','payments.payment_method','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
        //                     ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
        //                     ->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get();   

        $payment_history = Appointment::select('payment_details.account_no', 'payment_details.cheque_no', 'payment_details.account_holder_name', 'payment_details.bank_name', 'payment_details.ifsc_code', 'payments.payment_type', 'payments.payment_id', 'payments.upi_id','payments.id','payments.payment_method','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
                            ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
                            ->leftJoin('payment_details', 'payment_details.id', '=', 'payments.payment_detail_id')
                            ->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get();           
        return view('payments.index',compact('payment_history','custom','site','rowIndex'));
    }

    public function show($id)
    {
        $custom = Setting::first(); 
        $redirect = 'paymentlist';
        if(Auth::user()->role_id == 1)
            $payment_detail = Payment::with('appointments')->where('id', $id)->first();
        else {
            $payment_detail = Payment::select('payments.*','appointments.date','appointments.start_time','appointments.finish_time','appointments.service_id','appointments.employee_id','appointments.user_id','appointments.comments','appointments.admin_id')
                                        ->join('appointments','appointments.id','=','payments.appointment_id')
                                        ->where('payments.id',$id)
                                        ->where('appointments.employee_id',Auth::user()->id)
                                        ->first();
            $redirect = 'employee-paymentlist';
        }
          
           
        if(empty($payment_detail->appointments)) {
            session()->flash('error-message', trans('Appointment not found'));
            return redirect()->route($redirect);
        }

        if($payment_detail && $payment_detail->appointment_id) {
            $appointment = Appointment::where('id',$payment_detail->appointment_id)->first();
            if(!$appointment) {
                session()->flash('error-message', trans('Appointment not found'));
                return redirect()->route($redirect);
            }
        }

        if(empty($payment_detail)) {
            return redirect()->route('unauthorized');
        }
        return view('payments.show',compact('payment_detail','custom'));
    }

    public function pay($id,Request $request)
    {
        $custom = Setting::first(); 
        $request->session()->forget('frm');
       
        $payment = Payment::select('payments.id','payments.payment_method','payments.payment_date','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
                ->join('appointments','appointments.id','=','payments.appointment_id')->where('payments.id',$id);
        if(Auth::user()->role_id != 1){
            $payment->where('appointments.employee_id',Auth::user()->id);
        }
        $payment = $payment->first();
       
        if(empty($payment)) {
            return redirect()->route('unauthorized');
        }
        if($request->isMethod('post')){
            if ($request->cheque_no) {
                $pay = DB::table('payment_details')->insertGetId(array('account_no'=>$request->account_no,
                                            'cheque_no'=>$request->cheque_no,
                                            'account_holder_name'=>$request->account_holder_name,
                                            'bank_name'=>$request->bank_name,
                                            'ifsc_code'=>$request->ifsc_code,
                                            'created_at'=> date('Y-m-d H:i:s')
                )); 
                $data['payment_detail_id'] = $pay;
                session('frm', $request->frm);
            }
            if($request->upi_id) {
                $data['upi_id'] = $request->upi_id;
                session('frm', $request->frm);
            }
                $data['payment_type'] = $request->payment_type;
                $data['payment_date'] = $request->payment_date;
                $data['amount'] = $request->amount;
                $data['currency'] = $custom->currency;
                $data['status'] = 'success';
                $payment_id = Payment::where('id',$id)->update($data);
                session(['frm' => $request->frm]);
            session()->flash('message', trans('Payment details added successfully'));
            $redirect = (Auth::user()->role_id != 1) ? 'employee-paymentlist' : 'paymentlist';
            return  redirect()->route($redirect);  
        }

        return view('payments.offline_pay',compact('payment','custom'));
    }

    public function employeepayment(Appointment $appointment)
    {
        $this->authorize('employeepayment', Auth::user());
        // $id = 1;
        $custom = Setting::first();
        $appointments = Appointment::select('appointments.*','p.status as pstatus','p.amount as amount','p.id as payment_id')->join('payments as p','p.appointment_id','=','appointments.id')->where('appointments.employee_id',Auth::user()->id)->get();
        // $payment_detail = payment::where('id',$id)->first();
        return view('payments.employee-payment',compact('appointments','custom'));
    }

    public function filter(Request $request)
    {
       
        $site = DB::table('site_configs')->first();
        $custom = Setting::first();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }

        $data = $request->all();
        
        $user = $request->input('user_id');
        $status = $request->input('status');
        $startdate =$request->input('startdate');
        $enddate = $request->input('enddate');
        
        if(!empty($status) && !empty($enddate) && !empty($startdate) && !empty($payment_method)) {
            // $payment_history =  Appointment::select('payments.id','payments.payment_method','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
            //                                 ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
            //                                 ->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get(); 
            $payment_history =  Appointment::select('payment_details.account_no', 'payment_details.cheque_no', 'payment_details.account_holder_name', 'payment_details.bank_name', 'payment_details.ifsc_code', 'payments.payment_type', 'payments.payment_id', 'payments.upi_id','payments.id','payments.payment_method','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
                                            ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
                                            ->leftJoin('payment_details', 'payment_details.id', '=', 'payments.payment_detail_id')
                                            ->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get(); 
                                        
        }else {
            $payment_history =  Appointment::select('payment_details.account_no', 'payment_details.cheque_no', 'payment_details.account_holder_name', 'payment_details.bank_name', 'payment_details.ifsc_code', 'payments.payment_type', 'payments.payment_id', 'payments.id','payments.payment_method','payments.amount','payments.status as pstatus','appointments.user_id','appointments.date','appointments.status')
                                            ->join('payments', 'payments.appointment_id', '=', 'appointments.id')
                                            ->leftJoin('payment_details', 'payment_details.id', '=', 'payments.payment_detail_id')
                                            ->where('admin_id',Auth::user()->id)->orderBy('id','DESC')->where(function($a) use ($request) { 
                                                if(!empty($request->status)) {  
                                                    $a->where('payments.status', $request->status);
                                                }      
                                                if(!empty($request->payment_method)) {
                                                    $a->where('payments.payment_method', $request->payment_method);
                                                }
                                                if(!empty($request->startdate)) {        
                                                    $a->where('appointments.date', '>=', date('Y-m-d', strtotime($request->startdate))); 
                                                }
                                                if(!empty($request->enddate)) {        
                                                    $a->where('appointments.date', '<=', date('Y-m-d', strtotime($request->enddate))); 
                                                }
                                            })->get();                      
                                
        }
        
        return view('payments.index',compact('data','payment_history','custom','site','rowIndex'));
    }
}
