<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Setting;
use App\Traits\Pagination;
use App\Entities\WorkingHour;
use App\Entities\EmployeeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\WorkingHourValidation;
use App\Http\Services\Interfaces\IEmployeeService;
use App\Http\Services\Interfaces\IWorkingHourService;

class WorkingHourController extends Controller
{
    use Pagination;

    protected $employeeService, $workingHourService, $custom;

    public function __construct(IWorkingHourService $workingHourService, IEmployeeService $employeeService)
    {
        $this->employeeService = $employeeService;
        $this->workingHourService = $workingHourService;
        $this->custom = Setting::first();
        view()->share('custom', $this->custom);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $workingHours = WorkingHour::where('user_id',Auth::user()->id)->paginate(10);
        return view('working_hours.index', compact('workingHours'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $employees = User::where('role_id',3)->where('parent_user_id',Auth::user()->id)->get();
        return view('working_hours.create',compact('employees'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(WorkingHourValidation $request)
    {
        $this->workingHourService->insert(new WorkingHour($request->all()));
        session()->flash('message', trans('Working hour created successfully'));
        return redirect()->route('working-hours.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\WorkingHour  $workingHour
     * @return \Illuminate\Http\Response
     */
    public function show(WorkingHour $workingHour)
    {
       $workingHour = WorkingHour::where('employee_id',$workingHour->employee_id)->where('user_id',Auth::user()->id)->first();
        if(empty($workingHour)) {
            return redirect()->back();
        }
        return view('working_hours.show',compact('workingHour'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\WorkingHour  $workingHour
     * @return \Illuminate\Http\Response
     */
    public function edit(WorkingHour $workingHour)
    {
        $employees = $this->employeeService->get();
        $app = EmployeeService::where('employee_id',$workingHour->employee_id)->where('user_id',Auth::user()->id)->first();
        if(empty($app)) {
            return redirect()->back();
        }
        return view('working_hours.edit',compact('workingHour','employees'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Entities\WorkingHour  $workingHour
     * @return \Illuminate\Http\Response
     */
    public function update(WorkingHourValidation $request, WorkingHour $workingHour)
    {
        $this->workingHourService->update($workingHour->fill($request->all()));
        session()->flash('message', trans('Working hour updated successfully'));
        return redirect()->route('working-hours.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\WorkingHour  $workingHour
     * @return \Illuminate\Http\Response
     */
    public function destroy(WorkingHour $workingHour)
    {
        $this->workingHourService->delete($workingHour->id);
        session()->flash('message', trans('Working hour deleted successfully'));
        return redirect()->route('working-hours.index');
    }
}
