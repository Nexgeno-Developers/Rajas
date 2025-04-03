<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class EmployeeService extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'employee_id', 'service_id', 'user_id','category_id'
    ];

    public function service()
    {
        return $this->belongsTo('App\Entities\Service','service_id');
    }
    
    public function category()
    {
        return $this->belongsTo('App\Entities\Category','category_id');
    }

    public function employee()
    {
        return $this->belongsTo('App\Entities\User','employee_id');
    }
    
    public function scopeuseremployee($emp)
    {
        return $emp->where('user_id',Auth::user()->id);
    }
}
