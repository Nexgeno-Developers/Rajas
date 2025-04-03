<?php

namespace App\Http\Controllers;

use App\Entities\User;
use App\Entities\Service;
use App\Entities\Setting;
use App\Entities\Category;
use App\Traits\Pagination;
use Illuminate\Http\Request;
use App\Entities\EmployeeService;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ServiceValidation;
use App\Http\Services\Interfaces\IService;

class ServiceController extends Controller
{
    use Pagination;

    protected $service, $custom;

    public function __construct(IService $service)
    {
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
        $this->authorize('services', Auth::user());
        $custom = Setting::first();
        if($request->has('page') && $request->page > 1) {
            $rowIndex = (($request->page - 1) * 10) + 1;
        } else {
            $rowIndex = 1;
        }
        $services = Service::where('user_id',Auth::user()->id)->orderBy('id','DESC')->get(); 
        return view('services.index', compact('services','custom','rowIndex'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function create()
    {
        $this->authorize('services', Auth::user());
        $custom = Setting::first();
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $service = Service::where('user_id',Auth::user()->id)->get();
        return view('services.create',compact('categories','custom','service'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ServiceValidation $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function store(ServiceValidation $request)
    {
        $this->authorize('services', Auth::user());

        if ($request->hasFile('image') && $request->hasFile('image')) {
            $file = $request->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('img/services/');
            $file->move($destinationPath,$image);
            array_merge($request->all(),['image' => $image]);
        }
        $duration = $request->duration;
        if(empty($request->duration)) {
            $duration = '23:59:59';
        }
        $this->service->insert(new Service(array_merge($request->all(),['image' => $image, 'duration' => $duration])));
        session()->flash('message',  trans('Service created successfully'));
        return redirect()->route('services.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Entities\Service $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Service $service)
    {
        $this->authorize('services', Auth::user());
        $custom = Setting::first();
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $app = Service::where('id',$service->id)->where('user_id',Auth::user()->id)->first();
        if(empty($app)) {
            return redirect()->back();
        }
        return view('services.show', compact('service','categories','custom'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Entities\Service $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Service $service)
    {
        $this->authorize('services', Auth::user());
        $custom = Setting::first();
        $categories = Category::where('user_id',Auth::user()->id)->get();
        $app = Service::where('id',$service->id)->where('user_id',Auth::user()->id)->first();

        if(empty($app)) {
            return redirect()->back();
        }
        return view('services.edit', compact('service','categories','custom'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ServiceValidation $request
     * @param  \App\Entities\Service $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(ServiceValidation $request, Service $service)
    {
       
        $this->authorize('services', Auth::user());
        if(!isset($request->auto_approve)) {
            $request->request->add(['auto_approve' => 0]);
        }

        if ($request->hasFile('image') && $request->hasFile('image')) {
            $file = $request->file('image');
            $image = time().'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('img/services/');
            $file->move($destinationPath,$image);
            array_merge($request->all(),['image' => $image]);
            $this->service->update($service->fill(array_merge($request->all(),['image' => $image])));
            session()->flash('message', trans('Service updated successfully'));
            return redirect()->route('services.index');
        }
        $duration = $request->duration;
        if(empty($request->duration)) {
            $duration = '23:59:59';
        }
        $this->service->update($service->fill(array_merge($request->all(),['duration' => $duration])));
        session()->flash('message', trans('Service updated successfully'));
        return redirect()->route('services.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Entities\Service $service
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function destroy(Service $service)
    {
        $this->authorize('services', Auth::user());
        $this->service->delete($service->id);
        session()->flash('message', trans('Service deleted successfully'));
        return redirect()->route('services.index');
    }

    public function employee($id)
    {
        $this->authorize('services', Auth::user());
        $user = User::where('id',$id)->where('parent_user_id',Auth::user()->id)->first();
        $service = Service::where('id', $id)->where('user_id',Auth::user()->id)->first();
        if(empty($service)){
            return redirect()->route('unauthorized');
        }
        $employees = EmployeeService::where('service_id', $id)->paginate(10);
        return view('services.employee', compact('employees','service'));
    }

}
