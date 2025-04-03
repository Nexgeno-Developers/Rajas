<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('employees', 'App\Policies\EmployeePolicy@employee');
        Gate::define('customers', 'App\Policies\CustomerPolicy@customers');
        Gate::define('services', 'App\Policies\ServicePolicy@services');
        Gate::define('lanes', 'App\Policies\LanePolicy@lanes');
        Gate::define('appointments', 'App\Policies\AppointmentPolicy@appointments');
        Gate::define('categories', 'App\Policies\CategoryPolicy@categories');
        Gate::define('payments', 'App\Policies\PaymentPolicy@payment');
        Gate::define('settings', 'App\Policies\SettingPolicy@setting');
        Gate::define('employeepayment','App\Policies\EmployeePaymentPolicy@employeepayment');
    }
}
