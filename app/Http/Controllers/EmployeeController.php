<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Service;
use App\Entities\Setting;
use App\Entities\Category;
use App\Entities\Employee;
use App\Traits\Pagination;
use App\Entities\SiteConfig;
use Illuminate\Http\Request;
use App\Entities\Appointment;
use App\Entities\WorkingHour;
use App\Entities\EmployeeService;
use App\Entities\employeeSettings;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\EmployeeValidation;
use App\Entities\EmployeeServiceViewModel;
use App\Http\Services\Interfaces\IService;
use App\Http\Services\Interfaces\IEmployeeService;

class EmployeeController extends Controller
{
    use Pagination;

    protected $employeeService, $service, $custom;

    public function __construct(IEmployeeService $employeeService, IService $service)
    {
        $this->employeeService = $employeeService;
        $this->service = $service;
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
       
        $custom = Setting::first();
        $admin = User::where('id',Auth::user())->get();
        $this->authorize('employees', Auth::user());
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        $employees = array();
        $adminEmployees = employee::where('parent_user_id',Auth::user()->id)->where('role_id',3)->orderBy('id','DESC')->get();
        foreach ( $adminEmployees as $adminEmployee ) {
            $employee = new \stdClass();
            $employee->id = $adminEmployee->id;
            $employee->first_name = $adminEmployee->first_name;
            $employee->last_name = $adminEmployee->last_name;
            $employee->email = $adminEmployee->email;
            $employee->phone = $adminEmployee->phone;
            $employee->country_name = $adminEmployee->country_name;
            $employee->country_code = $adminEmployee->country_code;
            $categories = $services = array(); 
            foreach ( $adminEmployee->employeeServices as $employeeCategory ) {
                $category = Category::where('id',$employeeCategory->category_id)->first();
                if(!empty($category)) {
                    if(!in_array($category->name, $categories))
                        array_push($categories,$category->name);
                }
                if(!empty($employeeCategory)) {
                    if(empty($employeeCategory->service)) {
                        
                    }else{
                        if(!in_array($employeeCategory->Service->name, $services))
                        array_push($services,$employeeCategory->Service->name);
                    }
                }
            }
            $employee->categories = !empty($categories) ? implode(',', $categories) : '-';
            $employee->services = !empty($services) ? implode(',', $services) : '-';
            $employee->status = $adminEmployee->status;
            $employee->google_verify = false;
            $employee_link = employeeSettings::where('employee_id',$employee->id)->where('access_token','!=','')->first();
            if(!empty($employee_link)) {
                $employee->google_verify = true;
            }
            $employees[] = $employee;
        }
        return view('employees.index', compact('employees','rowIndex','custom'));
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create(Request $request)
    {   
        $this->authorize('employees', Auth::user());
        $services = Service::where('user_id',Auth::user()->id)->get();
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $country = SiteConfig::first();
        return view('employees.create', compact('services','categories','country'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param EmployeeValidation $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(EmployeeValidation $request)
    {
        $this->authorize('employees', Auth::user());
        $test = $this->employeeService->insert(new EmployeeServiceViewModel($request->all()));
        session()->flash('message', trans('Employee created successfully'));
        return redirect()->route('employees.index');
    }

    /**
     * Display the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Employee $employee)
    {
       
        $this->authorize('employees', Auth::user());
        $custom = Setting::first();
        $selectedValues = $employee->employeeServices;
        $workingHour = WorkingHour::where('employee_id',$employee->id)->where('user_id',Auth::user()->id)->first();
        
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $services = Service::where('user_id',Auth::user()->id)->get();
        $employeeServices = EmployeeService::where('employee_id',$employee->id)->get();

        /*if(empty($workingHour) || $employeeServices->isEmpty()) {
            $services = Service::where('user_id',Auth::user()->id)->get();
            $categories = Category::all();
            $findWorking = WorkingHour::where('employee_id', $employee->id)->first();
            $employee_id = $employee->id;
            return view('theme.employee-detail', compact('services','categories','findWorking','employee_id','custom','employee'));
        }*/

        return view('employees.show',compact('employee','selectedValues','workingHour','categories','services','employeeServices','custom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Employee $employee
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Employee $employee)
    {
        $this->authorize('employees', Auth::user());
        $custom = Setting::first();
        $country = SiteConfig::first();
        $services = Service::where('user_id',Auth::user()->id)->get();
        $selected_values = implode(',', $employee->employeeServices->pluck('service_id')->toArray());
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $workingHour = WorkingHour::where('employee_id',$employee->id)->where('user_id',Auth::user()->id)->first();
        $employeeServices = EmployeeService::where('employee_id',$employee->id)->get();
        
        /*if(empty($workingHour) || $employeeServices->isEmpty()) {
            $services = Service::where('user_id',Auth::user()->id)->get();
            $categories = Category::all();
            $findWorking = WorkingHour::where('employee_id',$employee->id)->first();
            $employee_id = $employee->id;
            return view('theme.employee-detail', compact('services','categories','findWorking','employee_id','custom','employee','country'));
        }*/

        return view('employees.edit',compact('employee','services','selected_values','workingHour','categories','employeeServices','custom','country'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param EmployeeValidation $request
     * @param Employee $employee
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(EmployeeValidation $request, Employee $employee)
    {
        $this->authorize('employees', Auth::user());
        $this->employeeService->update(new EmployeeServiceViewModel($request->all()), $employee);
        session()->flash('message', trans('Employee Detail Update Successfully'));
        return redirect()->route('employees.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Employee  $employee
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Employee $employee)
    {
        $this->authorize('employees', Auth::user());
        $this->employeeService->delete($employee->id);
        session()->flash('message', trans('Employee deleted successfully'));
        return redirect()->route('employees.index');
    }

    public function categoryservice(Request $request) 
    {
        if(!empty($request->category_id))
        {
            $services = Service::where('user_id',Auth::user()->id)
            ->where(function($query) use($request) {
                foreach ($request->category_id as $key => $value) {
                    $query->orwhere('category_id',$value);
                }
            })->get();
        }else {
            $services = Service::where('user_id',Auth::user()->id)->get();
        }
        return response()->json(['data' => $services]);
    }

    public function status(Request $request) 
    {
        User::where('id',$request->id)
            ->update([
                'status'=>$request->status
            ]);
        return response()->json(['data' => trans('Employee status updated successfully')]);
    }

    public function appointment($id,Request $request)
    {
        $this->authorize('employees', Auth::user());
        $custom = Setting::first();
        $filtercustomers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        $employees = User::where('role_id',3)->where('parent_user_id',Auth::user()->id)->get();
        $customers = User::where('role_id',2)->where('parent_user_id',Auth::user()->id)->get();
        $services = Service::where('user_id',Auth::user()->id)->get();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        session('frm', 'employee');
        $appointments = Appointment::where('employee_id', $id)->paginate(10);
        return view('appointments.index', compact('appointments','custom','services','employees','customers','rowIndex','filtercustomers'));
    }

    public function completeRegister(Request $request) {
        if($request->isMethod('post')) {
            $userdata = array(
                'status'=>1,
                'confirmed'=>1,
                'position' => $request->position,
                'facebook' => $request->facebook,
                'instagram' => $request->instagram,
                'twitter' => $request->twitter,
                'linkedin' => $request->linkedin
            );
            if($request->has('first_name')) {
                $userdata['first_name'] = $request->first_name;
                $userdata['last_name'] = $request->last_name;
                $userdata['email'] = $request->email;
                $userdata['phone'] = $request->phone;
                $userdata['country_name'] = $request->country_name;
                $userdata['country_code'] = $request->country_code;
            }
            
            $user = User::where('id',$request->employee_id)->update($userdata);

            $findWorking = WorkingHour::where('employee_id', $request->employee_id)->first();
            if(!empty($findWorking)) {
                $test = WorkingHour::where('employee_id', $request->employee_id)->update([
                    'start_time' => $request->start_time,
                    'finish_time' => $request->finish_time,
                    'rest_time'=> $request->rest_time,
                    'break_start_time'=>$request->break_start_time,
                    'break_end_time'=> $request->break_end_time,
                    'days'=>!empty($request->days) ? json_encode($request->days) : NULL
                ]);
            } else {
                $workingHour = new WorkingHour();
                $workingHour->user_id = $request->user_id;
                $workingHour->employee_id = $request->employee_id;
                $workingHour->start_time = $request->start_time;
                $workingHour->finish_time = $request->finish_time;
                $workingHour->rest_time = $request->rest_time;
                $workingHour->break_start_time = $request->break_start_time;
                $workingHour->break_end_time = $request->break_end_time;
                $workingHour->days = !empty($request->days) ? json_encode($request->days) : NULL;
                $workingHour->save();
             
            }


            $findServices = EmployeeService::where('employee_id', $request->employee_id)->get();
            if(count($findServices) > 0) {
                EmployeeService::where('employee_id', $request->employee_id)->delete();
            }
            if($request->service_id != null) {
                $categoryservices = $request->service_id;
                foreach ($categoryservices as $key => $categoryservice) {
                    foreach ($categoryservice as $service) {
                        $employeService = new EmployeeService();
                        $employeService->employee_id = $request->employee_id;
                        $employeService->user_id = $request->user_id;
                        $employeService->service_id = $service;
                        $employeService->category_id =  $key;
                        $employeService->save();
                    }
                }
            }
            session()->flash('message', trans('Employee Detail Update Successfully'));
            if(auth()->user()->role_id == '3') {
                return redirect()->route('dashboard');
            }
            return redirect()->route('employees.index');
        }
        $services = Service::where('user_id',Auth::user()->id)->get();
        $custom = Setting::first();
        if($services->isEmpty() && $custom->categories == 0) {
            $services = Service::where('user_id', Auth::user()->parent_user_id)->get();
        }
        $categories = Category::all();
        $findWorking = WorkingHour::where('employee_id', auth()->user()->id)->first();
        $employee_id = Auth::user()->id;
        return view('theme.employee-detail', compact('services','categories','findWorking','employee_id','custom'));
    }
}
