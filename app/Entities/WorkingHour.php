<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;

class WorkingHour extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id','employee_id', 'days','start_time', 'finish_time','rest_time','break_start_time','break_end_time'
    ];

    public function employees()
    {
        return $this->belongsTo('App\Entities\User', 'employee_id');
    }
    public function user()
    {
        return $this->belongsTo('App\Entities\User', 'user_id');
    }
    
    public function setStartTimeAttribute($value)
    {
        $this->attributes['start_time'] = date('H:i:s', strtotime($value));
    }
    public function setFinishTimeAttribute($value)
    {
        $this->attributes['finish_time'] = date('H:i:s', strtotime($value));
    }
    public function setBreakStartTimeAttribute($value)
    {
        $this->attributes['break_start_time'] = !empty($value) ? date('H:i:s', strtotime($value)) : null;
    }
    public function setBreakEndTimeAttribute($value)
    {
        $this->attributes['break_end_time'] = !empty($value) ? date('H:i:s', strtotime($value)) : null;
    }
}
