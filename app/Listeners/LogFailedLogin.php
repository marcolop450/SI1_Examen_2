<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Failed;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Cache;

class LogFailedLogin
{
    public function handle(Failed $event): void
    {
        $username = $event->credentials['username'] ?? 'desconocido';
        $cacheKey = 'failed_login_' . $username . '_' . request()->ip();
        
        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, 5);

        Bitacora::create([
            'accion' => 'Intento de Inicio Fallido',
            'descripcion' => "Intento fallido de inicio de sesión con username: {$username}",
            'tabla_afectada' => 'users',
            'registro_afectado' => null,
            'ip_direccion' => request()->ip(),
            'id_usuario' => 1, 
        ]);
    }
}