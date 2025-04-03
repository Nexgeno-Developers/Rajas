<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Service extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','category_id','name','price','description','duration','auto_approve','cancel_before','image'
    ];

    public function setNameAttribute($value)
    {
        $this->attributes['name'] = ucfirst($value);
    }

    public function getNameAttribute($value)
    {
        return ucfirst($value);
    }
    
    public function employeeServices()
    {
        return $this->hasMany('App\Entities\EmployeeService','service_id');
    }

    public function appointments()
    {
        return $this->hasMany('App\Entities\Appointment','service_id');
    }

    public function categories()
    {
        return $this->belongsTo('App\Entities\Category', 'category_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id');
     } 
}
