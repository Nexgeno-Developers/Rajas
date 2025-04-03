<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Helper\Helper;
use App\Entities\Setting;
use App\Entities\SiteConfig;
use App\Helper\GoogleCal;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use Illuminate\Support\Carbon;
use App\Entities\employeeSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;

class GoogleCalendarController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['googleCalendarEventSync']);
    }

    public function googleCalendarEventSync(Request $request)
    {
        $custom = Setting::first();
        $client_id = $custom->google_client_id;
        $client_secret = $custom->google_client_secret;
        $redirect_uri = route('GoogleCalendarEventSync');
        // $redirect_uri = "http:\/\/readybook.zluck.in\/dev-tools\/calendar";
        $code = $request->code;
        $employee_id = ($request->has('state')) ? decrypt($request->state) : Auth::user()->id;
        $GoogleCalendarApi = GoogleCal::GetAccessToken($code ,$client_id, $client_secret, $redirect_uri);
        $refresh_token = $GoogleCalendarApi['refresh_token'];
        // $data = $GoogleCalendarApi->($client_id, $redirect_uri , $client_secret GetAccessToken,$code);
        $access_token = $GoogleCalendarApi['access_token'];
        $event_create = employeeSettings::updateOrCreate([
            'employee_id' => $employee_id,
        ],[
            'access_token' => $access_token,
            'refresh_token' => $refresh_token
        ]);
        Log::error($event_create);
        
        if($event_create) {
            $d = now();
            $date = $d->format('Y-m-d');
            $time = $d->format('H:i:s');
            $appointment = Appointment::where('employee_id',$employee_id)->where('date','>=',$date)->get();
            Log::error($appointment);
            $accessToken = $event_create->access_token;
            $refreshToken = $event_create->refresh_token;
            foreach($appointment as $appointment) {
                $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken ,$refreshToken, $appointment->employee_id);
                Log::error($timezone);
                if($timezone['status']) {
                    $data = array(
                        "summary" => $appointment->service_id.' ('.$appointment->category_id.')',
                        "location" => "Surat",
                        "description" => $appointment->comments,
                        "customer" => array('email' => $appointment->user->email),
                    );
                   
                    $time = array(
                        "event_date" => $appointment->date,
                        "start_time" => $appointment->start_time,
                        "end_time" => $appointment->finish_time,
                    );
                    
                    $employee_id = $event_create->employee_id;
                    $employee = User::where('id',$employee_id)->where('role_id',3)->first();
                    $user = User::where('email',$employee->email)->where('role_id',3)->first();
                    $google_appointment_id = \App\Helper\GoogleCal::CreateCalendarEvent($accessToken, $user->email, $data, 0, $time, $timezone['value'],$employee_id,$refreshToken);
                   
                    if($google_appointment_id['status']) {
                        Appointment::where('id',$appointment->id)->update([
                            'google_appointment_id' => $google_appointment_id['id']
                        ]);
                        Log::info($google_appointment_id);
                    }
                }
            }
        }

        if(!Auth::user()){
            $employee = User::where('id',$employee_id)->where('role_id',3)->first();
            $user = User::where('email',$employee->email)->where('role_id',3)->first();
            Auth::login($user);
        }
        if(Auth::user()->role_id == 3){
            session()->flash('message', trans('Account linked with Google Calendar Succesfully'));
            return redirect()->route('users.edit', Auth::user()->id);
        }else{
            session()->flash('message', trans('Account linked with Google Calendar Succesfully'));
            return redirect()->route('employees.index');
        }
    }

    public function SendEmailGoogleCalenderLink(Request $request,$id = false){
        $setting = Setting::first();
        $site = SiteConfig::first();
        if($setting->smtp_mail == 0){
            session()->flash('message', trans('Please Enable SMTP Mail'));
            return redirect()->back();
        } else if(!empty($setting->google_client_id) && !empty($setting->google_client_secret)) {
            $employee = User::where('id',$id)->where('role_id','3')->first();
            if(Auth::user()->role_id == 3){
                $googlecalendar = Helper::googlecalendar($employee->email,$id);
                return redirect($googlecalendar);
            }else{
                $googlecalendar = Helper::googlecalendar($employee->email,$id);
                $data = array(
                    'name' => $employee->first_name,
                    'to' => $employee->email,
                    'subject' => trans('Google Calendar Verification!'),
                    'title' => trans('Google Calendar Verification'),
                    'template' => 'mail.google_verify_email',
                    'employee'=>$employee,
                    'googlecalendar' => $googlecalendar,
                    'site_name' => $site->site_title,
                    'company_name' => $site->company_name,
                    "body"=>"mail"
                );
    
                Helper::emailinformation($data);
                session()->flash('message', trans('google_verification_link_sent', ['email' => $employee->email]));
                return redirect()->back();
            } 
        } else {
            session()->flash('message', trans('Please Provided Google Calandar Client Id and Secret'));
            return redirect()->back();
        }
    }

    public function removegoogle(Request $request,$id){
        // Start Google calender event code
        // $d = now();
        // $date = $d->format('Y-m-d');
        // $appointment = Appointment::where('employee_id',$id)->where('date','>=',$date)->get();
       
        // foreach($appointment as $appointment) {
        //     $employee = User::where('id',$id)->where('role_id','3')->first();
        //     $access_token = \App\Entities\employeeSettings::where('employee_id', $appointment->employee_id)->first();
        //     if(!empty($access_token)) {
        //         $accessToken = $access_token->access_token;
        //         $refreshToken = $access_token->refresh_token;
        //         $timezone = \App\Helper\GoogleCal::GetUserCalendarTimezone($accessToken,$refreshToken,$appointment->employee_id);
                
        //         if($timezone['status']) {
        //             $data = array(
        //                 "date" => $appointment->date,
        //                 "start" => $appointment->start_time,
        //                 "end" => $appointment->finish_time,
        //                 "status" => $appointment->status
        //             );
                    
        //             \App\Helper\GoogleCal::updateCalendarsEvents($employee->email, $accessToken,$refreshToken, $appointment->google_appointment_id, $data, $timezone['value'],$appointment->employee_id);
        //         }
        //     }
            
        // }
        // End Google calender event code
        employeeSettings::where('employee_id',$id)->delete();
        session()->flash('message', trans('Google Calendar unlinked succesfully'));
        return redirect()->back();
    }
}
