<?php

namespace App\Http\Controllers;

use App\Entities\Setting;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    protected $custom;
    
    public function __construct()
    {
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }
    
    public function index(Request $request, $id = false)
    {   
        if($id != false) {
            $exit = DB::table('notification')->where('id',$id)->where('user_id',Auth::user()->id)->first();
            if(!$exit)
                return redirect()->route('unauthorized');
            DB::table('notification')->where('id',$id)->where('is_read', 0)->update(['is_read' => 1,'updated_at' => date('Y-m-d H:i:s')]);
        }
        $latestNotifications = DB::table('notification')->where('user_id',Auth::user()->id)->where('is_read', 0)->orderBy('id','DESC')->get();
        $notifications = DB::table('notification')->where('user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        $notificationsview = DB::table('notification')->where('user_id',Auth::user()->id)
        ->where('is_read', 0)
        ->update([
            'is_read'=> 1,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
       
        return view('customer-notification',compact('notifications','latestNotifications','notificationsview'));
    }

    public function notification(Request $request, $id = false)
    {
        if(Auth::user()->role_id != 3) {
            $this->authorize('appointments',Auth::user());
        }  
        if($id != false) {
            DB::table('notification')->where('id',$id)->where('is_read', 0)->update(['is_read' => 1,'updated_at' => date('Y-m-d')]);
        }
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        
        $userkey = 'user_id';  
        $latestdata = DB::table('notification')->where($userkey,Auth::user()->id)->limit(3)->orderBy('id','desc')->get();
        $results = DB::table('notification')
                ->join('appointments','appointments.id','=','notification.appointment_id')
                ->join('users','users.id','=','appointments.user_id')
                ->select('users.first_name','users.last_name','appointments.start_time','appointments.finish_time','notification.message')
                ->where('notification.'.$userkey,Auth::user()->id)
                ->orderBy('notification.id','desc')
                ->get();
       
        $notificationcount = DB::table('notification')->where($userkey,Auth::user()->id)->count();
      
        $view = DB::table('notification')->where($userkey,Auth::user()->id)
            ->where('is_read', 0)
            ->update([
                'is_read'=> 1,
                'updated_at' => date('Y-m-d H:i:s')
            ]);
           
        return view('notification',compact('results','latestdata','rowIndex','view'));
    }

    public function markNotification()
    {
       DB::table('notification')
        ->where('user_id',Auth::user()->id)
        ->where('is_read', 0)
        ->update(['is_read' => 1,'updated_at' => date('Y-m-d H:i:s')]);
       return response()->json(['data' => trans('Notification status updated successfully')]);
    }

    public function verifySms(Request $request)
    {
        $this->validate($request, [
            'phone' => 'required'
            // |starts_with:+
        ], [
            'phone.required' => trans('Please enter phone number'),
            // 'phone.starts_with' => trans('Phone number must be start with +'),
        ]);

        try {
            $site = SiteConfig::first();
            if(empty($this->custom->twilio_service_id) || empty($this->custom->twilio_phone) || empty($this->custom->twilio_sandbox_key) || 
                empty($this->custom->twilio_sandbox_secret) || empty($this->custom->twilio_live_key) || empty($this->custom->twilio_live_secret)) {
                    return response()->json([
                        'status' => false,
                        'messages' => trans('SMS Configuration is not correct.')
                    ]);
            }
            $data = array(
                'to' => $request->country_code.$request->phone,
                'body' => trans('sms_message', ['name' => $site->site_title]),
            );

            $test = \App\Helper\Helper::notification($data);

            if($test == false){
                session()->flash('error-message', trans('SMS Configuration is not correct.'));
                return response()->json([
                    'status' => false,
                    'messages' => trans('SMS Configuration is not correct.')
                ]);
            }
          
            return response()->json([
                'status' => true,
                'messages' => trans('SMS Configuration Verified Successfully')
            ]);
        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'messages' => $th->getMessage()
            ]);
        }
    }
    
}
