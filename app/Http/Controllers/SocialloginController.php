<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Entities\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;


use Illuminate\Support\Facades\Auth;

class SocialloginController extends Controller
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            $user = User::where('email', $googleUser->email)->first();
    
            if ($user) {

                Auth::login($user);

                session()->flash('message', trans('You are Login Successfully'));

                return redirect()->to(route('welcome'). '?sgmsg')->with('message', 'You are Login Successfully');
            } else {

                Session::put('google_email', $googleUser->email);
                Session::put('google_name', $googleUser->name);

                session()->flash('message', trans('Please complete your registration'));

                return redirect()->to(route('welcome'). '?sgmsg-rg')->with('message', 'Please complete your registration');
            }
        } catch (\Exception $e) {

            session()->flash('error-message', trans('Something went wrong. Please try again.'));

            return redirect()->to(route('welcome'). '?egmsg')->with('error-message', 'Something went wrong. Please try again.');
        }
    }

}