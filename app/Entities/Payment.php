<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Payment extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'payment_id','appointment_id','payment_method','currency','amount','payment_type','payment_detail_id','upi_id','payment_date','status'
    ];

    public function employeeServices()
    {
        return $this->belongsTo('App\Entities\EmployeeService','service_id');
    }

    public function appointments()
    {
        return $this->belongsTo('App\Entities\Appointment','appointment_id');
    }
}