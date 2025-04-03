<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Employee extends Model
{
    use Notifiable;
    protected $table="users";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'first_name', 'last_name','country_name','country_code','phone', 'email','password'
    ];

       /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        'first_name' => 'required',
        'last_name' => 'required',
        'email' => 'required|email',
        'password' => 'required',

    ];

    public function workingHour()
    {
        return $this->hasMany('App\Entities\WorkingHour', 'employee_id');
    }

    public function employeeServices()
    {
        return $this->hasMany('App\Entities\EmployeeService', 'employee_id');
    }

    public function categories()
    {
        return $this->hasMany('App\Entities\EmployeeService', 'category_id','id');
    }

    public function service()
    {
        return $this->hasMany('App\Entities\EmployeeService', 'service_id','id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Entities\Appointment', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id');
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function getPositionAttribute($value)
    {
        return ucfirst($value);
    }
}
