<?php

namespace App\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SiteConfig extends Model
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    // protected
    protected $fillable = [
        'company_name','site_title','address','email','country_name','phone','facebook','twitter','linkedin','instagram','logo','favicon','location'
    ];

   
}