<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

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
        // Configurar zona horaria globalmente
        date_default_timezone_set('America/La_Paz');
        Carbon::setTimezone('America/La_Paz');
        
        // Configurar zona horaria en PostgreSQL
        if (config('database.default') === 'pgsql') {
            try {
                DB::statement("SET TIME ZONE 'America/La_Paz'");
            } catch (\Exception $e) {
                // Ignorar errores durante migraciones o cuando DB no está disponible
            }
        }
    }
}
