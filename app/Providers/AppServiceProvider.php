<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        //zona horaria Bolivia
        date_default_timezone_set('America/La_Paz');
        Config::set('app.timezone', 'America/La_Paz');
        try {
            if (config('database.default') === 'pgsql') {
                DB::unprepared("SET TIME ZONE 'America/La_Paz'");
            }
        } catch (\Exception $e) {

        }
    }
}
