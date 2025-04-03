<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    protected $table="notification";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id','user_id','admin_id','employee_id','appointment_id','type','message','is_read',
    ];

    public function appointments()
    {
        return $this->belongsTo('App\Entities\Appointment','id');
    }

    public function user()
    {
        return $this->belongsTo('App\Entities\User','id');
     } 
}