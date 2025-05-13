<?php

namespace App\Http\Controllers\Front;

use stdClass;
use Carbon\Carbon;
use App\Entities\User;
use App\Helper\Helper;
use App\Entities\Service;
use App\Entities\Setting;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use App\Entities\WorkingHour;
use App\Entities\EmployeeService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function __construct() {
        
    }

    public function categories(Request $request) {
        $services = Service::where(function($query) use($request) {
            foreach ($request->category_id as $key => $value) {
                $query->orwhere('category_id',$value);
            }
        })->get();
        return response()->json(['data' => $services]);
    }

    public function services(Request $request) {
        $setting = Setting::first();
        $services = array();
        if(empty($request->category)) {
            if($setting->categories != 1) {
                 $services = Service::all();
            }
        } else {
            $services = Service::where('category_id', $request->category)->get();
        }
        echo json_encode($services);
    }

    public function employees(Request $request) {
        $empService = EmployeeService::where('service_id', $request->service)->get();
        $employee = array();
        if($empService->isEmpty()) {
            $Service = Service::where('id', $request->service)->first();
            $obj = new stdClass();
            $obj->id = $Service->user_id;
            $obj->name = $Service->user->first_name.' '.$Service->user->last_name;
            $employee[] = $obj;
        } else {
            foreach ($empService as $key => $value) {
                $obj = new stdClass();
                $obj->id = $value->employee_id;
                $obj->name = ucfirst($value->employee->first_name).' '.ucfirst($value->employee->last_name);
                if($value->employee->status != 0) {
                    $employee[] = $obj;
                }
            }
        }
        echo json_encode($employee);
    }

    public function getTimeSlot(Request $request)
    {
        $flag = false;
        $service = Service::where('id', $request->service_id)->first();
        if(empty($request->employee_id)) {
            $working = WorkingHour::where('employee_id', $service->user_id)->first();
        }else{
            $working = WorkingHour::where('employee_id', $request->employee_id)->first();
        }
        
        // Employee Google calendar time slot Code Start
        $book_time = array();
        $employeeMail = User::where('id',$request->employee_id)->first();
        $calendarId = $employeeMail->email;
        $date = $request->selectedDate;
        $access_token = \App\Entities\employeeSettings::where('employee_id', $request->employee_id)->first();
        if(!empty($access_token)) {
            $accessToken = $access_token->access_token;
            $refreshToken = $access_token->refresh_token;
            $eventdate = date('Y-m-d', strtotime($request->selectedDate));
            $google_slot = \App\Helper\GoogleCal::GetCalendarsList($calendarId,$accessToken,$refreshToken,$request->employee_id,$eventdate);
            // $google_slot = \App\Helper\GoogleCal::getCalendarEvents($calendarId, $accessToken, $refreshToken,$request->employee_id);
            if(isset($google_slot['data']) && isset($google_slot['data']['items'])) {
                foreach ($google_slot['data']['items'] as $key => $value) {  

                    $gstartDate = isset($value['start']['dateTime']) ? date('Y-m-d', strtotime($value['start']['dateTime'])) : '';
                    $gstartTime = isset($value['start']['dateTime']) ? date('H:i:s', strtotime($value['start']['dateTime'])) : '';
                    // $gstartTime = isset($value['start']['dateTime']) ? date('HH:mm', strtotime($value['start']['dateTime'])) : '';
                    $gendDate = isset($value['end']['dateTime']) ? date('Y-m-d', strtotime($value['end']['dateTime'])) : '';
                    $gendTime = isset($value['end']['dateTime']) ? date('H:i:s', strtotime($value['end']['dateTime'])) : '';
                    // $gendTime = isset($value['end']['dateTime']) ? date('HH:mm', strtotime($value['end']['dateTime'])) : '';

                    if($date == $gstartDate) {
                        $book_time[] = array('date' => $date , 'start_time' => $gstartTime, 'finish_time' => $gendTime);
                    }    
                }
            }
        }
        else{
            $book_time = Appointment::where('date', date('Y-m-d', strtotime($request->selectedDate)))->where('status','!=','cancel')->where('employee_id',$request->employee_id)->get();
        }

        $setting = Setting::first();
        $date = date('Y-m-d', strtotime($request->selectedDate));
        $start_time = $working->start_time;
        $end_time = $working->finish_time;
        $startTime = date('Y-m-d h:i A', strtotime($date.' '.$start_time));
        $endTime = date('Y-m-d h:i A', strtotime($date.' '.$end_time));
        
        $enddate = $date;
        if (strtotime($startTime) > strtotime($endTime)) {
            $enddate = Carbon::parse($date)->addDay(1);
            $enddate = $enddate->format('Y-m-d');
            $endTime = date('Y-m-d h:i A', strtotime($enddate.' '.$end_time));
        }

        $today = Carbon::today();
        $today = Carbon::today()->now();
        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

    
        if($today->format('Y-m-d') == $date) {
          
            if($today->minute < 30) {
                $today->addMinute((30 - $today->minute));
            } else {
                $today->addMinute((60 - $today->minute));
            }
            if(strtotime($today->format('Y-m-d h:i A')) >= strtotime($startTime)) {
                $start_time = new Carbon($today->format('Y-m-d h:i A'));
            } else {
                $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime)));
            }
        } else {  
            $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime))); 
        }

        if($working->finish_time == '00:00:00'){
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($enddate.' '.$working->finish_time)));
        }else{
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($endTime))); 
            if($today->format('Y-m-d') == $date) {
                if(strtotime($today->format('Y-m-d 23:59:59')) <= strtotime($endTime)) {
                    $end_time = new Carbon(date('Y-m-d 00:00:00', strtotime($endTime)));
                }
            }
        }
      
        $break_start_time = !empty($working->break_start_time) ? new Carbon(date('h:i A', strtotime($enddate.''.$working->break_start_time))) : null;
        $break_end_time = !empty($working->break_end_time) ? new Carbon(date('h:i A', strtotime($enddate.''.$working->break_end_time))) : null;
     
        $r_time = Carbon::parse($working->rest_time);
        $rest_time = ($r_time->hour * 60) + $r_time->minute;
      
        $i_time = Carbon::parse($service->duration);
        $interval_time = ($i_time->hour * 60) + $i_time->minute;

        $slots = array();
        $i = 0;
        $breakadded = false;
        if(!empty($service) && $service->duration == '23:59:59') {
            $obj = new stdClass();
            if($today->format('Y-m-d') == $date && date('h:i A', strtotime('now')) <= $start_time->format('h:i A')) {
            } else {
                $obj->start_time = $start_time->format('h:i A');
                $obj->end_time = 'next 24 hours';
                array_push($slots, $obj);
            }
            $workingDays = !empty($working->days) ? json_decode($working->days) : [];
            $data = array('book_time'=>$book_time,'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays,'rest_time'=>$rest_time,'setting'=>$setting);
            echo json_encode($data);
            die();
        }
        while(strtotime($start_time->format('Y-m-d h:i A')) <= strtotime($end_time->format(' Y-m-d h:i A'))) {
            //echo 'loop start time = '.$start_time->format('Y-m-d h:i A').'<br>';
            $slot1 = $start_time;
            $s_time = $slot1->format('h:i A');
            $starting = $slot1->format('H:i:s');
            $obj = new stdClass();
            $obj->start_time = $s_time;
            $start_time->addMinute($interval_time); 
            $e_time = $start_time->format('h:i A');
            $ending = $start_time->format('H:i:s');
            $obj->end_time = $e_time;
            // echo '$obj->start_time'.$obj->start_time.'<br>';
            // echo '$obj->end_time'.$obj->end_time.'<br>';
            
            if($setting->custom_time_slot == 2) {
                 
                if($book_time){
                    foreach($book_time as $b_time) {
                        if($starting >= $b_time['start_time'] && $starting <= $b_time['finish_time']) {
                            $start_time->addMinute($rest_time);
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        
                    }
                }
                // if($flag) {
                //     $start_time->addMinute($rest_time);
                // }

            } else if($setting->custom_time_slot == 1){
                $start_time->addMinute($rest_time);
            }
            if(!empty($break_start_time) && !empty($break_end_time)) {
                if (strtotime($break_end_time->format('h:i A')) < strtotime($obj->start_time) && $breakadded === false) {
                    //echo 'In break condition <br>';
                    $start_time = $date.' '.$break_end_time->format('h:i A');
                    $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                    $breakadded = true;
                } 
                else {
                    $addslot = false;
                    if(strtotime($break_start_time) > strtotime($obj->start_time)) {
                        $addslot = true;
                    }
                    if(strtotime($break_end_time) <= strtotime($obj->start_time) && strtotime($break_end_time) >= $obj->end_time) {
                        $addslot = true;
                    } 
                    $slotstart = new Carbon(date('Y-m-d h:i A', strtotime($obj->start_time))); 
                    $slotstart = $slotstart->addMinute($interval_time);
                    if( strtotime($slotstart) > strtotime($break_start_time) && strtotime($obj->start_time) <= strtotime($break_start_time) && ($obj->end_time <= strtotime($break_end_time))) {
                        $addslot = false;
                        $start_time = $date.' '.$break_end_time->format('h:i A');
                        $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                        $breakadded = true;
                    }
                    if($addslot === true) { 
                        if ($flag == true) {
                            $start_time = new Carbon(date('Y-m-d h:i A', strtotime($date.' '.$obj->end_time)));
                            $start_time->addMinute($rest_time);
                        }
                        array_push($slots, $obj);
                    }
                } 
            } else {
                array_push($slots, $obj);
                // $start_time->addMinute($rest_time);
            }
        } 
        $workingDays = !empty($working->days) ? json_decode($working->days) : [];
        unset($slots[count($slots) - 1]);
        $data = array('book_time'=>$book_time,'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays,'rest_time'=>$rest_time,'setting'=>$setting);
        echo json_encode($data);
    }

    public function getTimeSlot2(Request $request)
    {
        $flag = false;
        $service = Service::where('id', $request->service_id)->first();
        if(empty($request->employee_id)) {
            $working = WorkingHour::where('employee_id', $service->user_id)->first();
        }else{
            $working = WorkingHour::where('employee_id', $request->employee_id)->first();
        }
        
        // Employee Google calendar time slot Code Start
        $book_time = array();
        $employeeMail = User::where('id',$request->employee_id)->first();
        $calendarId = $employeeMail->email;
        $date = $request->selectedDate;
        $access_token = \App\Entities\employeeSettings::where('employee_id', $request->employee_id)->first();
        if(!empty($access_token)) {
            $accessToken = $access_token->access_token;
            $refreshToken = $access_token->refresh_token;
            $eventdate = date('Y-m-d', strtotime($request->selectedDate));
            $google_slot = \App\Helper\GoogleCal::GetCalendarsList($calendarId,$accessToken,$refreshToken,$request->employee_id,$eventdate);
            // $google_slot = \App\Helper\GoogleCal::getCalendarEvents($calendarId, $accessToken, $refreshToken,$request->employee_id);
            if(isset($google_slot['data']) && isset($google_slot['data']['items'])) {
                foreach ($google_slot['data']['items'] as $key => $value) {  

                    $gstartDate = isset($value['start']['dateTime']) ? date('Y-m-d', strtotime($value['start']['dateTime'])) : '';
                    $gstartTime = isset($value['start']['dateTime']) ? date('H:i:s', strtotime($value['start']['dateTime'])) : '';
                    // $gstartTime = isset($value['start']['dateTime']) ? date('HH:mm', strtotime($value['start']['dateTime'])) : '';
                    $gendDate = isset($value['end']['dateTime']) ? date('Y-m-d', strtotime($value['end']['dateTime'])) : '';
                    $gendTime = isset($value['end']['dateTime']) ? date('H:i:s', strtotime($value['end']['dateTime'])) : '';
                    // $gendTime = isset($value['end']['dateTime']) ? date('HH:mm', strtotime($value['end']['dateTime'])) : '';

                    if($date == $gstartDate) {
                        $book_time[] = array('date' => $date , 'start_time' => $gstartTime, 'finish_time' => $gendTime);
                    }    
                }
            }
        }
        else{
            $book_time = Appointment::where('date', date('Y-m-d', strtotime($request->selectedDate)))->where('status','!=','cancel')->where('employee_id',$request->employee_id)->get();
        }

        $setting = Setting::first();
        $date = date('Y-m-d', strtotime($request->selectedDate));
        $start_time = $working->start_time;
        $end_time = $working->finish_time;
        $startTime = date('Y-m-d h:i A', strtotime($date.' '.$start_time));
        $endTime = date('Y-m-d h:i A', strtotime($date.' '.$end_time));
        
        $enddate = $date;
        if (strtotime($startTime) > strtotime($endTime)) {
            $enddate = Carbon::parse($date)->addDay(1);
            $enddate = $enddate->format('Y-m-d');
            $endTime = date('Y-m-d h:i A', strtotime($enddate.' '.$end_time));
        }

        $today = Carbon::today();
        $today = Carbon::today()->now();
        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

    
        if($today->format('Y-m-d') == $date) {
          
            if($today->minute < 30) {
                $today->addMinute((30 - $today->minute));
            } else {
                $today->addMinute((60 - $today->minute));
            }
            if(strtotime($today->format('Y-m-d h:i A')) >= strtotime($startTime)) {
                $start_time = new Carbon($today->format('Y-m-d h:i A'));
            } else {
                $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime)));
            }
        } else {  
            $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime))); 
        }

        if($working->finish_time == '00:00:00'){
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($enddate.' '.$working->finish_time)));
        }else{
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($endTime))); 
            if($today->format('Y-m-d') == $date) {
                if(strtotime($today->format('Y-m-d 23:59:59')) <= strtotime($endTime)) {
                    $end_time = new Carbon(date('Y-m-d 00:00:00', strtotime($endTime)));
                }
            }
        }
      
        $break_start_time = !empty($working->break_start_time) ? new Carbon(date('h:i A', strtotime($enddate.''.$working->break_start_time))) : null;
        $break_end_time = !empty($working->break_end_time) ? new Carbon(date('h:i A', strtotime($enddate.''.$working->break_end_time))) : null;
     
        $r_time = Carbon::parse($working->rest_time);
        $rest_time = ($r_time->hour * 60) + $r_time->minute;
      
        $i_time = Carbon::parse($service->duration);
        $interval_time = ($i_time->hour * 60) + $i_time->minute;

        $slots = array();
        $i = 0;
        $breakadded = false;
        if(!empty($service) && $service->duration == '23:59:59') {
            $obj = new stdClass();
            if($today->format('Y-m-d') == $date && date('h:i A', strtotime('now')) <= $start_time->format('h:i A')) {
            } else {
                $obj->start_time = $start_time->format('h:i A');
                $obj->end_time = 'next 24 hours';
                array_push($slots, $obj);
            }
            $workingDays = !empty($working->days) ? json_decode($working->days) : [];
            $data = array('book_time'=>$book_time,'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays,'rest_time'=>$rest_time,'setting'=>$setting);
            echo json_encode($data);
            die();
        }
        while(strtotime($start_time->format('Y-m-d h:i A')) <= strtotime($end_time->format(' Y-m-d h:i A'))) {
            //echo 'loop start time = '.$start_time->format('Y-m-d h:i A').'<br>';
            $slot1 = $start_time;
            $s_time = $slot1->format('h:i A');
            $starting = $slot1->format('H:i:s');
            $obj = new stdClass();
            $obj->start_time = $s_time;
            $start_time->addMinute($interval_time); 
            $e_time = $start_time->format('h:i A');
            $ending = $start_time->format('H:i:s');
            $obj->end_time = $e_time;
            // echo '$obj->start_time'.$obj->start_time.'<br>';
            // echo '$obj->end_time'.$obj->end_time.'<br>';
            
            if($setting->custom_time_slot == 2) {
                 
                if($book_time){
                    foreach($book_time as $b_time) {
                        if($starting >= $b_time['start_time'] && $starting <= $b_time['finish_time']) {
                            $start_time->addMinute($rest_time);
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        
                    }
                }
                // if($flag) {
                //     $start_time->addMinute($rest_time);
                // }

            } else if($setting->custom_time_slot == 1){
                $start_time->addMinute($rest_time);
            }
            if(!empty($break_start_time) && !empty($break_end_time)) {
                if (strtotime($break_end_time->format('h:i A')) < strtotime($obj->start_time) && $breakadded === false) {
                    //echo 'In break condition <br>';
                    $start_time = $date.' '.$break_end_time->format('h:i A');
                    $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                    $breakadded = true;
                } 
                else {
                    $addslot = false;
                    if(strtotime($break_start_time) > strtotime($obj->start_time)) {
                        $addslot = true;
                    }
                    if(strtotime($break_end_time) <= strtotime($obj->start_time) && strtotime($break_end_time) >= $obj->end_time) {
                        $addslot = true;
                    } 
                    $slotstart = new Carbon(date('Y-m-d h:i A', strtotime($obj->start_time))); 
                    $slotstart = $slotstart->addMinute($interval_time);
                    if( strtotime($slotstart) > strtotime($break_start_time) && strtotime($obj->start_time) <= strtotime($break_start_time) && ($obj->end_time <= strtotime($break_end_time))) {
                        $addslot = false;
                        $start_time = $date.' '.$break_end_time->format('h:i A');
                        $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                        $breakadded = true;
                    }
                    if($addslot === true) { 
                        if ($flag == true) {
                            $start_time = new Carbon(date('Y-m-d h:i A', strtotime($date.' '.$obj->end_time)));
                            $start_time->addMinute($rest_time);
                        }
                        array_push($slots, $obj);
                    }
                } 
            } else {
                array_push($slots, $obj);
                // $start_time->addMinute($rest_time);
            }
        } 


        //Slot Filter
        $employeeService = \DB::table('employee_services')->where('employee_id', $request->employee_id)->where('service_id', $request->service_id)->first();
        $targetTimes = $employeeService ? json_decode($employeeService->available_timeslots, true) : [];

        // ✅ Convert to associative keys for fast lookup
        $targetTimeMap = array_flip($targetTimes);

        // ✅ Filter slots
        $matchedSlots = array_filter($slots, function ($slot) use ($targetTimeMap) {
            $slotKey = $slot->start_time . '-' . $slot->end_time;
            return isset($targetTimeMap[$slotKey]);
        });

        // ✅ Reset keys if needed
        $matchedSlots = array_values($matchedSlots);  
        //Slot Filter 

        $workingDays = !empty($working->days) ? json_decode($working->days) : [];
        unset($slots[count($slots) - 1]);
        $data = array('book_time'=>$book_time,'matchedSlots' => $matchedSlots, 'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays,'rest_time'=>$rest_time,'setting'=>$setting);
        echo json_encode($data);
    }    

    public function backup_getTimeSlot(Request $request)
    {
        $flag = false;
        $service = Service::where('id', $request->service_id)->first();
        if(empty($request->employee_id)) {
            $working = WorkingHour::where('employee_id', $service->user_id)->first();
        }else{
            $working = WorkingHour::where('employee_id', $request->employee_id)->first();
        }
        
        // Employee Google calendar time slot Code Start
        $book_time = array();
        $employeeMail = User::where('id',$request->employee_id)->first();
        $calendarId = $employeeMail->email;
        $date = $request->selectedDate;
        $access_token = \App\Entities\employeeSettings::where('employee_id', $request->employee_id)->first();
        if(!empty($access_token)) {
            $accessToken = $access_token->access_token;
            $refreshToken = $access_token->refresh_token;
            $eventdate = date('Y-m-d', strtotime($request->selectedDate));
            $google_slot = \App\Helper\GoogleCal::GetCalendarsList($calendarId,$accessToken,$refreshToken,$request->employee_id,$eventdate);
            // $google_slot = \App\Helper\GoogleCal::getCalendarEvents($calendarId, $accessToken, $refreshToken,$request->employee_id);
          
            foreach ($google_slot['data']['items'] as $key => $value) {  

                $gstartDate = isset($value['start']['dateTime']) ? date('Y-m-d', strtotime($value['start']['dateTime'])) : '';
                $gstartTime = isset($value['start']['dateTime']) ? date('H:i:s', strtotime($value['start']['dateTime'])) : '';
                // $gstartTime = isset($value['start']['dateTime']) ? date('HH:mm', strtotime($value['start']['dateTime'])) : '';
                $gendDate = isset($value['end']['dateTime']) ? date('Y-m-d', strtotime($value['end']['dateTime'])) : '';
                $gendTime = isset($value['end']['dateTime']) ? date('H:i:s', strtotime($value['end']['dateTime'])) : '';
                // $gendTime = isset($value['end']['dateTime']) ? date('HH:mm', strtotime($value['end']['dateTime'])) : '';

                if($date == $gstartDate) {
                    $book_time[] = array('date' => $date , 'start_time' => $gstartTime, 'finish_time' => $gendTime);
                }    
            }
        }
        else{
            $book_time = Appointment::where('date', date('Y-m-d', strtotime($request->selectedDate)))->where('status','!=','cancel')->where('employee_id',$request->employee_id)->get();
        }  
        $setting = Setting::first();
        $date = date('Y-m-d', strtotime($request->selectedDate));
        $start_time = $working->start_time;
        $end_time = $working->finish_time;
        $startTime = date('Y-m-d h:i A', strtotime($date.' '.$start_time));
        $endTime = date('Y-m-d h:i A', strtotime($date.' '.$end_time));
        
        $enddate = $date;
        if (strtotime($startTime) > strtotime($endTime)) {
            $enddate = Carbon::parse($date)->addDay(1);
            $enddate = $enddate->format('Y-m-d');
            $endTime = date('Y-m-d h:i A', strtotime($enddate.' '.$end_time));
        }

        $today = Carbon::today();
        $today = Carbon::today()->now();
        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');

    
        if($today->format('Y-m-d') == $date) {
          
            if($today->minute < 30) {
                $today->addMinute((30 - $today->minute));
            } else {
                $today->addMinute((60 - $today->minute));
            }
            if(strtotime($today->format('Y-m-d h:i A')) >= strtotime($startTime)) {
                $start_time = new Carbon($today->format('Y-m-d h:i A'));
            } else {
                $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime)));
            }
        } else {  
            $start_time = new Carbon(date('Y-m-d h:i A', strtotime($startTime))); 
        }

        if($working->finish_time == '00:00:00'){
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($enddate.' '.$working->finish_time)));
        }else{
            $end_time = new Carbon(date('Y-m-d h:i A', strtotime($endTime))); 
            if($today->format('Y-m-d') == $date) {
                if(strtotime($today->format('Y-m-d 23:59:59')) <= strtotime($endTime)) {
                    $end_time = new Carbon(date('Y-m-d 00:00:00', strtotime($endTime)));
                }
            }
        }
      
        $break_start_time = new Carbon(date('h:i A', strtotime($enddate.''.$working->break_start_time)));
        $break_end_time = new Carbon(date('h:i A', strtotime($enddate.''.$working->break_end_time)));
     
        $r_time = Carbon::parse($working->rest_time);
        $rest_time = ($r_time->hour * 60) + $r_time->minute;
      
        $i_time = Carbon::parse($service->duration);
        $interval_time = ($i_time->hour * 60) + $i_time->minute;

        $slots = array();
        $i = 0;
        $breakadded = false;
        
        while(strtotime($start_time->format('Y-m-d h:i A')) <= strtotime($end_time->format(' Y-m-d h:i A'))) {
            //echo 'loop start time = '.$start_time->format('Y-m-d h:i A').'<br>';
            $slot1 = $start_time;
            $s_time = $slot1->format('h:i A');
            $starting = $slot1->format('H:i:s');
            $obj = new stdClass();
            $obj->start_time = $s_time;
            $start_time->addMinute($interval_time); 
            $e_time = $start_time->format('h:i A');
            $ending = $start_time->format('H:i:s');
            $obj->end_time = $e_time;
            // echo '$obj->start_time'.$obj->start_time.'<br>';
            // echo '$obj->end_time'.$obj->end_time.'<br>';
            
            if($setting->custom_time_slot == 2) {
                 
                if($book_time){
                    foreach($book_time as $b_time) {
                        if($starting >= $b_time['start_time'] && $starting <= $b_time['finish_time']) {
                            $start_time->addMinute($rest_time);
                            $flag = true;
                        } else {
                            $flag = false;
                        }
                        
                    }
                }
                // if($flag) {
                //     $start_time->addMinute($rest_time);
                // }

            } else if($setting->custom_time_slot == 1){
                $start_time->addMinute($rest_time);
            }

            if (strtotime($break_end_time->format('h:i A')) < strtotime($obj->start_time) && $breakadded === false) {
                //echo 'In break condition <br>';
                $start_time = $date.' '.$break_end_time->format('h:i A');
                $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                $breakadded = true;
            } 
            else {
                $addslot = false;
                if(strtotime($break_start_time) > strtotime($obj->start_time)) {
                    $addslot = true;
                }
                if(strtotime($break_end_time) <= strtotime($obj->start_time) && strtotime($break_end_time) >= $obj->end_time) {
                    $addslot = true;
                } 
                $slotstart = new Carbon(date('Y-m-d h:i A', strtotime($obj->start_time))); 
                $slotstart = $slotstart->addMinute($interval_time);
                if( strtotime($slotstart) > strtotime($break_start_time) && strtotime($obj->start_time) <= strtotime($break_start_time) && ($obj->end_time <= strtotime($break_end_time))) {
                    $addslot = false;
                    $start_time = $date.' '.$break_end_time->format('h:i A');
                    $start_time = new Carbon(date('Y-m-d h:i A', strtotime($start_time)));
                    $breakadded = true;
                }
                if($addslot === true) { 
                    if ($flag == true) {
                        $start_time = new Carbon(date('Y-m-d h:i A', strtotime($date.' '.$obj->end_time)));
                        $start_time->addMinute($rest_time);
                    }
                    array_push($slots, $obj);
                }
            } 
        } 
        $workingDays = !empty($working->days) ? json_decode($working->days) : [];
        unset($slots[count($slots) - 1]);
        $data = array('book_time'=>$book_time,'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays,'rest_time'=>$rest_time,'setting'=>$setting);
        echo json_encode($data);
    }

    public function old_getTimeSlot(Request $request) 
    {
        $flag = false;
        $service = Service::where('id', $request->service_id)->first();
        if(empty($request->employee_id)) {
            $working = WorkingHour::where('employee_id', $service->user_id)->first();
        }else{
            $working = WorkingHour::where('employee_id', $request->employee_id)->first();
           
        }
        $setting = Setting::first();
       
        $book_time = Appointment::where('date',$request->selectedDate)->where('status','!=','cancel')->where('employee_id',$request->employee_id)->get();
        
        $date = $request->selectedDate;
        $enddate = $date;
        
        $start_time = $working->start_time;
        $end_time = $working->finish_time;
        
        if (strtotime($start_time) > strtotime($end_time)) {
            $enddate = Carbon::parse($date)->addDay(1);
            $enddate = $enddate->format('Y-m-d');
        }
       
        $today = Carbon::today();
        $today = Carbon::today()->now();
        $days = array('Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday');
        if($today->format('Y-m-d') == $date) {
          
            if($today->minute < 30) {
                $today->addMinute((30 - $today->minute));
            } else {
                $today->addMinute((60 - $today->minute));
            }
            $start_time = new Carbon($today->format('Y-m-d h:i A'));
        } else {  
            $start_time = new Carbon(date('Y-m-d', strtotime($date)).' '.$working->start_time); 
        }
       
        $data1 = strtotime(date('Y-m-d h:i A',strtotime($date.''.$working->start_time)));
        $data2 = strtotime(date('Y-m-d h:i A',strtotime($enddate.''.$working->finish_time)));
       
        if(strtotime(date('Y-m-d h:i A',strtotime($date.''.$working->start_time)))  >   strtotime(date('Y-m-d h:i A',strtotime($date.''.$working->finish_time)))) {
            
            if($working->finish_time == '00:00:00'){
                $end_time = new Carbon(date('Y-m-d h:i A', strtotime($enddate.' '.$working->finish_time)));
            }else{
                $end_time = new Carbon(date('Y-m-d h:i', strtotime($enddate.' '.$working->finish_time))); 
            }
          
            $break_start_time = new Carbon(date('h:i A', strtotime($enddate.''.$working->break_start_time)));
            $break_end_time = new Carbon(date('h:i A', strtotime($enddate.''.$working->break_end_time)));
         
            $r_time = Carbon::parse($working->rest_time);
            $rest_time = ($r_time->hour * 60) + $r_time->minute;
          
            $i_time = Carbon::parse($service->duration);
            $interval_time = ($i_time->hour * 60) + $i_time->minute;
           
            $slots = array();
            $i = 0;
            while(strtotime($start_time->format('H:i A')) <= strtotime($end_time->format('H:i A'))) {

                $slot1 = $start_time;
                $s_time = $slot1->format('h:i A');
                $starting = $slot1->format('H:i:s');
                $obj = new stdClass();
                $obj->start_time = $s_time;
                $start_time->addMinute($interval_time); 
                $e_time = $start_time->format('h:i A');
                $ending = $start_time->format('H:i:s');
                $obj->end_time = $e_time;
              
                if($setting->custom_time_slot == 2) {
                    $appointment_time = Appointment::where('date',$request->selectedDate)
                    ->where('service_id',$request->service_id)
                    ->where('start_time','>=', $starting)
                    ->where('finish_time','<=', $ending)
                    ->first();
                    if(!empty($appointment_time)) {
                        $e_finish_time = date('H:i:s',strtotime($appointment_time->date.' '.$e_time));
                        $a_finish_time = date('H:i:s',strtotime($appointment_time->date.' '.$appointment_time->finish_time));
                        if($e_finish_time >= $a_finish_time) {
                            $flag = true;
                        }
                        $i++;
                    } else {
                        $flag = false;
                    }
                    if($flag) {
                        $start_time->addMinute($rest_time);
                    }
                } else if($setting->custom_time_slot == 1){
                    $start_time->addMinute($rest_time);
                }

                if(strtotime($break_start_time) > strtotime($obj->start_time)) {
                    array_push($slots, $obj);
                }

                if(strtotime($break_end_time) <= strtotime($obj->start_time) && strtotime($break_end_time) >= $obj->end_time) {
                    array_push($slots, $obj);
                }

            }
        
        }else {
            $end_time = new Carbon(date('Y-m-d ', strtotime($date)).' '.$working->finish_time); 

            $break_start_time = date('h:i A', strtotime($working->break_start_time));
            $break_end_time = date('h:i A', strtotime($working->break_end_time));

            $r_time = Carbon::parse($working->rest_time);
            $rest_time = ($r_time->hour * 60) + $r_time->minute;
            
            $i_time = Carbon::parse($service->duration);
            $interval_time = ($i_time->hour * 60) + $i_time->minute;
            
            $slots = array();
            $i = 0;
            while(strtotime($start_time->format('h:i A')) <= strtotime($end_time->format('h:i A'))) {
                $slot1 = $start_time;
                $s_time = $slot1->format('h:i A');
                $starting = $slot1->format('H:i:s');
                $obj = new stdClass();
                $obj->start_time = $s_time;
                $start_time->addMinute($interval_time); 
                $e_time = $start_time->format('h:i A');
                $ending = $start_time->format('H:i:s');
                $obj->end_time = $e_time;
                if($setting->custom_time_slot == 2) {
                    $appointment_time = Appointment::where('date',$request->selectedDate)
                    ->where('service_id',$request->service_id)
                    ->where('start_time','>=', $starting)
                    ->where('finish_time','<=', $ending)
                    ->first();
                    if(!empty($appointment_time)) {
                        $e_finish_time = date('H:i:s',strtotime($appointment_time->date.' '.$e_time));
                        $a_finish_time = date('H:i:s',strtotime($appointment_time->date.' '.$appointment_time->finish_time));
                        if($e_finish_time >= $a_finish_time) {
                            $flag = true;
                        }
                        $i++;
                    } else {
                        $flag = false;
                    }
                    if($flag) {
                        $start_time->addMinute($rest_time);
                    }
                } else if($setting->custom_time_slot == 1){
                    $start_time->addMinute($rest_time);
                }

                if(strtotime($break_start_time) > strtotime($obj->start_time)) {
                    array_push($slots, $obj);
                }

                if(strtotime($break_end_time) <= strtotime($obj->start_time) && strtotime($break_end_time) >= $obj->end_time) {
                    array_push($slots, $obj);
                }

            }
        }
        $workingDays = !empty($working->days) ? json_decode($working->days) : [];
        unset($slots[count($slots) - 1]);
        $data = array('book_time'=>$book_time,'slots'=>$slots,'days' => $days,'workingDay'=>$workingDays);
        echo json_encode($data);
    }

    public function anotherEmployee(Request $request)
    {
        $admin = User::where('role_id',1)->first();
        $working = WorkingHour::where('employee_id', $request->employee_id)->first();
        $workingDays = !empty($working->days) ? json_decode($working->days) : [];
        
        $data = array('workingDay'=>$workingDays,'admin'=>$admin);
        echo json_encode($data);
    }

    public function contact(Request $request)
    {
        $smtp = Setting::first();
        if($smtp->smtp_mail == 1) {
            $admin = User::where('role_id',1)->first();
            $admin_email = DB::table('site_configs')->first();
            
            $data = array(
                'name' => $request->contact_name,
                'to' => $admin_email->email,
                'email' => $request->contact_email,
                'phone' => $request->country_code.$request->contact_phone,
                'customer_message' => $request->customer_message,
                'subject' => trans('User Contact'),
                'title' => trans('Contact Us'),
                'template' => 'mail.admin_contact_email',
                'site_name' => $admin_email->site_title,
                'company_name' => $admin_email->company_name,
                'admin' =>$admin,
                'admin_email'=>$admin_email,
                'body' => 'mail'
            );
  
        $mail = Helper::emailinformation($data);
        }
        session()->flash('message', trans('Thank you for contacting the Customer Support Team. We will contact you as soon as there is an update or the issue has been resolved'));
        return redirect()->route('welcome');
    }

    public function checkEmailExist(Request $request)
    {
        $result = false;
        $message = '';
        if($request->has('email') && $request->email) {
            $user = User::where('email', $request->email)->first();
            if(!empty($user)) {
                $result = true;
                $message = trans('Email already exist in system. Please login and book a new appointment');
            } else
                $result = false;
        }
        return response()->json(['success' => true, 'exits' => $result, 'msg'=> $message]);
    }


    // public function getStates(Request $request)
    // {
    //     $states = DB::table('states')
    //         ->where('status', 1)
    //         ->where('country_id', $request->country_id)
    //         ->get();
    //     $html = '<option value="">' . __("Select State") . '</option>';

    //     foreach ($states as $state) {
    //         $html .= '<option value="' . $state->id . '">' . $state->name . '</option>';
    //     }

    //     echo json_encode($html);
    // }  
    
    public function getStates(Request $request)
    {
        $states = DB::table('states')
        ->where('status', 1)
        ->where('country_id', $request->country_id)
        ->get();

        $selectedStateId = Auth::check() ? Auth::user()->state : null;

        $html = '<option value="">' . __("Select State") . '</option>';

        foreach ($states as $state) {
            $selected = $selectedStateId == $state->id ? 'selected' : '';
            $html .= '<option value="' . $state->id . '" ' . $selected . '>' . e($state->name) . '</option>';
        }
    
        echo json_encode($html);
    }    
}