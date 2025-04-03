<?php

namespace App\Http\Controllers\Auth;

use App\Entities\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

// use Illuminate\Foundation\Auth\ResetsPasswords;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    //protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function UserResetPassword(Request $request)
    {
        $this->validate($request, [
            'email'     => 'required|email',
            'password'     => 'required|min:6',
            'password_confirmation' => 'required|same:password',
        ]);

        $user = User::where('email', $request->email)->first();
        if(!$user){
            return redirect()->route('welcome')->with('error', 'Invalid Token!');
        }

        User::where('email', $request->email)->update([
        'password' => bcrypt($request->password_confirmation) ]);
        session()->flash('message', trans('Your password has been updated successfully!'));
        return redirect()->route('welcome');
    }
}
