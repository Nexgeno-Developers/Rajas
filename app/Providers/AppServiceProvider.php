<?php

namespace App\Providers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        
        try {

            if ($this->app->environment('production')) {
                URL::forceScheme('https');
            }

            if(env('APP_KEY') != "") {
                if(DB::table('site_configs')->exists()) {
                    $site = DB::table('site_configs')->first();
                    view()->share('site', $site);
                }
                if(DB::table('settings')->exists()) {
                    $custom = DB::table('settings')->first();
                    config(['app.timezone' => $custom->timezone]);
                    view()->share('custom', $custom);
                }
            }
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
        }
    }
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Schema::defaultStringLength(255);
    }
}
