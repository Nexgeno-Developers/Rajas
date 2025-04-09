<?php
namespace App\Helper;

use App\Entities\Setting;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class Helper
{
    public static function emailinformation($data)
    {
       
        $custom = Setting::first();
        Config::set('mail.host', $custom->smtp_host);
        Config::set('mail.username', $custom->smtp_email);
        Config::set('mail.password', decrypt($custom->smtp_password));
        Config::set('mail.port', $custom->smtp_port);
        return Mail::send($data['template'], $data, function ($massage) use ($data, $custom) {
            $massage->to($data['to'], $data['name'])->subject($data['subject']);
            $massage->from($custom->smtp_email, $data['title']);
        });
        Log::info('Email Sent');
    }

    public static function timeformat($time)
    {
        $time = date('h:i', strtotime($time));
        $time = explode(':', $time);
        if ($time[0] == 12) {
            return $time[1] . 'm';
        } else {
            return $time[0] . 'h, ' . $time[1] . 'm';
        }
    }

    public static function notificationTime($time)
    {
        $time = strtotime($time) ? strtotime($time) : $time;
        $time = time() - $time;

        switch ($time):
    // seconds
    case $time <= 60;
        return 'just now';
    // minutes
    case $time >= 60 && $time < 3600;
        return (round($time / 60) == 1) ? 'just now' : round($time / 60) . ' minutes ago';
    // hours
    case $time >= 3600 && $time < 86400;
        return (round($time / 3600) == 1) ? 'a hour ago' : round($time / 3600) . ' hours ago';
    // days
    case $time >= 86400 && $time < 604800;
        return (round($time / 86400) == 1) ? 'a day ago' : round($time / 86400) . ' days ago';
    // weeks
    case $time >= 604800 && $time < 2600640;
        return (round($time / 604800) == 1) ? 'a week ago' : round($time / 604800) . ' weeks ago';
    // months
    case $time >= 2600640 && $time < 31207680;
        return (round($time / 2600640) == 1) ? 'a month ago' : round($time / 2600640) . ' months ago';
    // years
    case $time >= 31207680;
        return (round($time / 31207680) == 1) ? 'a year ago' : round($time / 31207680) . ' years ago';
        endswitch;

    }
    public static function notification($response)
    {

            try {
                $credentials = Setting::find(1);
                if (!empty($credentials) && isset($credentials->twilio_active_mode)) {
                    $phoneNumber = $credentials->twilio_phone;
                    $use_twilio_service_id = $credentials->use_twilio_service_id;
                    if ($credentials->twilio_active_mode == 0) {
                        $accountId = $credentials->twilio_sandbox_key;
                        $authToken = $credentials->twilio_sandbox_secret;
                        $messageServiceId = $credentials->twilio_serivce_id;
                    } else if ($credentials->twilio_active_mode == 1) {
                        $accountId = $credentials->twilio_live_key;
                        $authToken = $credentials->twilio_live_secret;
                        $messageServiceId = $credentials->twilio_service_id;
                    }
                    if (isset($response['to']) && isset($response['body']) && $use_twilio_service_id == 1 && !empty($messageServiceId)) {
                        $twilio = new \Twilio\Rest\Client($accountId, $authToken);
                        $twilio->messages->create($response['to'], [
                            'MessagingServiceSid' => trim($messageServiceId),
                            'body' => trim($response['body']),
                        ]);

                        return true;
                    } else if (isset($response['to']) && isset($response['body']) && $use_twilio_service_id == 0 && !empty($phoneNumber)) {
                        $twilio = new \Twilio\Rest\Client($accountId, $authToken);
                        $twilio->messages->create($response['to'], [
                            'from' => trim($phoneNumber),
                            'body' => trim($response['body']),
                        ]);

                        return true;
                    }
                    return false;
                }
                return false;
            } catch (\Twilio\Exceptions\RestException $th) {
                Log::error($th->getMessage());
                return false;
            }
    }

    public static function verifyNumber($number)
    {

        $requestData = array(
            'FriendlyName' => 'ReadyBook',
            'CodeLength' => '6',
            'LookupEnabled' => true,
            'SkipSmsToLandlines' => true,
        );
    }

    public static function phoneNumber($number)
    {

        $number = rtrim(trim(preg_replace('/^((?=^)(\s*))|((\s*)(?>$))/si', '', $number)));
        $number = str_replace(['"', '(', ')', '-', '*', '#', ' ', '  ', '   ', '.'], ['', '', '', '', '', '', '', '', '', ''], $number);
        $counter = strlen($number);
        $codes = array(
            '1' => '1',
            '2' => '2',
            '3' => '3',
            '39' => '39',
            '4' => '33',
            '49' => '49',
            '44' => '44',
            '123' => '123',
            '971' => '971',
            '91' => '91',
            '6' => '91',
            '7' => '91',
            '8' => '91',
            '9' => '91',
            '92' => '92',
        );
        krsort($codes);

        if (!empty($number)) {

            if ($number[0] == '+') {
                return $number;
            } else {
                if ($counter == 11) {
                    return '+' . $number;
                } else {
                    foreach ($codes as $key => $value) {
                        if (substr($number, 0, strlen($key)) == $key) {

                            return $number = '+' . $value . $number;
                        }
                    }
                    return '+1' . $number;
                }
            }
            return $number;
        }
    }

    public static function googlecalendar($email = false, $id)
    {
        $custom = Setting::first();
        // Google API configuration
        $GOOGLE_CLIENT_ID = $custom->google_client_id;
        $GOOGLE_CLIENT_SECRET = $custom->google_client_secret;
        $GOOGLE_OAUTH_SCOPE = 'https://www.googleapis.com/auth/calendar';
        $REDIRECT_URI = route('GoogleCalendarEventSync');
        $access_type = "offline";
        $include_granted_scope = "true";
        $Prompt = "consent";
        // $num = rand(10, 999);
        // $state= \Illuminate\Support\Str::random($num);
        $state = encrypt($id);
        $googleOauthURL = 'https://accounts.google.com/o/oauth2/auth?scope=' . urlencode($GOOGLE_OAUTH_SCOPE) . '&redirect_uri=' . $REDIRECT_URI . '&response_type=code&client_id=' . $GOOGLE_CLIENT_ID . '&access_type=' . $access_type;
        $googleOauthURL .= '&state=' . $state . '&include_granted_scopes=' . $include_granted_scope . '&prompt=' . $Prompt;
        if (!empty($email)) {
            $googleOauthURL .= '&login_hint=' . $email;
        }
        return $googleOauthURL;
    }

    // get all active countries

    public static function get_active_countries()
    {
        $states = DB::table('countries')
        ->where('status', 1)
        ->get();
        return $states;
    }

}
