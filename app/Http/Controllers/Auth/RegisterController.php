<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;

use App\Entities\Setting;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterValidation;
use App\Http\Services\Interfaces\IRegisterService;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */

    protected $registerService;

    /**
     * RegisterController constructor.
     *
     * @param IRegisterService $registerService
     */
    public function __construct(IRegisterService $registerService)
    {
        $this->registerService = $registerService;
    }


    /**
     * Create a new user instance after a valid registration.
     *
     * @param RegisterValidation $request
     * @return \Illuminate\Http\JsonResponse
     */
    protected function store(RegisterValidation $request)
    {
        $data = $request->except('mobile');
        $data['phone'] = $request->mobile;
        $user = $this->registerService->insert(new User($data));
        $notificationMsg = 'Hey '.$user->first_name.' '.$user->last_name.', '.trans('Thanks for registration. Enjoy unlimited appointment of different services!');
        $notification = DB::table('notification')->insert([
            'user_id'=> $user->id,
            'employee_id'=> '',
            'admin_id'=>1,
            'appointment_id'=>'',
            'type'=>'customer',
            'message'=> $notificationMsg,
            'is_read'=> 0,
            'created_at' => date('Y-m-d H:i:s'),
            'updated_at' => date('Y-m-d H:i:s')
        ]);

        $user_id = $user->id; //new
        Auth::loginUsingId($user_id); //new

        $smtp = Setting::first();
        $site = SiteConfig::first();
        if($smtp->smtp_mail == 1) {
            $data = array(
                'name' => $user->first_name.' '.$user->last_name,
                'email' => $user->email,
                'password' => $request->password,
                'to' => $user->email,
                'title' => trans('New Registration'),
                'site_name' => $site->site_title,
                'company_name' => $site->company_name,
                'subject' => trans('Account Created'),
                'template' => 'mail.emp_create_email',
                'body' => 'email'
            );
            $email = \App\Helper\Helper::emailinformation($data);
        } 
        session()->flash('message', trans('Your registration is completed.'));
        //return redirect()->route('welcome');
        return redirect()->route('customer-profile', ['id' => $user_id]);
    }

    protected function signup(Request $request) {
        return view('register');
    }
}

