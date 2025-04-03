<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Setting;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use App\Entities\employeeSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterValidation;

class UserController extends Controller
{
    protected $custom;
    public function __construct()
    {
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     *  @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index()
    {
        //TODO
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //TODO
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RegisterValidation $request)
    {
        //TODO
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //TODO
       
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(Auth::user()->id != $id) {
            return redirect()->route('unauthorized');
        }
        $country = SiteConfig::first();
        $employee = User::find($id);
        $employee->google_verify = false;
        $employee_link = employeeSettings::where('employee_id',$employee->id)->where('access_token','!=','')->first();
        if(!empty($employee_link)) {
            $employee->google_verify = true;
        }
        return view('profile.edit',compact('country','employee'))->with(['user' => Auth::user()]);
    }

    public function profile($id)
    {
        if(Auth::user()->id != $id) {
            return redirect()->route('unauthorized');
        }
        $latestNotifications = DB::table('notification')->limit(3)->orderBy('id','desc')->get();
        $notificationcount = DB::table('notification')->where('user_id',Auth::user()->id)->count();
      
        return view('customer-profile', compact('latestNotifications','notificationcount'))->with(['user' => Auth::user()]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = Auth::user();
        if ($request->hasFile('profile') && $request->hasFile('profile')) {
            $this->validate($request, [
                'profile'=> 'required|mimes:png,jpg',
            ],[
                'profile.required' => trans('Please Select Profile Picture'),
                'profile.mimes' => trans('Profile Picture must be jpg, png file type')
            ]);
            $file = $request->file('profile');
            $image = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('img/profile/');
            $file->move($destinationPath,$image);
            User::where('id','=',Auth::user()->id)->update(['profile' =>$image]);
            $messages = trans('Profile picture updated successfully');
            if($request->has('frm')) {
                session(['frm' => $request->frm]);
            }
        } else if($request->has('email')) {
            $this->validate($request,[
                'first_name' => 'required',
                'last_name' => 'required',
                'email' => 'required|email|unique:users,email,'.$user->id.',id',
                'phone' => 'required|numeric'
                // |min:10|starts_with:+
            ],[
                'first_name.required' => trans('Please enter first name'),
                'last_name.required' => trans('Please enter last name'),
                'email.required' => trans('Please enter email'),
                'email.email' => trans('Please enter valid email'),
                'email.unique' => trans('Email already exists in the system'),
                'phone.required' => trans('Please enter phone number'),
                'phone.numeric' => trans('Phone number must be numeric and digits'),
                // 'phone.min' => trans('Phone number should be minimum 10 digits'),
                // 'phone.starts_with' => trans('Phone number must be start with +')
            ]);
            User::where('id','=',Auth::user()->id)
                     ->update(['first_name'=>$request->first_name,
                                'last_name'=>$request->last_name,
                                'country_name'=>$request->country_name,
                                'country_code'=>$request->country_code, 
                                'phone'=>$request->phone,
                                'email'=>$request->email,
                                'position' => $request->position
                            ]);
            $messages = trans('Profile updated successfully');
            if($request->has('frm')) {
                session(['frm' => $request->frm]);
            }
        } else {
            User::where('id','=',Auth::user()->id)->update(['profile' => '']);
            if($request->has('frm')) {
                session(['frm' => $request->frm]);
            }
            $messages = trans('Profile picture removed successfully');
        }
        session()->flash('message', $messages);
        return redirect()->back();
    }
    
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //TODO
    }

    public function updatePassword(Request $request)
    {
        if($request->has('frm')) {
            session(['frm'=> $request->frm]);
        }
        $this->validate($request, [
            'old_password'     => 'required',
            'new_password'     => 'required|min:6',
            'confirm_password' => 'required|same:new_password',
        ]);
        if(!Hash::check($request->old_password, auth()->user()->password)){
            session()->flash('password-message', trans('Old Password does not match!'));
            return redirect()->back();
        }else{
            User::whereId(auth()->user()->id)->update([
                'password' => bcrypt($request->new_password) ]);
                session()->flash('message', trans('Password changed successfully!'));
                return redirect()->back();
        }
    }

    public function updateSocialProfile(Request $request)
    {
        if($request->has('frm')) {
            session(['frm'=> $request->frm]);
        }
        $this->validate($request, [
            'facebook'     => 'required',
            'instagram'     => 'required',
            'twitter'     => 'required',
            'linkedin' => 'required',
        ]);
        User::whereId(auth()->user()->id)->update([
            'facebook' => $request->facebook,
            'instagram' => $request->instagram,
            'twitter' => $request->twitter,
            'linkedin' => $request->linkedin
        ]);
        session()->flash('message', trans('Social Profile updated successfully!'));
        return redirect()->back();
    }
}
