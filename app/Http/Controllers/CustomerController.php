<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Service;
use App\Entities\Setting;
use App\Traits\Pagination;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\CustomerRequest;
use App\Http\Services\Interfaces\IUserService;

class CustomerController extends Controller
{
    use Pagination;

    protected $userService, $custom;

    public function __construct(IUserService $userService)
    {
        $this->userService = $userService;
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function index(Request $request)
    {
        $this->authorize('customers', Auth::user());
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        $customers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->orderBy('id','DESC')->get();
        return view('customers.index',compact('customers','rowIndex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->authorize('customers', Auth::user());
        $customers = User::where('role_id',2)->where('id',$id)->first();
        return view('customers.show',compact('customers'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $this->authorize('customers', Auth::user());
        $customers = User::where('role_id',2)->where('id',$id)->first();
        $country = SiteConfig::first();
        return view('customers.edit',compact('customers','country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CustomerRequest $request, $id)
    {
        $this->authorize('customers', Auth::user());
        User::where('id',$id)->update(['first_name'=>$request->first_name,
                                        'last_name'=>$request->last_name,
                                        'country_name'=>$request->country_name,
                                        'country_code'=>$request->country_code,
                                        'phone'=>$request->phone,
                                        'email'=>$request->email ]);
        session()->flash('message', trans('Customer updated successfully'));
        return redirect()->route('customers.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->userService->delete($id);
        return redirect()->route('customers.index');
    }

    public function appointment($id,Request $request)
    {
        $this->authorize('customers', Auth::user());
        $custom = Setting::first();
        $customer_id = $id;
        $site = DB::table('site_configs')->first();
        $services = Service::where('user_id',Auth::user()->id)->get();
        $customers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        $employees = User::where('role_id',3)->where('parent_user_id',Auth::user()->id)->get();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        $list = Appointment::where('user_id', $id);
        $service_id = $employee_id = $start_date = $end_date = $status = '';
        if($request->has('service_id') && !empty($request->service_id)) {
            $service_id = $request->service_id;
            $list->where('service_id', 'like','%'.$service_id.'%');
        }
        if($request->has('employee_id') && !empty($request->employee_id)) {
            $employee_id = $request->employee_id;
            $list->where('employee_id', 'like','%'.$employee_id.'%');
        }
        if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && empty($request->end_date)) {
            $start_date = $request->start_date;
            $list->where('date', 'like','%'.$start_date.'%');
        } else if($request->has('start_date') && $request->has('end_date') && !empty($request->start_date) && !empty($request->end_date)) {
            $start_date = $request->start_date;
            $end_date = $request->end_date;
            $list->where('date','>=', $start_date)->where('date','<=', $end_date);
        }
        if($request->has('status') && !empty($request->status)) {
            $status = $request->status;
            $list->where('status','like','%'.$status.'%');
        }
        $appointment = $list->get();
        return view('customers.appointment', compact('appointment','custom','site','services','customers','employees','rowIndex','customer_id','service_id','employee_id','start_date','end_date','status'));
    }
}
