<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Cache;

class LogSuccessfulLogin
{
    public function handle(Login $event): void
    {
        $cacheKey = 'login_logged_' . $event->user->id . '_' . request()->ip();
        
        //Verificar si ya se registró este login en los últimos 5 segundos
        if (Cache::has($cacheKey)) {
            return;
        }
        Cache::put($cacheKey, true, 10);

        //Registrar en bitácora
        Bitacora::create([
            'accion' => 'Inicio de Sesión',
            'descripcion' => "El usuario {$event->user->username} inició sesión exitosamente",
            'tabla_afectada' => 'users',
            'registro_afectado' => $event->user->id,
            'ip_direccion' => request()->ip(),
            'id_usuario' => $event->user->id,
        ]);
    }
}