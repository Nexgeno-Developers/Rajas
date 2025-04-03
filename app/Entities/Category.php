<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Category extends Model
{
    use Notifiable;
 
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','name'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }

    public function workingHour()
    {
        return $this->hasMany('App\Entities\WorkingHour', 'employee_id');
    }

    public function employeeServices()
    {
        return $this->hasMany('App\Entities\EmployeeService', 'employee_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Entities\Appointment', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Entities\Employee', 'employee_id');
    }

    public function services()
    {
        return $this->hasMany('App\Entities\Service','category_id');
    }


}
