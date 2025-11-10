<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL; 
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Carbon\Carbon;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Forzar HTTPS en producción
        if ($this->app->environment('production')) {
            URL::forceScheme('https');
        }
        
        // Configurar zona horaria Bolivia
        date_default_timezone_set('America/La_Paz');
        Config::set('app.timezone', 'America/La_Paz');
        
        // Configurar Carbon
        Carbon::setLocale('es');
        
        // Configurar PostgreSQL timezone
        try {
            if (config('database.default') === 'pgsql') {
                DB::statement("SET timezone = 'America/La_Paz'");
                \Log::info('✅ PostgreSQL timezone configurado: America/La_Paz');
            }
        } catch (\Exception $e) {
            \Log::warning('⚠️ No se pudo configurar timezone en PostgreSQL: ' . $e->getMessage());
        }
    }
}