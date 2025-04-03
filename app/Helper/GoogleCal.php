<?php
namespace App\Helper;

use Exception;
use App\Entities\Setting;
use App\Entities\employeeSettings;
use Illuminate\Support\Facades\Log;

    /** 
 * 
 * This Google Calendar API handler class is a custom PHP library to handle the Google Calendar API calls. 
 * 
 * @class        GoogleCalendarApi 
 * @author        CodexWorld 
 * @link        http://www.codexworld.com 
 * @version        1.0 
 */ 

 
class GoogleCal { 
    const OAUTH2_TOKEN_URI = 'https://accounts.google.com/o/oauth2/token';
    // const OAUTH2_TOKEN_URI = 'https://oauth2.googleapis.com/token'; 
    const CALENDAR_TIMEZONE_URI = 'https://www.googleapis.com/calendar/v3/users/me/settings/timezone'; 
    const CALENDAR_LIST = 'https://www.googleapis.com/calendar/v3/users/me/calendarList'; 
    const CALENDAR_EVENT = 'https://www.googleapis.com/calendar/v3/calendars/'; 
    const CALENDAR_COLOR = 'https://www.googleapis.com/calendar/v3/colors';

    function __construct($params = array()) { 
        if (count($params) > 0){ 
            $this->initialize($params);         
        } 
    } 
     
    function initialize($params = array()) { 
        if (count($params) > 0){ 
            foreach ($params as $key => $val){ 
                if (isset($this->$key)){ 
                    $this->$key = $val; 
                } 
            }         
        } 
    } 
     
    public static function GetAccessToken($code ,$client_id, $client_secret, $redirect_uri) { 
        $curlPost = 'client_id=' . $client_id . '&redirect_uri=' . $redirect_uri . '&client_secret=' . $client_secret . '&code='. $code . '&grant_type=authorization_code';
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, self::OAUTH2_TOKEN_URI);         
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
        curl_setopt($ch, CURLOPT_POST, 1);         
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);     
        $data = json_decode(curl_exec($ch), true); 
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
        if ($http_code != 200) { 
            $error_msg = 'Failed to receieve access token'; 
            if (curl_errno($ch)) { 
                $error_msg = curl_error($ch); 
            } 
            throw new Exception('Error '.$http_code.': '.$error_msg); 
        }  
        return $data; 
    } 

    public static function RefreshToken($client_id, $client_secret, $refresh_token, $employeeId){
        $curlData = 'client_id=' . $client_id . '&client_secret=' . $client_secret . '&refresh_token=' . $refresh_token . '&grant_type=refresh_token';
        $ch = curl_init();        
        curl_setopt($ch, CURLOPT_URL, self::OAUTH2_TOKEN_URI);         
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
        curl_setopt($ch, CURLOPT_POST, 1);         
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
        curl_setopt($ch, CURLOPT_POSTFIELDS, $curlData);     
        $data = json_decode(curl_exec($ch), true); 
        Log::channel('daily')->info('RefreshToken: '.json_encode($data, true));
        $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
        if ($http_code != 200) { 
            $error_msg = 'Failed to receieve and revoke access token'; 
            if (curl_errno($ch)) { 
                $error_msg = curl_error($ch); 
            } 
            throw new Exception('Error '.$http_code.': '.$error_msg); 
        } 
        $access_token = $data['access_token'];
        $event_create = employeeSettings::updateOrCreate([
            'employee_id' => $employeeId,
        ],[
            'access_token' => $access_token,
        ]);
             
        return $data; 
    }
        
 
    public static function GetUserCalendarTimezone($access_token, $refreshToken, $employeeId) {
        try {
            $ch = curl_init(); 
            curl_setopt($ch, CURLOPT_URL, self::CALENDAR_TIMEZONE_URI);      
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));     
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);  
            $data = curl_exec($ch);
            // $response = curl_exec($ch);
            $data = json_decode(curl_exec($ch), true);
            
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
           
            if ($http_code != 200) { 
                $error_msg = 'Failed to fetch timezone'; 
                // if (curl_errno($ch)) { 
                //     $error_msg = curl_error($ch); 
                    $custom = Setting::first();
                    $client_id = $custom->google_client_id;
                    $client_secret = $custom->google_client_secret;
                    $data = self::RefreshToken($client_id, $client_secret, $refreshToken,$employeeId);
                    $access_token = $data['access_token'];
                    self::GetUserCalendarTimezone($access_token,$refreshToken,$employeeId);
                // }
                // return array(
                //     'status' => false,
                //     'message' => $error_msg
                // ); 
            //     throw new Exception('Error '.$http_code.': '.$error_msg); 
            }
            Log::channel('daily')->info(json_encode($data, true)); 
            return array(
                'status' => true,
                'value' => $data['value']
            );
        } catch (Exception $ex) {
            Log::channel('daily')->info($ex->getMessage());
            return array(
                'status' => false,
                'message' => $ex->getMessage()
            );
        } 
    } 
 
    // public static function GetCalendarsList($access_token) { 
    //     $url_parameters = array(); 
 
    //     $url_parameters['fields'] = 'items(id,summary,timeZone)'; 
    //     $url_parameters['minAccessRole'] = 'owner'; 
 
    //     $url_calendars = self::CALENDAR_LIST.'?'. http_build_query($url_parameters); 

    //     $ch = curl_init();         
    //     curl_setopt($ch, CURLOPT_URL, $url_calendars);         
    //     curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);     
    //     curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token));     
    //     curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);     
    //     $data = json_decode(curl_exec($ch), true);
         
    //     $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
         
    //     if ($http_code != 200) { 
    //         $error_msg = 'Failed to get calendars list'; 
    //         if (curl_errno($ch)) { 
    //             $error_msg = curl_error($ch); 
    //         } 
    //         throw new Exception('Error '.$http_code.': '.$error_msg); 
    //     } 
    //     Log::channel('daily')->info('calendar list: '.json_encode($data, true));
    //     return $data; 
    // } 

    public static function GetCalendarsList($calendarId,$access_token,$refreshToken,$employeeId,$eventdate) { 
        try{
            $url_parameters = array(); 
            // $url_parameters['fields'] = 'items(id,summary,timeZone)'; 
            // $url_parameters['minAccessRole'] = 'owner'; 
           
            $eventdate = date('Y-m-d', strtotime($eventdate));
            $url_parameters['timeMin'] = $eventdate.'T00:00:00Z';
            $url_parameters['timeMax'] = $eventdate.'T23:59:59Z';       
            // $url_calendars = self::CALENDAR_LIST. $calendarId. http_build_query($url_parameters); 
            $url_calendars = self::CALENDAR_EVENT .$calendarId . '/events?'.urldecode(http_build_query($url_parameters));
            // $url_calendars = self::CALENDAR_EVENT .$calendarId . '/events';
         
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $url_calendars);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);   
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
            // curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($url_parameters));  
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '. $access_token,
                'Content-Type: application/json'
            ));     
           $data = json_decode(curl_exec($ch), true); 
            // $data = curl_exec($ch); 
           
     
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE); 
       
            if ($http_code != 200) { 
                $error_msg = 'Failed to get calendars list';
                Log::channel('daily')->error($error_msg);
                Log::channel('daily')->error('listcalendar: '.json_encode($data, true)); 
                $custom = Setting::first();
                $client_id = $custom->google_client_id;
                $client_secret = $custom->google_client_secret;
                $data = self::RefreshToken($client_id, $client_secret, $refreshToken,$employeeId);
                $access_token = $data['access_token'];
                return self::GetCalendarsList($calendarId, $access_token,$refreshToken,$employeeId,$eventdate);
            } 
            // Log::channel('daily')->info('calendar list: '.json_encode($data, true));
            return array(
                "status" => true,
                "data" => $data
            );
        } catch (Exception $th) {
            Log::channel('daily')->error($th->getMessage());
            return array(
                "status" => false,
                "message" => $th->getMessage()
            );
        }
    } 

    public static function getTimezoneOffset($timezone = 'America/Los_Angeles'){ 
       
        $current   = timezone_open($timezone); 
        $utcTime  = new \DateTime('now', new \DateTimeZone('UTC')); 
        $offsetInSecs =  timezone_offset_get($current, $utcTime); 
        $hoursAndSec = gmdate('H:i', abs($offsetInSecs)); 
        return stripos($offsetInSecs, '-') === false ? "+{$hoursAndSec}" : "-{$hoursAndSec}"; 
    } 
 
    public static function getCalendarColors($access_token,$refreshToken,$employeeId)
    {
        try {   
            $apiURL = self::CALENDAR_COLOR;
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $apiURL);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));
            $data = json_decode(curl_exec($ch), true);
            log::channel('daily')->info(json_encode($data, true));
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);
            if ($http_code != 200) { 
                $error_msg = 'Failed to create event'; 
                if (curl_errno($ch)) { 
                    log::channel('daily')->info('CalendarColors '.json_encode($error_msg, true));
                    $error_msg = curl_error($ch); 
                    $custom = Setting::first();
                    $client_id = $custom->google_client_id;
                    $client_secret = $custom->google_client_secret;
                    $data = self::RefreshToken($client_id, $client_secret, $refreshToken, $employeeId);
                    $access_token = $data['access_token'];
                    self::getCalendarColors($access_token,$refreshToken,$employeeId);
                }
                Log::channel('daily')->info(json_encode($data, true));
                return array(
                    'status' => false,
                    'message' => $error_msg
                ); 
            //     throw new Exception('Error '.$http_code.': '.$error_msg); 
            } 
            Log::channel('daily')->info('COLOR: '.json_encode($data, true));
            return array(
                'status' => true,
                'id' => $data
            );
        } catch (Exception $th) {
            Log::channel('daily')->info('Color Error: '.$th->getMessage());
            return array(
                'status' => false,
                'message' => $th->getMessage()
            );
        }
    }

    public static function CreateCalendarEvent($access_token, $calendar_id, $event_data, $all_day, $event_datetime, $event_timezone,$employeeId,$refreshToken) { 
        // try {
            
            $apiURL = self::CALENDAR_EVENT . $calendar_id . '/events'; 
            $curlPost = array(); 
           
            if(!empty($event_data['summary'])){ 
                $curlPost['summary'] = $event_data['summary']; 
            } 
             
            if(!empty($event_data['location'])){ 
                $curlPost['location'] = $event_data['location']; 
            } 
             
            if(!empty($event_data['description'])){ 
                $curlPost['description'] = $event_data['description']; 
            } 
             
            $event_date = !empty($event_datetime['event_date'])?$event_datetime['event_date']:date("Y-m-d"); 
            $start_time = !empty($event_datetime['start_time'])?$event_datetime['start_time']:date("H:i:s"); 
            $end_time = !empty($event_datetime['end_time'])?$event_datetime['end_time']:date("H:i:s"); 
            
            if($all_day == 1){ 
                $curlPost['start'] = array('date' => $event_date); 
                $curlPost['end'] = array('date' => $event_date); 
            }else{ 
                $timezone_offset = self::getTimezoneOffset($event_timezone); 
                $timezone_offset = !empty($timezone_offset)?$timezone_offset:'07:00'; 
                $dateTime_start = $event_date.'T'.$start_time.$timezone_offset; 
                $dateTime_end = $event_date.'T'.$end_time.$timezone_offset; 
                 
                $curlPost['start'] = array('dateTime' => $dateTime_start, 'timeZone' => $event_timezone); 
                $curlPost['end'] = array('dateTime' => $dateTime_end, 'timeZone' => $event_timezone); 
            }
            $colors = self::getCalendarColors($access_token,$refreshToken,$employeeId);
            
            $curlPost['attendees'] =  array($event_data['customer']);

            $curlPost['status'] = 'tentative';

            if(isset($curlPost['status'])) {
                switch($curlPost['status']) {
                    case 'approved':
                        $curlPost['status'] = 'confirmed';
                        // $curlPost['colorId'] = '';
                        break;
                    case 'pending':
                        $curlPost['status'] = 'tentative';
                        // $curlPost['colorId'] = '';
                        break;
                    case 'cancel':
                        $curlPost['status'] = 'cancelled';
                        // $curlPost['colorId'] = '';
                        break;
                    default:
                        $curlPost['status'] = 'tentative';
                        // $curlPost['colorId'] = '';
                        break;
                }
            }
            $curlPost['visibility'] = 'public'; 
           
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $apiURL);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($ch, CURLOPT_POST, 1);         
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));     
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($curlPost)); 
             
            $data = json_decode(curl_exec($ch), true); 
            
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);         
            if ($http_code != 200) { 
                $error_msg = 'Failed to create event'; 
                if (curl_errno($ch)) { 
                    $error_msg = curl_error($ch); 
                    $custom = Setting::first();
                    $client_id = $custom->google_client_id;
                    $client_secret = $custom->google_client_secret;
                    $data = self::RefreshToken($client_id, $client_secret, $refreshToken,$employeeId);
                    $access_token = $data['access_token'];
                    self::getCalendarColors($access_token,$refreshToken,$employeeId);
                }
                Log::channel('daily')->info('event log '.json_encode($data, true));

                return array(
                    'status' => false,
                    'message' => $error_msg
                ); 
            //     throw new Exception('Error '.$http_code.': '.$error_msg); 
            } 
            Log::channel('daily')->info('event logg '.json_encode($data, true));
            return array(
                'status' => true,
                'id' => $data['id']
            ); 
        // } catch (Exception $th) {
        //     Log::channel('daily')->info($th->getMessage());
        //     return array(
        //         'status' => false,
        //         'message' => $th->getMessage()
        //     );
        // }
    } 
     
   public static function getCalendarEvents($calendarId, $access_token, $refreshToken,$employeeId)
   {
        try {
            $apiURL = self::CALENDAR_EVENT . $calendarId . '/events';
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $apiURL);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");         
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); 
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Authorization: Bearer '. $access_token,
                'Content-Type: application/json'
            ));      
            $data = json_decode(curl_exec($ch), true);
    
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);         
             
            if ($http_code != 200) { 
                $error_msg = 'Failed to create event'; 
                $custom = Setting::first();
                $client_id = $custom->google_client_id;
                $client_secret = $custom->google_client_secret;
                $data = self::RefreshToken($client_id, $client_secret, $refreshToken,$employeeId);
                $access_token = $data['access_token'];
                self::getCalendarEvents($calendarId,$access_token,$refreshToken,$employeeId);
                // if (curl_errno($ch)) { 
                //     $error_msg = curl_error($ch); 
                // }
                Log::channel('daily')->error('getcalendar: '.json_encode($data, true));
                return array(
                    "status" => false,
                    "message" => json_encode($data)
                ); 
                // throw new Exception('Error '.$http_code.': '.$error_msg); 
            }
            Log::channel('daily')->info('getcalendar200: '.json_encode($data, true));
            return array(
                "status" => true,
                "data" => $data
            );
            
        } catch (Exception $th) {
            Log::channel('daily')->error($th->getMessage());
            return array(
                "status" => false,
                "message" => $th->getMessage()
            );
        }
   }

   public static function updateCalendarsEvents($calendar_id, $access_token, $refreshToken, $event_id, $data, $timezone, $employeeId) {
        try {
            $apiURL = self::CALENDAR_EVENT . $calendar_id . '/events/' . $event_id;
            $timezone_offset = self::getTimezoneOffset($timezone); 
            $timezone_offset = !empty($timezone_offset)?$timezone_offset:'07:00'; 
            $data['start'] = array(
                "dateTime" => $data['date'].'T'.$data['start'].$timezone_offset,
                "timeZone" => $timezone
            ); 
            $data['end'] = array(
                "dateTime" => $data['date'].'T'.$data['end'].$timezone_offset,
                "timeZone" => $timezone
            );
            $colors = self::getCalendarColors($access_token,$refreshToken,$employeeId);
            unset($data['date']);
            if(isset($data['status'])) {
                switch($data['status']) {
                    case 'approved':
                        $data['status'] = 'confirmed';
                        // $data['colorId'] = '';
                        break;
                    case 'pending':
                        $data['status'] = 'tentative';
                        // $data['colorId'] = '';
                        break;
                    case 'cancel':
                        $data['status'] = 'cancelled';
                        // $data['colorId'] = '';
                        break;
                    default:
                        $data['status'] = 'tentative';
                        // $data['colorId'] = '';
                        break;
                }
            }
            $data['visibility'] = "public";
            Log::channel('daily')->info(json_encode($data, true));
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $apiURL);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));      
            $data = json_decode(curl_exec($ch), true);
    
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);         
            
            if ($http_code != 200) { 
                $error_msg = 'Failed to remove Event'; 
                if (curl_errno($ch)) { 
                    $error_msg = curl_error($ch); 
                }
                Log::channel('daily')->info(json_encode($data, true));
                return array(
                    "status" => false,
                    "message" => json_encode($data) 
                ); 
                // throw new Exception('Error '.$http_code.': '.$error_msg); 
            } 
            Log::channel('daily')->info(json_encode($data, true));
            return array(
                "status" => true,
                "data" => $data
            );
            
        } catch (Exception $th) {
            Log::channel('daily')->info($th->getMessage());
            return array(
                "status" => false,
                "message" => $th->getMessage()
            );
        }
   }

   public static function removeCalendarsEvents($calendar_id, $access_token, $event_id)
   {
        try {
            $apiURL = self::CALENDAR_EVENT . $calendar_id . '/events/' . $event_id;
            $ch = curl_init();         
            curl_setopt($ch, CURLOPT_URL, $apiURL);         
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);         
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
            curl_setopt($ch, CURLOPT_HTTPHEADER, array('Authorization: Bearer '. $access_token, 'Content-Type: application/json'));      
            $data = json_decode(curl_exec($ch), true);
        
            $http_code = curl_getinfo($ch,CURLINFO_HTTP_CODE);         
             
            if ($http_code != 200) { 
                $error_msg = 'Failed to remove Event'; 
                if (curl_errno($ch)) { 
                    $error_msg = curl_error($ch); 
                }
                Log::channel('daily')->info(json_encode($data, true)); 
                return array(
                    "status" => false,
                    "message" => json_encode($data, true) 
                );
                // throw new Exception('Error '.$http_code.': '.$error_msg); 
            } 
            Log::channel('daily')->info(json_encode($data, true));
            return array(
                "status" => true,
                "data" => $data
            );
        } catch (\Throwable $th) {
            Log::channel('daily')->info($th->getMessage());
            return array(
                "status" => false,
                "message" => $th->getMessage()
            );
        }
   }
} 
