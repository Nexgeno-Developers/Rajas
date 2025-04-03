<?php

namespace App\Repositories\Implementations;


use App\Entities\EmployeeService;
use Illuminate\Support\Facades\Auth;
use App\Repositories\Interfaces\IServiceEmployeeRepository;

class ServiceEmployeeRepository implements IServiceEmployeeRepository
{

    public function __construct()
    {
    }

    public function get()
    {
        return EmployeeService::all();
    }

    public function getById($id)
    {
        return EmployeeService::find($id);
    }

    public function insert(EmployeeService $employeeService)
    {
        $employeeService->user_id = Auth::user()->id;
        $employeeService->save();
        return $employeeService;
    }

    public function update(EmployeeService $employeeService)
    {
        $employeeService->update();
        return $employeeService;
    }

    public function delete($id)
    {
        return $this->getById($id)->delete();
    }
}