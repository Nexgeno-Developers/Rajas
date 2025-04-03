<?php
/**
 * Created by PhpStorm.
 * User: irfan
 * Date: 18-10-20
 * Time: 7.18.MD
 */

namespace App\Http\Services\Implementations;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Services\Interfaces\IUserService;
use App\Http\Services\Interfaces\ILoginService;

class LoginService implements ILoginService
{
    public function __construct(IUserService $userService)
    {

    }

    public function login($credentials)
    {
        if (!Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['password']]) ) {
            session()->flash('error-message', trans('Email address and password does not match'));
            return redirect()->back();
        }
        if(Auth::user()->role_id == 2) {
            if(Auth::user()->status == '0') {
                session()->flash('error-message', trans('Your account is spended. Contact to administrator'));
                Auth::logout();
                return redirect()->back();
            }
            session()->flash('message', trans('You are Login Successfully'));
            return redirect()->route('welcome');
        }
        if( Auth::user()->role_id == 3) {
            if(Auth::user()->status == '0') {
                session()->flash('error-message', trans('Your account is spended. Contact to administrator'));
                Auth::logout();
                return redirect()->back();
            }
        }

        if(empty(Auth::user()->workingHour) && empty(Auth::user()->employeeServices) || Auth::user()->workingHour->isEmpty() && Auth::user()->employeeServices->isEmpty()) {
            return redirect()->route('completeRegister');
        }
        session()->flash('message', trans('You are Login Successfully'));
        return redirect()->route('dashboard');
    }

    public function forgotPassword($request) {
        return response()->json([]);
    }

    public function resetPassword($request) {
        Auth::loginUsingId(1);
        session()->flash('message', trans(''));
        return redirect()->route('welcome');
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();
        session()->flash('message', trans('You are Logged out Successfully'));
        return redirect()->back();
    }

}