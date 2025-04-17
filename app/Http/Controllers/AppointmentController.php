<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Entities\User;
use App\Helper\Helper;
use App\Entities\Payment;
use App\Entities\Service;
use App\Entities\Setting;
use App\Entities\Category;
use App\Traits\Pagination;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use App\Entities\WorkingHour;
use App\Entities\Employee;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Services\Interfaces\IService;
use App\Http\Requests\AppointmentValidation;
use App\Http\Services\Interfaces\IPaymentService;
use App\Http\Services\Interfaces\IEmployeeService;
use App\Http\Services\Interfaces\IAppointmentService;

class AppointmentController extends Controller
{
    use Pagination;

    protected $appointmentService, $employeeService, $service, $payment, $custom;

    public function __construct(IAppointmentService $appointmentService, IEmployeeService $employeeService, IService $service,IpaymentService $paymentService)
    {
        $this->appointmentService = $appointmentService;
        $this->employeeService = $employeeService;
        $this->service = $service;
        $this->payment = $paymentService;
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }

    public function dashboard()
    {

        if(Auth::user()->role_id == 1)

            $appointments = Appointment::where('admin_id', Auth::user()->id)->get();

        else if(Auth::user()->role_id == 2 ) {

            $appointments = Appointment::where('user_id', Auth::user()->id)->get();

            $latestNotifications = DB::table('notification')->where('user_id',Auth::user()->id)->limit(3)->orderBy('id','desc')->get();

            return view('customer-dashboard', compact('appointments','latestNotifications')); 

        }       

        else if(Auth::user()->role_id == 3 )

            $appointments = Appointment::where('employee_id', Auth::user()->id)->get();
            
        else {

            $appointments = array();

        }

        $user = User::where('parent_user_id',Auth::user()->id)->where('role_id',2)->get()->count();

        $employee = Employee::where('parent_user_id',Auth::user()->id)->where('role_id', 3)->get()->count();

        $payment = Payment::get()->count();

        $todayAppointment = Appointment::where('date',date('Y-m-d'))->get()->count();

        return view('dashboard', compact('appointments','user','employee','payment','todayAppointment'));
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('appointments',Auth::user());
        $site = DB::table('site_configs')->first();
        $custom = Setting::first();
        $services = Service::where('user_id',Auth::user()->id)->get();
        $filtercustomers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        $employees = User::where('role_id',3)->where('parent_user_id',Auth::user()->id)->get();
        $request->session()->forget('frm');
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        if($request->has('search')) {
            if($request->search == 'today')
                $appointments = Appointment::where('admin_id',Auth::user()->id)->where('date',date('Y-m-d'))->orderBy('id','DESC')->get();
            else
                return redirect()->route('unauthorized');
        } else {
            $appointments = Appointment::where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get();
        }
        $customers = User::where('parent_user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('appointments.index',compact('appointments','customers','custom','site','rowIndex','services','filtercustomers','employees'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $this->authorize('appointments',Auth::user());
        $now = Carbon::today()->addMonth(2);
        $maximum_select_date = $now->format('Y-m-d');
        $country = SiteConfig::first();
        $custom = Setting::first();
        $employees = array(); 
        $categoriess = Category::where('user_id',Auth::user()->id)->get();
        $categories = Category::select('categories.id','categories.name')
                                ->join('services','categories.id','=','services.category_id')
                                ->where('categories.user_id',Auth::user()->id)
                                ->groupBy('categories.id')
                                ->get();

        if(Auth::user()->role_id == 2){
            $services = Service::where('user_id',Auth::user()->parent_user_id)->get();
        } else {
            $services = Service::where('user_id',Auth::user()->id)->get();
        }

        if(Auth::user()->role_id == 2){
            $customers = User::where('role_id',2)->where('id',Auth::user()->id)->get();
        } else {
            $customers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        } 
        return view('appointments.create', compact('employees','services','customers','categories','maximum_select_date','custom','country'));
    }

    public function emp(Request $request) 
    {
        $custom = Setting::first();
        $admin = User::where('role_id',1)->first();
        if($custom->employees == 1) {
            $query = DB::table('employee_services')
                        ->join('users', 'users.id' ,'=', 'employee_services.employee_id')
                        ->join('working_hours','working_hours.employee_id','=','users.id')
                        ->select('working_hours.start_time','working_hours.finish_time','users.first_name', 'users.last_name','users.id','users.status')
                        ->where('employee_services.service_id', '=', $request->id)
                        ->where('users.status',1)
                        ->get(); 
            if($query->isEmpty()){
                $query = User::where('id',Auth::user()->id)->get();
            }
        }else {
            $query = User::where('id',$admin->id)->get();
        }

        return response()->json(['data' => $query]);
    }
    
    /**
     * Store a newly created resource in storage
     *
     * @param AppointmentValidation $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */

    public function store(AppointmentValidation $request)
    {
        $this->authorize('appointments',Auth::user());
        $smtp = Setting::first();
        $slots = explode('-',$request->slots);
        $start_time = date('H:i:00',strtotime(trim($slots[0])));
        $finish_time = date('H:i:00',strtotime(trim($slots[1])));

        $workingHour =  WorkingHour::where('employee_id',$request->employee_id)->first();
        if(empty($workingHour)) {
            return response()->json(['status' => false,'data' => trans('You are selected date or time those employee not available')]);
        }else{
            $test = Appointment::where('service_id',$request->input('service_id'))
                                ->where('employee_id',$request->input('employee_id'))
                                ->where('date', date('Y-m-d', strtotime($request->input('date'))))
                                ->where('status','!=','cancel')
                                ->where(function($query) use ($start_time,$finish_time) {
                                    $query->where([
                                            ['start_time','>=',$start_time],
                                            ['finish_time','<=',$finish_time]])
                                        ->orwhere([
                                            ['start_time','<=',$start_time],
                                            ['finish_time','>=',$finish_time]])
                                        ->orwhere([
                                            ['start_time','<',$start_time],
                                            ['finish_time','>',$finish_time]]);
                                        })->first();  
                                        
                                        
                        if(empty($test)) {  
                            $post = $request->except(['_token','slots']);
                            $post["start_time"] = $start_time;
                            $post["finish_time"] = $finish_time;
                            $service = Service::where('name',$post['service_id'])->first();
                            if($service->auto_approve == 1) {
                                $post['status'] = 'approved';
                            }else if($service->auto_approve == 0) {
                                $post['status'] = 'pending';
                            }
                          
                            $appointment = $this->appointmentService->insert(new Appointment($post));
                            $post['appointment_id'] = $appointment->id;
                            $post['payment_method'] = 'offline';
                            $post['currency'] = 'inr';
                            $post['amount'] = $service->price;
                            $post['tax'] = $service->tax;
                            $post['status'] = 'pending';
                            $this->payment->insert(new Payment($post));
                            $user = User::where('id', $appointment->user_id)->first();
                            $notificationMsg = trans('notification_appointment_book', [
                                'name' => $user->first_name.' '.$user->last_name,
                                'date' => date($smtp->date_format,strtotime($appointment->date)),
                                'start' => date('h:i A',strtotime($appointment->start_time)),
                                'end' => date('h:i A',strtotime($appointment->finish_time))
                            ]);//'Hey '.$user->first_name.' '.$user->last_name.', Your Appointment on'.' '.date($smtp->date_format,strtotime($appointment->date)).' '.'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)).' '.'has been booked successfully.';
                            $notificationArray = [
                                'user_id'=> $appointment->user_id,
                                'employee_id'=> $appointment->employee_id,
                                'admin_id'=> 1,
                                'appointment_id'=>$appointment->id,
                                'type'=>'appointment',
                                'message'=> $notificationMsg,
                                'is_read'=> 0,
                                'created_at'=>date('Y-m-d H:i:s'),
                                'updated_at'=>date('Y-m-d H:i:s'),
                            ];
                           
                            $admin = User::where('id', $appointment->admin_id)->first();
                            $employee = User::where('id', $appointment->employee_id)->first();
                            DB::table('notification')->insert($notificationArray);
                            $adminMessage = trans('notification_appointment_created',[
                                'name' => $admin->first_name.' '.$admin->last_name,
                                'date' => date($smtp->date_format, strtotime($appointment->date)),
                                'start' => date('h:i A',strtotime($appointment->start_time)),
                                'end' => date('h:i A',strtotime($appointment->finish_time))
                            ]);//'Hey '.$admin->first_name.' '.$admin->last_name.', Appointment Created'.' '.date($smtp->date_format, strtotime($appointment->date)).' '.'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)); 
                            $employeeMessage = trans('notification_appointment_created',[
                                'name' => $employee->first_name.' '.$employee->last_name,
                                'date' => date($smtp->date_format, strtotime($appointment->date)),
                                'start' => date('h:i A',strtotime($appointment->start_time)),
                                'end' => date('h:i A',strtotime($appointment->finish_time))
                            ]);//'Hey '.$employee->first_name.' '.$employee->last_name.', Appointment Created'.' '.date($smtp->date_format, strtotime($appointment->date)).' '.'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)); 
                            
                            $notificationArray["message"] = $adminMessage;
                            $notificationArray["user_id"] = 1;
                            DB::table('notification')->insert($notificationArray);

                            $notificationArray["user_id"] = $appointment->employee_id;
                            $notificationArray["message"] = $employeeMessage;
                            DB::table('notification')->insert($notificationArray);
                            
                            $employee = User::where('id',$request->employee_id)->first();
                            $customer = User::where('id',$request->user_id)->where('parent_user_id',Auth::user()->id)->first();
                            
                            // Start Google calender event code
                            $access_token = \App\Entities\employeeSettings::where('employee_id', $appointment->employee_id)->first();

                            if(!empty($access_token)) {
                                $accessToken = $access_token->access_token;
                                $refreshToken = $access_token->refresh_token;
                                $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken ,$refreshToken, $appointment->employee_id);
                                if($timezone['status']) {
                                    $data = array(
                                        "summary" => $appointment->service_id.' ('.$appointment->category_id.')',
                                        "location" => "Surat",
                                        "description" => $appointment->comments,
                                        "customer" => array('email' => $customer->email),
                                    );
    
                                    $time = array(
                                        "event_date" => $appointment->date,
                                        "start_time" => $appointment->start_time,
                                        "end_time" => $appointment->finish_time,
                                    );
                                   
                                    $google_appointment_id = \App\Helper\GoogleCal::CreateCalendarEvent($accessToken, $employee->email, $data, 0, $time, $timezone['value'],$appointment->employee_id,$refreshToken);
                                  
                                    if($google_appointment_id['status']) {
                                        Appointment::where('id',$appointment->id)->update([
                                            'google_appointment_id' => $google_appointment_id['id']
                                        ]);
                                    }
                                }

                            }
                            // End Google calender event code
                            
                            $smtp = Setting::first();
                            $site = SiteConfig::first();
                            if(Auth::user()->role_id == 1)
                            {
                                if($smtp->smtp_mail == 1) {
                                    $data = array(
                                        'name' => $employee->first_name.' '.$employee->last_name,
                                        'to' => $employee->email,
                                        'subject' => trans('Appointment Created'),
                                        'title' => trans('Appointment Created'),
                                        'template' => 'mail.appointments_email',
                                        'employee'=>$employee,
                                        'appointment'=>$appointment,
                                        'customer'=>$customer,
                                        'site_name' => $site->site_title,
                                        'company_name'=>$site->company_name,
                                        'status' => $appointment->status,
                                        "body"=>"mail"
                                    );
                                
                                    Setting::first();
                                    Helper::emailinformation($data);

                                    $data = array(
                                        'name' => $customer->first_name.' '.$customer->last_name,
                                        'to' => $customer->email,
                                        'subject' => trans('Appointment Created!'),
                                        'title' => trans('Appointment Created'),
                                        'template' => 'mail.appointments_email',
                                        'customer'=>$customer,
                                        'employee'=>$employee,
                                        'appointment'=>$appointment,
                                        'site_name' => $site->site_title,
                                        'company_name'=>$site->company_name,
                                        "body"=>"mail"
                                    );
                                    
                                    Helper::emailinformation($data);
                                }
                            }

                            /*if($smtp->notification) {
                                $appDate = date('F j, Y', strtotime($appointment->date));
                                $startTime = date('h:i A', strtotime($appointment->start_time));
                                $endTime = date('h:i A', strtotime($appointment->finish_time));
                                if($smtp->twilio_notify_customer) {
                                    $notificationArr = array(
                                        'to' => trim($customer->phone),
                                        'body' => trans_choice('customer_appointment_notification', 0, [
                                            'customer' => $user->first_name,
                                            'service' => $appointment->service_id,
                                            'time' => $startTime.' - '.$endTime,
                                            'date' => $appDate,
                                            'employee' => $employee->first_name.' '.$employee->last_name
                                        ])
                                    );
                                    Helper::notification($notificationArr);
                                }

                                if($smtp->twilio_notify_employee) {
                                    $notificationArr = array(
                                        'to' => trim($employee->phone),
                                        'body' => trans_choice('employee_appointment_notification', 0, [
                                            'employee' => $employee->first_name,
                                            'service' => $appointment->service_id,
                                            'time' => $startTime.' - '.$endTime,
                                            'date' => $appDate,
                                            'customer' => $user->first_name.' '.$user->last_name
                                        ])
                                    );
                                    Helper::notification($notificationArr);
                                }

                                if($smtp->twilio_notify_admin) {
                                    $notificationArr = array(
                                        'to' => trim($admin->phone),
                                        'body' => trans_choice('admin_appointment_notification', 0, [
                                            'admin' => $admin->first_name,
                                            'employee' => $employee->first_name.' '.$employee->last_name,
                                            'service' => $appointment->service_id,
                                            'time' => $startTime.' - '.$endTime,
                                            'date' => $appDate,
                                            'customer' => $user->first_name.' '.$user->last_name
                                        ])
                                    );
                                    Helper::notification($notificationArr);
                                }
                            }*/
                            return response()->json(['status' => true,'data' => trans('Appointment booked successfully'),'url' => route('dashboard')]);
                }else {
                    return response()->json(['status' => false,'data' => trans('These appointments you selected date and time already booked. please select another time and date for this appointment')]);
                }          
        }
       
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        $custom = Setting::first();
        if(in_array(auth()->user()->role_id, ['1'])) {
            $appointment = Appointment::where('id',$appointment->id)->where('employee_id',$appointment->employee_id)->where('admin_id',Auth::user()->id)->first();
        } elseif(in_array(auth()->user()->role_id, ['3'])) {
            $appointment = Appointment::where('id',$appointment->id)->where('employee_id',Auth::user()->id)->first();
        } else {
            $appointment = Appointment::where('id',$appointment->id)->where('user_id',Auth::user()->id)->where('employee_id',$appointment->employee_id)->first();
        } 
        if(empty($appointment)) {
            return redirect()->route('unauthorized');
        }
        return view('appointments.show',compact('appointment','custom'));
    }

    public function customerview(Request $request,$id)
    {
        $custom = Setting::all();
        $latestNotifications = DB::table('notification')->limit(3)->orderBy('id','desc')->get();
        $custom = Setting::first();
        if(in_array(auth()->user()->role_id, ['2'])) {
            $appointment = Appointment::where('id',$id)->first();
           
        }
        if(empty($appointment)) {
            return redirect()->route('unauthorized');
        }
        
        return view('customer-appointment',compact('appointment','custom','latestNotifications','custom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment,Request $request)
    {
        $this->authorize('appointments',Auth::user());
        $custom = Setting::first();
        if(Auth::user()->role_id == 2){
            $customers = User::where('role_id',2)->where('id',Auth::user()->id)->get();
        } else {
            $customers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        }
        $services = Service::where('user_id',Auth::user()->id)->get();
        $categoriess = Category::where('user_id',Auth::user()->id)->get();
        $categories = Category::select('categories.id','categories.name')
                                ->join('services','categories.id','=','services.category_id')
                                ->where('categories.user_id',Auth::user()->id)
                                ->groupBy('categories.id')
                                ->get();
        $employee = DB::table('employee_services')
                        ->join('users', 'users.id' ,'=', 'employee_services.employee_id')
                        ->join('working_hours','working_hours.employee_id','=','users.id')
                        ->select('working_hours.start_time','working_hours.finish_time','users.first_name', 'users.last_name','users.id')
                        ->where('employee_services.service_id', '=', $appointment->service_id)
                        ->get();
        $app = Appointment::where('employee_id',$appointment->employee_id)->where('admin_id',Auth::user()->id)->first();
        if(empty($app)) {
            return redirect()->back();
        }
        return view('appointments.edit',compact('appointment','services','employee','categories','customers','custom'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {  
        $this->authorize('appointments',Auth::user());
        $custom = Setting::first();
        $slots = explode('-',$request->slots);
        $start_time = date('H:i:s',strtotime(trim($slots[0])));
        $finish_time = date('H:i:s',strtotime(trim($slots[1])));
       
        $workingHour =  WorkingHour::where('employee_id',$request->employee_id)->where('start_time','<=',$start_time)->where('finish_time','>=',$finish_time)->first();
        if(empty($workingHour)) {
                session()->flash('message', trans('You are selected date or time those employee not available'));
                return redirect()->back()->withInput();
        }else{
            $searchApoointment = Appointment::where('service_id',$request->input('service_id'))
                                ->where('employee_id',$request->input('employee_id'))
                                ->where('date', date('Y-m-d', strtotime($request->input('date'))))
                                ->where(function($query) use ($start_time,$finish_time) {
                                    $query->where([
                                            ['start_time','>=',$start_time],
                                            ['finish_time','<=',$finish_time]])
                                        ->orwhere([
                                            ['start_time','<=',$start_time],
                                            ['finish_time','>=',$finish_time]])
                                        ->orwhere([
                                            ['start_time','<',$start_time],
                                            ['finish_time','>',$finish_time]]);
                                        })->first();   
                if(empty($searchApoointment)) {
                            Appointment::where('id','=',$appointment->id)
                                                    ->update(['service_id'=>$request->service_id,
                                                    'date'=>$request->date,
                                                    'employee_id'=>$request->employee_id,
                                                    'start_time'=>$start_time,
                                                    'finish_time'=>$finish_time,
                                                    'comments'=>$request->comments]);
                            session()->flash('message', trans('Appointment updated successfully'));
                            return redirect()->route('appointments.index');
                }
                else{
                    session()->flash('message', trans('These appointments you selected date and time already booked. please select another time and date for this appointment'));
                    return redirect()->back()->withInput();
                }                    
            }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        $this->appointmentService->delete($appointment->id);
        session()->flash('message', trans('Appointment deleted successfully'));
        return redirect()->route('appointments.index');
    }

    public function approval($id) {
        $status= Appointment::where('id',$id)
            ->update([
                'status'=>'approved',
                'cancel_reason' => null,
                'approved_by'=>Auth::user()->id
            ]);
        
        $status = Appointment::find($id);
        $appointment = Appointment::where('id',$id)->first();
        $customer = User::where('id',$status->user_id)->first();
        $employee = User::where('id',$status->employee_id)->first();
        
        $notificationMsg = trans('sms_notification_approved',[
            'name' => $appointment->user->first_name.' '.$appointment->user->last_name,
            'date' => $appointment->date,
            'start' => $appointment->start_time,
            'end' => $appointment->finish_time
        ]);//$appointment->user->first_name.' '.$appointment->user->last_name.' '. 'Your appointment of'.' '.$appointment->date.' '. 'has been Approved.your time is'.' '.$appointment->start_time.' To '.$appointment->finish_time;
        
        $notificationArray = [
            'user_id'=>$appointment->user_id,
            'employee_id'=>$appointment->employee_id,
            'admin_id'=>$appointment->admin_id,
            'appointment_id'=>$appointment->id,
            'type'=>'Appointment',
            'message'=> $notificationMsg,
            'is_read'=> 0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ];

        $admin = User::where('id', $appointment->admin_id)->first();
        $employee = User::where('id', $appointment->employee_id)->first();
        DB::table('notification')->insert($notificationArray);
        $adminMessage = trans('notification_appointment_approve',[
            'name' => $admin->first_name.' '.$admin->last_name,
            'date' => $appointment->date,
            'start' => $appointment->start_time,
            'end' => $appointment->finish_time
        ]);//$admin->first_name.' '.$admin->last_name.' '. $appointment->date.' '.'appointment has been Approved. time '.' '.$appointment->start_time.' To '.$appointment->finish_time.'';
        $employeeMessage = trans('notification_appointment_approve',[
            'name' => $employee->first_name.' '.$employee->last_name,
            'date' => $appointment->date,
            'start' => $appointment->start_time,
            'end' => $appointment->finish_time
        ]);//$employee->first_name.' '.$employee->last_name.' '. $appointment->date.' '.'appointment'.' '. 'has been Approved. Your time is'.' '.$appointment->start_time.' To '.$appointment->finish_time.'';
        
        $notificationArray["message"] = $adminMessage;
        $notificationArray["user_id"] = 1;
        DB::table('notification')->insert($notificationArray);

        $notificationArray["user_id"] = $appointment->employee_id;
        $notificationArray["message"] = $employeeMessage;
        DB::table('notification')->insert($notificationArray);
        if(!empty($appointment->google_appointment_id)) {
            // Start Google calender event code
            $access_token = \App\Entities\employeeSettings::where('employee_id', $appointment->employee_id)->first();
            $refreshToken = $access_token->refresh_token;
            if(!empty($access_token)) {
                $accessToken = $access_token->access_token;
                $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken,$refreshToken,$appointment->employee_id);
                if($timezone['status']) {
                    $data = array(
                        "date" => $appointment->date,
                        "start" => $appointment->start_time,
                        "end" => $appointment->finish_time,
                        "status" => $appointment->status
                    );
                    \App\Helper\GoogleCal::updateCalendarsEvents($employee->email, $accessToken,$refreshToken, $appointment->google_appointment_id, $data, $timezone['value'],$appointment->employee_id);
                }
            }
            // End Google calender event code                                            
        }
        
            $smtp = Setting::first();
            $site = SiteConfig::first();
            if(Auth::user()->role_id == 3) {
                if($smtp->smtp_mail == 1) {
                    $admin = User::where('id',$status->admin_id)->first();
                    $admin_email = DB::table('site_configs')->first();
                    $approved_text = trans('notification_approval_text',[
                        'title' => $site->site_title
                    ]);
                    $data = array(
                        'name' => $admin->first_name.' '.$admin->last_name,
                        'to' => $admin->email,
                        'subject' => trans('Appointment Approved'),
                        'title' => trans('Appointment Confirmation'),
                        'template' => 'mail.appointments_email',
                        'admin'=>$admin,
                        'admin_email'=>$admin_email,
                        'customer'=>$customer,
                        'appointment'=> $appointment,
                        'employee'=>$employee,
                        'site_name' => $site->site_title,
                        'company_name'=>$site->company_name,
                        'approved_text' => $approved_text,//"Your appointment has been Approved on $site->site_title. The appointment approved details are as below:",
                        'body' => 'mail'
                    );
        
                    Helper::emailinformation($data);

                    $data = array(
                        'name' => $customer->first_name.' '.$customer->last_name,
                        'to' => $customer->email,
                        'subject' => trans('Appointment Approved'),
                        'title' => trans('Appointment Confirmation'),
                        'template' => 'mail.appointments_email',
                        'customer'=>$customer,
                        'appointment'=> $appointment,
                        'employee'=>$employee,
                        'site_name' => $site->site_title,
                        'company_name'=>$site->company_name,
                        'approved_text' => $approved_text,//"Your appointment has been Approved on $site->site_title. The appointment approved details are as below:",
                        'body' => 'mail'
                    );

                    Helper::emailinformation($data);
                }
            }
            if(Auth::user()->role_id == 1 && $smtp->smtp_mail == 1) {
                $approved_text = trans('notification_approval_text',[
                    'title' => $site->site_title
                ]);
                $data = array(
                    'name' => $employee->first_name.' '.$employee->last_name,
                    'to' => $employee->email,
                    'subject' => trans('Appointment Approved'),
                    'title' => trans('Appointment Confirmation'),
                    'template' => 'mail.appointments_email',
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'approved_text' => $approved_text,//"Your appointment has been Approved on $site->site_title. The appointment approved details are as below:",
                    'body' => 'mail'
                );

                Helper::emailinformation($data);
                
                $data = array(
                    'name' => $customer->first_name.' '.$customer->last_name,
                    'to' => $customer->email,
                    'subject' => trans('Appointment Approved'),
                    'title' => trans('Appointment Confirmation'),
                    'template' => 'mail.appointments_email',
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'approved_text' => $approved_text,//"Your appointment has been Approved on $site->site_title. The appointment approved details are as below:",
                    'body' => 'mail'
                );

                Helper::emailinformation($data);
            }
        session()->flash('message', trans('Appointment approved successfully'));
        return redirect()->route('dashboard');
    }

    public function cancel($id,Request $request) 
    {  
        $this->validate($request,[
            'cancel_reason' => 'required'
        ]);
        $custom = Setting::first();
        $appointment = Appointment::where('id',$id)->first();
        $date = date('Y-m-d h:i:s',strtotime($appointment->date.' '.$appointment->start_time));
        $date = new Carbon($date);
        $today = Carbon::now();
        $service_id = $appointment->service_id;
        $services = Service::where('name', $service_id)->first();
        if(!empty($services)) {
            $cancel_before = $services->cancel_before;
        
            $difference = $today->diff($date)->format('%H:%i:%s');
        
        
            if($difference < $cancel_before && $date == $today) {
                session()->flash('error-message', trans('You cannot cancel appointment because appointment cancellation time is over'));
                return redirect()->back();
            }
        }

        $cancel = Appointment::find($id)
                ->update([
                    'status'=>'cancel',
                    'approved_by'=>Auth::user()->id,
                    'cancel_reason'=>$request->cancel_reason
                ]);

        $cancel = Appointment::find($id); 
        $employee = User::where('id',$cancel->employee_id)->first();
        $customer = User::where('id',$cancel->user_id)->first();
        $appointment = Appointment::where('id',$id)->first();
    
        $notificationMsg = trans('notification_appointment_cancel',[
            'name' => $appointment->user->first_name.' '.$appointment->user->last_name,
            'date' => date($custom->date_format, strtotime($appointment->date)),
            'start' => date('h:i A',strtotime($appointment->start_time)),
            'end' => date('h:i A',strtotime($appointment->finish_time))
        ]);//'Hey '.$appointment->user->first_name.' '.$appointment->user->last_name.', '. 'Your appointment on'.' '.date($custom->date_format, strtotime($appointment->date)).' '. 'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)).' '.'as been cancelled';
        $notificationArray = [
            'user_id'=>$appointment->user_id,
            'employee_id'=>$appointment->employee_id,
            'admin_id'=>$appointment->admin_id,
            'appointment_id'=>$appointment->id,
            'type'=>'Cancel',
            'message'=> $notificationMsg,
            'is_read'=> 0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ];

            $admin = User::where('id', $appointment->admin_id)->first();
            $employee = User::where('id', $appointment->employee_id)->first();
            DB::table('notification')->insert($notificationArray);
            $adminMessage = trans('notification_appointment_cancel',[
                'name' => $admin->first_name.' '.$admin->last_name,
                'date' => date($custom->date_format, strtotime($appointment->date)),
                'start' => date('h:i A',strtotime($appointment->start_time)),
                'end' => date('h:i A',strtotime($appointment->finish_time))
            ]);//'Hey '.$admin->first_name.' '.$admin->last_name.' '. ' appointment date'.' '.date($custom->date_format, strtotime($appointment->date)).' '. 'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)).' '.'as been cancelled';
            $employeeMessage = trans('notification_appointment_cancel',[
                'name' => $employee->first_name.' '.$employee->last_name,
                'date' => date($custom->date_format, strtotime($appointment->date)),
                'start' => date('h:i A',strtotime($appointment->start_time)),
                'end' => date('h:i A',strtotime($appointment->finish_time))
            ]);//'Hey '.$employee->first_name.' '.$employee->last_name.' '. 'appointment date'.' '.date($custom->date_format, strtotime($appointment->date)).' '. 'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)).' '.'as been cancelled';
            
            $notificationArray["message"] = $adminMessage;
            $notificationArray["user_id"] = 1;
            DB::table('notification')->insert($notificationArray);
    
            $notificationArray["user_id"] = $appointment->employee_id;
            $notificationArray["message"] = $employeeMessage;
            DB::table('notification')->insert($notificationArray);
           
            if(!empty($appointment->google_appointment_id)) {

                // Start Google calender event code
                $access_token = \App\Entities\employeeSettings::where('employee_id', $appointment->employee_id)->first();
               
                if(!empty($access_token)) {
                    $accessToken = $access_token->access_token;
                    $refreshToken = $access_token->refresh_token;
                    $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken,$refreshToken,$appointment->employee_id);
                   
                    if($timezone['status']) {
                        $data = array(
                            "date" => $appointment->date,
                            "start" => $appointment->start_time,
                            "end" => $appointment->finish_time,
                            "status" => $appointment->status
                        );
                      
                      \App\Helper\GoogleCal::updateCalendarsEvents($employee->email, $accessToken,$refreshToken, $appointment->google_appointment_id, $data, $timezone['value'],$appointment->employee_id);
                    }
                }
                // End Google calender event code
            }
        if(Auth::user()->role_id == 1) {
            $customer = User::where('id',$cancel->user_id)->first();
            $employee = User::where('id',$cancel->employee_id)->first();
            $appointment = Appointment::where('id',$id)->first();
            $smtp = Setting::first();
            $site = SiteConfig::first();
            if($smtp->smtp_mail == 1) {
                $to_customer_email = $customer->email;

                $employee = User::where('id',$cancel->employee_id)->first();
                $to_employee_email = $employee->email;
                $cancel_text = trans('notification_cancel_text',[
                    'title' => $site->site_title
                ]);
                $data = array(
                    'name' => $customer->first_name.' '.$customer->last_name,
                    'to' =>  $to_customer_email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' =>  trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'employee'=>$employee,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);

    
                $data = array(
                    'name' => $employee->first_name.' '.$employee->last_name,
                    'to' => $to_employee_email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'employee'=>$employee,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);
            }
        }

        if(Auth::user()->role_id == 2) {
            $employee = User::where('id',$cancel->employee_id)->first();
            $appointment = Appointment::where('id',$id)->first();

            $smtp = Setting::first();
            $site = SiteConfig::first();
            if($smtp->smtp_mail == 1) {
                $to_employee_email = $employee->email;
                $admin = User::where('id',$cancel->admin_id)->first();
                $to_admin_email = $admin->email;
                $cancel_text = trans('notification_cancel_text',[
                    'title' => $site->site_title
                ]);
                $data = array(
                    'name' => $customer->first_name.' '.$customer->last_name,
                    'to' =>  $customer->email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'admin'=>$admin,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);

                $data = array(
                    'name' => $employee->first_name.' '.$employee->last_name,
                    'to' => $employee->email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'employee'=>$employee,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);

                $admin_email = DB::table('site_configs')->first();
            
                $data = array(
                    'name' => $admin->first_name.' '.$admin->last_name,
                    'to' => $admin->email,
                    'subject' => trans('Appointment Cancelled'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'admin'=>$admin,
                    'admin_email'=>$admin_email,
                    'site_name' => $site->site_title,
                    'company_name'=>$admin_email->company_name,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    'body' => 'mail'
                );
      
                Helper::emailinformation($data);
            }
        }

        if(Auth::user()->role_id == 3) {
            $customer = User::where('id',$cancel->user_id)->first();
            $employee = User::where('id',$cancel->employee_id)->first();
            $appointment = Appointment::where('id',$id)->first();

            $smtp = Setting::first();
            $site = SiteConfig::first();
            if($smtp->smtp_mail == 1) {
                $to_customer_email = $customer->email;
                $admin = User::where('id',$cancel->admin_id)->first();
                $to_admin_email = $admin->email;
                $cancel_text = trans('notification_cancel_text',[
                    'title' => $site->site_title
                ]);
                $data = array(
                    'name' => $admin->first_name.' '.$admin->last_name,
                    'to' => $to_admin_email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'admin'=>$admin,
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);

                $data = array(
                    'name' => $customer->first_name.' '.$customer->last_name,
                    'to' =>  $to_customer_email,
                    'subject' => trans('Appointment Cancelled!'),
                    'title' => trans('Appointment Cancellation'),
                    'template' => 'mail.appointments_email',
                    'customer'=>$customer,
                    'appointment'=> $appointment,
                    'employee'=>$employee,
                    'site_name' => $site->site_title,
                    'company_name'=>$site->company_name,
                    'cancel_text' => $cancel_text,//"Your appointment has been Canceled on $site->site_title. The appointment canceled details are as below:",
                    "body"=>"mail"
                );
                Helper::emailinformation($data);

            }
        }
       
        session()->flash('message', trans('Appointment cancelled successfully'));
        return redirect()->route('dashboard');
    }

    public function complete($id,Request $request) 
    { 
       
        $complete = Appointment::where('id',$id)
        ->update([
            'status'=>'completed',
            'note'=>$request->note,
            'approved_by'=>Auth::user()->id
            
        ]);
        $complete = Appointment::find($id);
        $custom = Setting::first();
        $notificationMsg = trans('notification_appointment_complete',[
            'name' => $complete->user->first_name.' '.$complete->user->last_name,
            'date' => date('$custom->date_format' ,strtotime($complete->date)),
            'start' => $complete->start_time,
            'end' => $complete->finish_time
        ]);//$complete->user->first_name.' '.$complete->user->last_name.' '. 'Your appointment of'.' '.date('$custom->date_format' ,strtotime($complete->date)).' '. 'has been Completed. Your time is'.' '.$complete->start_time.' To '.$complete->finish_time.' ';
       
        $notificationArray = [
            'user_id'=>$complete->user_id,
            'employee_id'=>$complete->employee_id,
            'admin_id'=>$complete->admin_id,
            'appointment_id'=>$complete->id,
            'type'=>'completed',
            'message'=>$notificationMsg,
            'is_read'=> 0,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s'),
        ];

            $admin = User::where('id', $complete->admin_id)->first();
            $employee = User::where('id', $complete->employee_id)->first();
            DB::table('notification')->insert($notificationArray);
            $adminMessage = trans('notification_appointment_complete',[
                'name' => $admin->first_name.' '.$admin->last_name,
                'date' => $complete->date,
                'start' => $complete->start_time,
                'end' => $complete->finish_time
            ]);//$admin->first_name.' '.$admin->last_name.' '. 'appointment date'.' '.$complete->date.' '. 'has been Completed. time'.' '.$complete->start_time.' To '.$complete->finish_time.' ';
            $employeeMessage = trans('notification_appointment_complete',[
                'name' => $employee->first_name.' '.$employee->last_name,
                'date' => $complete->date,
                'start' => $complete->start_time,
                'end' => $complete->finish_time
            ]);//$employee->first_name.' '.$employee->last_name.' '. 'appointment date'.' '.$complete->date.' '. 'has been Completed. time'.' '.$complete->start_time.' To '.$complete->finish_time.' ';
            
            $notificationArray["message"] = $adminMessage;
            $notificationArray["user_id"] = 1;
            DB::table('notification')->insert($notificationArray);
    
            $notificationArray["user_id"] = $complete->employee_id;
            $notificationArray["message"] = $employeeMessage;
            DB::table('notification')->insert($notificationArray);
            
       session()->flash('message', trans('Appointment completed successfully'));
       return redirect()->route('dashboard');
    }

    public function filter(Request $request)
    {
        if($request->isMethod('GET')) {
            return redirect()->route('appointments.index');
        }
        $request->session()->forget('frm');
        $custom = Setting::first();
        $services = Service::where('user_id',Auth::user()->id)->get();
        $filtercustomers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        if(!empty($request->service_id)) {
            $employees = User::where('role_id',3)
                                ->select('employee_services.employee_id','users.id','users.first_name','users.last_name')
                                ->join('employee_services','employee_services.employee_id','=','users.id')
                                ->where('parent_user_id',Auth::user()->id)
                                ->where('employee_services.service_id', $request->service_id)
                                ->get();         
        } else {
            $employees = User::where('role_id',3)->where('parent_user_id',Auth::user()->id)->get();
       }
        
       
        $latestNotifications = DB::table('notification')->limit(3)->orderBy('id','desc')->get();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }

        $data = $request->all();
        $service = $request->input('service_id');
        $employee = $request->input('employee_id');
        $user = $request->input('user_id');
        $admin = $request->input('admin_id');
        $status = $request->input('status');
        $startdate =  date('Y-m-d', strtotime($request->input('startdate')));
        $enddate = date('Y-m-d', strtotime($request->input('enddate')));
        
        if(!empty($service) && !empty($employee) && !empty($user) && !empty($admin) && !empty($status) && !empty($enddate) && !empty($startdate)) {
            $appointments = Appointment::where('admin_id',Auth::user()->id)->orderBy('id','DESC')->get();
        } else {
            $appointments = Appointment::where('admin_id',Auth::user()->id)->where(function($a) use ($request) {
                if(!empty($request->service_id)) {
                    $a->where('service_id', '=',$request->service_id);
                }
                if(!empty($request->employee_id)) {
                    $a->where('employee_id','=', $request->employee_id );
                }
                if(!empty($request->user_id)) {
                    $a->where('user_id','=', $request->user_id);
                }
                if(!empty($request->status)) {  
                    $a->where('status', $request->status );
                }      
                if(!empty($request->startdate)) {        
                    $a->where('date', '>=', date('Y-m-d', strtotime($request->startdate))); 
                }
                if(!empty($request->enddate)) {        
                    $a->where('date', '<=', date('Y-m-d', strtotime($request->enddate))); 
                }
            })->orderBy('date','ASC')->get();     
        }
        if(empty($request->service_id) && empty($request->employee_id) && empty($request->user_id) && empty($request->status) && empty($request->startdate) &&
            empty($request->enddate)) {
                return redirect()->back();
        }
        return view('appointments.index',compact('data','latestNotifications','custom','services','filtercustomers','employees','appointments','rowIndex'));  
    }

    public function customerAppointment() {
        if(Auth::check()) {
            if(Auth::user()->role_id == 1) {
                $field_name = 'admin_id';
            } else if(Auth::user()->role_id == 2) {
                $field_name = 'user_id';
            } else if (Auth::user()->role_id == 3) {
                $field_name = 'employee_id';
            }
            $appointments = Appointment::where($field_name, Auth::user()->id)->get();
            echo json_encode(['success'=> true, 'appointment'=> $appointments]);
        } else {
            echo json_encode(['success'=> false, 'appointment'=> array()]);
        }
    }
}
