<?php

namespace App\Providers;

use App\Entities\Appointment;
use App\Entities\User;
use App\Observers\AppointmentObserve;
use App\Observers\UserObserve;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\Event' => [
            'App\Listeners\EventListener',
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
        Appointment::observe(AppointmentObserve::class);
    }
}
