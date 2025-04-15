<?php

namespace App\Http\Controllers\Front;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Entities\User;
use App\Entities\Payment;
use App\Entities\Service;
use App\Entities\Setting;
use App\Entities\Category;
use App\Entities\Employee;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use App\Entities\Notification;
use App\Entities\SiteConfig;
use App\Entities\WorkingHour;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\IUserRepository;
use App\Http\Services\Interfaces\IPaymentService;
use App\Http\Services\Interfaces\IAppointmentService;


class AppointmentController extends Controller
{
    protected $appointmentService, $userRepository, $payment, $custom;
    
    public function __construct(IAppointmentService $appointmentService,IUserRepository $userRepository,IpaymentService $paymentService) {
        $this->appointmentService = $appointmentService;
        $this->userRepository = $userRepository;
        $this->payment = $paymentService;
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }

    public function home(Request $request)
    {
        $categories = Category::with('services')->get();

        $services = Service::with('categories')->paginate(9);

        $employees = Employee::where('role_id',3)->where('status',1)->paginate(6);

        if(Auth::check()) {

            $latestNotifications = DB::table('notification')->where('user_id',Auth::user()->id)->limit(3)->orderBy('id','desc')->get();

            $site = DB::table('site_configs')->first();

            $custom = DB::table('settings')->first();

            return view('theme.home',compact('latestNotifications','site','custom','categories','services','employees'))->with(['pagetitle' => 'landing']);

        }

        $site = DB::table('site_configs')->first();

        $email = '';
        if($request->token != ''){
                $user = User::where('remember_token',$request->token)->first();
                if(empty($user)){
                    session()->flash('error-message',trans('Invalid Token'));
                    return redirect()->route('welcome');
                }
                $email = $user->email;

        }
        return view('theme.home',compact('site','categories','services','employees','email'))->with(['pagetitle' => 'landing']);
    }

    public function index()
    {
        $site = DB::table('site_configs')->first();
        $custom = Setting::first();
        $admin = User::where('role_id',1)->first();
        $categoriess = Category::all();
        $categories = Category::select('categories.id','categories.name')
                        ->join('services','categories.id','=','services.category_id')
                        ->groupBy('categories.id')
                        ->get();
                  
        $services = Service::all();
        $now = Carbon::today()->addMonth(2);
        $maximum_select_date = $now->format('Y-m-d');
        return view('theme.appointment',compact('categories','services','maximum_select_date','custom','site','admin'));
    }

    public function appointment(Request $request)
    {
        $slot = explode('-',$request->slot);
        $start_time = date('H:i:s',strtotime(trim($slot[0])));
        $finish_time = date('H:i:s',strtotime(trim($slot[1])));
        
        $appointment = Appointment::where('date', date('Y-m-d', strtotime($request->selectDate)))
                                    ->where('service_id',$request->service_id)
                                    ->where('employee_id',$request->employee_id)
                                    ->where('start_time',$start_time)
                                    ->where('finish_time',$finish_time)
                                    ->where('status','!=','cancel')
                                    ->first();
        if(!empty($appointment)) {
            return response()->json(['data' => trans('This time slot is already booked.')]);
        }
    }

    public function create(Request $request)
     {
        $validData = array(
            'category_id' => 'nullable',
            'service_id' => 'required',
            'date' => 'required',
            'slots' => 'required',
            'employee_id' => 'nullable',
            'comments' => 'required'
        );
        if(!Auth::check()) {
            $validData['last_name'] = 'required';
            $validData['first_name'] = 'required';
            $validData['phone'] = 'required|numeric';
            // |min:10|starts_with:+';
            $validData['email'] = 'required|email|unique:users';
        }
        $this->validate($request,$validData,[
            'category_id.required' => trans('Please Select Category'),
            'service_id.required' => trans('Please Select Service'),
            'date.required' => trans('Please Enter Date'),
            'employee_id.required' => trans('Please Select employee'),
            'first_name.required' => trans('Please enter first name'),
            'last_name.required' => trans('Please enter last name'),
            'phone.required' => trans('Please enter phone number'),
            'phone.numeric' => trans('Phone number must be numeric and digits'),
            // 'phone.min' => trans('Phone number should be minimum 10 digits'),
            // 'phone.starts_with' => trans('Phone number must be start with +'),
            'phone.unique' => trans('Phone number exists in the system'),
            'email.required' => trans('Please enter email'),    
            'email.email' => trans('Please enter valid email')
        ]);

        $slots = explode('-',$request->slots);
        $start_time = date('H:i:00',strtotime(trim($slots[0])));
        $end_time = date('H:i:00',strtotime(trim($slots[1])));
        $service = Service::where('id', $request->service_id)->first();
        if(empty($request->employee_id)) {
            $workingHour =  WorkingHour::where('employee_id',$service->user_id)->where('start_time','<=',$start_time)->where('finish_time','>=',$end_time)->first();
        }else {
            $workingHour =  WorkingHour::where('employee_id',$request->employee_id)->first();
        }
       
        if(empty($workingHour)) {
            session()->flash('error-message', trans('This Time Employee Not Available'));
            return response()->json(['data' => trans('This Time Employee Not Available')]);
        } else {
            $exists = Appointment::where('service_id',$request->input('service_id'))
                ->where('employee_id',$request->input('employee_id'))
                ->where('date', date('Y-m-d', strtotime($request->input('date'))))
                ->where('status','!=','cancel')
                ->where(function($query) use ($start_time,$end_time) {
                    $query->where([
                            ['start_time','>=',$start_time],
                            ['finish_time','<=',$end_time]])
                        ->orwhere([
                            ['start_time','<=',$start_time],
                            ['finish_time','>=',$end_time]])
                        ->orwhere([
                            ['start_time','<',$start_time],
                            ['finish_time','>',$end_time]]);
                })->first(); 
           
            if(empty($exists)) {
                $smtp = Setting::first();
                $site = SiteConfig::first();
                $existsCustomer = User::where('email','like','%'.$request->email.'%')->first();
                if(empty($existsCustomer)) {
                    $first_name = $request->first_name;
                    $last_name = $request->last_name;
                    $data = $request->only(['email','phone']);
                    $data["parent_user_id"] = 1;
                    $data["first_name"] = $first_name;
                    $data["last_name"] = $last_name;
                    //$data["password"] = 123456789;
                    $data["password"] = rand(100000000, 999999999);
                    $data["confirmed"] = 1;
                    $data["role_id"] = 2;
                    $data['country_name'] = $request->country_name;
                    $data['country_code'] = $request->country_code;
                    $data['country'] = $request->country; //new
                    $data['state'] = $request->state; //new
                    $data['city'] = $request->city; //new
                    $data['zipcode'] = $request->zipcode; //new
                    $data['goverment_id'] = $request->goverment_id; //new                    
                    $user = $this->userRepository->insert(new User($data));
                    $notificationMsg = 'Hey '.$user->first_name.' '.$user->last_name.', Thanks for registration. Enjoy unlimited appointment of different services!';
                    $notification = DB::table('notification')->insert([
                        'user_id'=> $user->id,
                        'employee_id'=> '',
                        'admin_id'=>1,
                        'appointment_id'=>'',
                        'type'=>'customer',
                        'message'=> $notificationMsg,
                        'is_read'=> 0,
                        'created_at'=>date('Y-m-d H:i:s'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    ]);
                    $user_id = $user->id;
                    Auth::loginUsingId($user_id);
                  
                    if($smtp->smtp_mail == 1) {
                        $data['title'] = trans('Account Created');
                        $data['subject'] = trans('New Customer');
                        $data['template'] = 'mail.emp_create_email';
                        $data['to'] = $user->email;
                        $data['name'] = $user->first_name.' '.$user->last_name;
                        $data['email'] = $user->email;
                        $data['site_name'] = $site->site_title;
                        $data['company_name'] = $site->company_name;
                        $data['body'] = "mail";
                        $mail = \App\Helper\Helper::emailinformation($data);
                    }
                } else {
                    $user_id = $existsCustomer->id;
                    if(!Auth::check()) {
                        return response()->json(['error' => trans('Email already exist in system. Please login and book a new appointment')]);
                    }

                    $updateData = [];

                    if (!empty($request->country)) {
                        $updateData['country'] = $request->country;
                    }
                    if (!empty($request->state)) {
                        $updateData['state'] = $request->state;
                    }
                    if (!empty($request->city)) {
                        $updateData['city'] = $request->city;
                    }
                    if (!empty($request->zipcode)) {
                        $updateData['zipcode'] = $request->zipcode;
                    }
                    if (!empty($request->goverment_id)) {
                        $updateData['goverment_id'] = $request->goverment_id;
                    }
                    
                    if (!empty($updateData)) {
                        $updated = DB::table('users')
                            ->where('id', $user_id)
                            ->update($updateData);
                    }                  

                }
                $post = $request->except(['_token','slots','number','email','name']);
                $post["start_time"] = $start_time;
                $post["finish_time"] = $end_time;
                $post["admin_id"] = 1;
                $post["user_id"] = $user_id;
                $service = Service::where('name', $request->service_id)->first();
                if(empty($post['employee_id'])) {
                    $post["employee_id"] = $service->user_id;
                }
                $service = Service::where('name',$post['service_id'])->first();
                if($service->auto_approve == 1) {
                    $post['status'] = 'approved';
                }else if($service->auto_approve == 0) {
                    $post['status'] = 'pending';
                }

                $post["appointment_process"] = 1;
                $appointment = $this->appointmentService->insert(new Appointment($post));
             
                $user = User::where('id', $user_id)->first();
                $employee = User::where('id', $appointment->employee_id)->first();
                // Start Google calender event code
                $access_token = \App\Entities\employeeSettings::where('employee_id', $appointment->employee_id)->first();
                if(!empty($access_token)) {
                    $accessToken = $access_token->access_token;
                    $refreshToken = $access_token->refresh_token;
                    $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken,$refreshToken,$appointment->employee_id);
                    if($timezone['status']) {
                        $data = array(
                            "summary" => $appointment->service_id.' ('.$appointment->category_id.')',
                            "location" => "Surat",
                            "description" => $appointment->comments,
                            "customer" => array('email' => $user->email),
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
                $last_appointment_id = $appointment->id;
                $post['appointment_id'] = $last_appointment_id;
                $post['payment_method'] = $request->payment_method;
                $post['currency'] = 'inr';
                $post['amount'] = $service->price;
                $post['status'] = 'pending';
                $post['tax'] = $service->tax;
                $this->payment->insert(new Payment($post));

                $notificationMsg = 'Hey '.$user->first_name.' '.$user->last_name.', Your Appointment successfully created!';
                $notificationArray = [
                    'user_id'=> $user_id,
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
                $adminMessage = 'Hey '.$admin->first_name.' '.$admin->last_name.',Appointment Created'.' '.date('d-m-Y',strtotime($appointment->date)).' '.'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)); 
                $employeeMessage = 'Hey '.$employee->first_name.' '.$employee->last_name.',Appointment Created'.' '.date('d-m-Y',strtotime($appointment->date)).' '.'at'.' '.date('h:i A',strtotime($appointment->start_time)).' To '.date('h:i A',strtotime($appointment->finish_time)); 
                
                $notificationArray["message"] = $adminMessage;
                $notificationArray["user_id"] = 1;
                DB::table('notification')->insert($notificationArray);

                $notificationArray["user_id"] = $appointment->employee_id;
                $notificationArray["message"] = $employeeMessage;
                DB::table('notification')->insert($notificationArray);
                
                $smtp = Setting::first();
                $site = SiteConfig::first();
                if($smtp->smtp_mail == 1 && $request->payment_method == 'offline') {
                    $data = array(
                        'name' => $user->first_name.' '.$user->last_name,
                        'to' => $user->email,
                        'title' => trans('Appointment Created'),
                        'subject' => trans('Appointment Booked'),
                        'template' => 'mail.appointments_email',
                        'customer' => $user,
                        'employee' => $employee,
                        'appointment' => $appointment,
                        'site_name' => $site->site_title,
                        'company_name' => $site->company_name,
                        'site' => $site
                    );
                    $mail = \App\Helper\Helper::emailinformation($data);

                    $admin = User::where('id', 1)->first();
                    $admin_email = DB::table('site_configs')->first();
                
                    $data = array(
                        'name' => $admin->first_name.' '.$admin->last_name,
                        'to' => $admin->email,
                        'title' => trans('Appointment Created'),
                        'subject' => trans('Appointment Booked'),
                        'template' => 'mail.appointments_email',
                        'customer' => $user,
                        'employee' => $employee,
                        'appointment' => $appointment,
                        'site' => $site,
                        'site_name' => $site->site_title,
                        'company_name' => $site->company_name,
                        'admin' => $admin,
                        'admin_email'=> $admin_email
                    );

                    $mail = \App\Helper\Helper::emailinformation($data);

                    $data = array(
                        'name' => $employee->first_name.' '.$employee->last_name,
                        'to' => $employee->email,
                        'title' => trans('Appointment Created'),
                        'subject' => trans('Appointment Booked'),
                        'template' => 'mail.appointments_email',
                        'customer' => $user,
                        'employee' => $employee,
                        'appointment' => $appointment,
                        'site' => $site,
                        'site_name' => $site->site_title,
                        'company_name' => $site->company_name,
                        'admin' => $admin,
                        'admin_email'=> $admin_email
                    );
                
                    $mail = \App\Helper\Helper::emailinformation($data);

                }
                return response()->json(['appointment_id'=> $appointment->id,'data' => trans('Thank you! Your Booking is Completed. You have successfully booked an appointment')]);
            } else {
                return response()->json(['error' => trans('This time slot is already booked')]);
            }
        }
    }

    public function remider() {
        $d = Carbon::now();
        $current_date = $d->format('y-m-d');
        $tomorrow_date =  $d->addDays(1)->format('y-m-d');
        $appointment_date = Appointment::where('date',$tomorrow_date)->where('status','approved')->get();
        $site = SiteConfig::first();
        foreach ($appointment_date as $key => $row) {
            $user = $row->user;
            $employee = $row->employee;
            $service = $row->service;
            $category = $row->category;
          
            $data = array(
                'name' => $user->first_name.' '.$user->last_name,
                'to' => $user->email,
                'title' => trans('Appointment Reminder'),
                'subject' => trans('Appointment Reminder'),
                'template' => 'mail.remider_email',
                'customer' =>  $user,
                'employee' =>  $employee,
                'appointment' => $row->start_time.' - '.$row->finish_time,
                'date' => $row->date,
                'service' => $service->name,
                'site_name' => $site->site_title,
                'company_name' => $site->company_name,
                'comments' => $row->comments
            );
            $mail = \App\Helper\Helper::emailinformation($data);
        }
        return response()->json(['massage'=> trans('Reminder mail successfully sent')]);
    }

    public function paymentTimeExpire(Request $request)
    {
       $appointment = Appointment::where('id',$request->appointment_id)->delete();
       $payment = Payment::where('appointment_id',$request->appointment_id)->delete();
       $notification = Notification::where('appointment_id', $request->appointment_id)->delete();
       return response()->json(['status'=>'success']);
    }
   
}
