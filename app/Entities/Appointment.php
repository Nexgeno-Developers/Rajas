<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Appointment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'google_appointment_id','admin_id','service_id','category_id','employee_id','date', 'user_id', 'start_time', 'finish_time', 'comments','status','note','approved_by','cancel_reason','appointment_process'
    ];

    public function setCategoryIdAttribute($value) {
        $this->attributes['category_id'] = ucfirst($value);
    }

    public function setServiceIdAttribute($value) {
        $this->attributes['service_id'] = ucfirst($value);
    }

    public function employee()
    {
        return $this->belongsTo('App\Entities\Employee', 'employee_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id');
    }

    public function payment()
    {
        return $this->hasOne('App\Entities\Payment','appointment_id');
    }

    public function notification()
    {
        return $this->hasOne('App\Entities\Notification','appointment_id');
    }
}
