<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use App\Helper\Helper;
use App\Entities\Setting;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Auth\Notifications\ResetPassword;

// use Illuminate\Foundation\Auth\SendsPasswordResetEmails;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function forgotPasswordMail(Request $request)
    {
        $forgot = User::where('email',$request->email)->first();
        $remember_token = md5(rand(1000000000,999999999999));
        $forgot->remember_token = $remember_token;
        // $forgot->save();

        User::where('email', $request->email)->update([
            'remember_token' => $remember_token]);

        $user = User::where('email',$request->email)->first();
        if(empty($user) || $user->status == 0){
            session()->flash('error-message', trans('Your account is spended. Contact to administrator'));
            return redirect()->route('welcome');
        }else {
            $url = route('welcome').'?token='.$remember_token;

            $smtp = Setting::first();
            $site = SiteConfig::first();
            $logo = $site->logo;
            
            if($smtp->smtp_mail == 1) {
                $data = array(
                    'name' => $user->first_name.' '.$user->last_name,
                    'to' => $user->email,
                    'subject' => trans('Forgot Password'),
                    'title' => trans('Reset Password'),
                    'logo' => $logo,
                    'template' => 'mail.reset_password_email',
                    'url' => $url,
                    "body"=> "email"
                );
                
                Helper::emailinformation($data);
            }
            session()->flash('message', trans('Reset password email has been sent to your email address!.'));
            return redirect()->route('welcome');
        }
    }
}
