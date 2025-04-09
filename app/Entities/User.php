<?php

namespace App\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
       'country', 'state', 'city', 'zipcode', 'goverment_id', 'first_name', 'last_name','country_name','country_code','phone', 'email', 'position', 'password', 'facebook', 'instagram', 'twitter', 'linkedin', 'confirmed', 'role_id', 'profile','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function setFirstNameAttribute($value)
    {
        $this->attributes['first_name'] = ucfirst($value);    
    }

    public function setLastNameAttribute($value)
    {
        $this->attributes['last_name'] = ucfirst($value);    
    }

    public function getFirstNameAttribute($value)
    {
        return ucfirst($value);    
    }

    public function getLastNameAttribute($value)
    {
        return ucfirst($value);    
    }
    
    public function roles()
    {
        return $this->belongsTo('App\Entities\Role', 'role_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Entities\Appointment', 'user_id');
    }

    public function workingHour()
    {
        return $this->hasMany('App\Entities\WorkingHour', 'employee_id');
    }

    public function employeeServices()
    {
        return $this->hasMany('App\Entities\EmployeeService', 'employee_id');
    }
  
    public function notification()
    {
        return $this->hasMany('App\Entities\Notification','user_id');
    }

}
