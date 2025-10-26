<?php
namespace App\Listeners;

use Illuminate\Auth\Events\Logout;
use App\Models\Bitacora;
use Illuminate\Support\Facades\Cache;

class LogSuccessfulLogout
{
    public function handle(Logout $event): void
    {
        if (!$event->user) {
            return;
        }

        $cacheKey = 'logout_logged_' . $event->user->id . '_' . request()->ip();
        
        if (Cache::has($cacheKey)) {
            return;
        }

        Cache::put($cacheKey, true, 10);

        Bitacora::create([
            'accion' => 'Cierre de Sesión',
            'descripcion' => "El usuario {$event->user->username} cerró sesión",
            'tabla_afectada' => 'users',
            'registro_afectado' => $event->user->id,
            'ip_direccion' => request()->ip(),
            'id_usuario' => $event->user->id,
        ]);
    }
}
