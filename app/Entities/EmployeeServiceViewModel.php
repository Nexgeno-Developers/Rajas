<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class EmployeeServiceViewModel extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','service_id','category_id','first_name','days','last_name','country_name','country_code','phone', 'email','password','start_time','finish_time','rest_time','break_start_time','break_end_time'
    ];

    public function toEmployee()
    {
        $employee = new Employee();
        $employee->parent_user_id = $this->user_id;
        $employee->first_name = $this->first_name;
        $employee->last_name = $this->last_name;
        $employee->country_name = $this->country_name;
        $employee->country_code = $this->country_code;
        $employee->phone = $this->phone;
        $employee->email = $this->email;
        $employee->password = bcrypt($this->password);
        $employee->role_id = 3;
        return $employee;
    }

    public function toWorkingHour()
    {
        $workingHour = new WorkingHour();
        $workingHour->start_time = $this->start_time;
        $workingHour->finish_time = $this->finish_time;
        $workingHour->rest_time = $this->rest_time;
        $workingHour->break_start_time = $this->break_start_time;
        $workingHour->break_end_time = $this->break_end_time;
        $workingHour->days = !empty($this->days) ? json_encode($this->days) : NULL;
        $workingHour->user_id = $this->user_id;
        return $workingHour;
    }

    public function toEmployeeService()
    {
        $employeeservice = new EmployeeService();
        $employeeservice->category_id = $this->category_id;
        $employeeservice->service_id = $this->service_id;
        $employeeservice->employee_id = $this->employee_id;
        $employeeservice->user_id = $this->user_id;
        return $employeeservice;
    }
}
