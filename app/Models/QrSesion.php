<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Support\Str;

class QrSesion extends Model
{
    use HasFactory;

    protected $table = 'qr_sesiones';

    protected $fillable = [
        'id_horario',
        'fecha',
        'token',
        'fecha_generacion',
        'fecha_expiracion',
        'activo',
        'usos',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'fecha_generacion' => 'datetime',
            'fecha_expiracion' => 'datetime',
            'activo' => 'boolean',
        ];
    }

    //Relaciones
    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    //Scopes
    public function scopeActivos($query)
    {
        return $query->where('activo', true)
                    ->where('fecha_expiracion', '>', now());
    }

    public function scopePorToken($query, $token)
    {
        return $query->where('token', $token);
    }

    /**
     * Genera un nuevo código QR para una sesión de clase
     * Válido por 30 minutos (10 antes + 20 después)
     */
    public static function generarQR($idHorario, $fecha, $horaInicio)
    {
        // Desactivar QRs anteriores para esta sesión
        self::where('id_horario', $idHorario)
            ->where('fecha', $fecha)
            ->update(['activo' => false]);

        $horaInicioCarbon = Carbon::parse($fecha . ' ' . $horaInicio);
        
        // Token único
        $token = Str::random(64);
        
        // Ventana de validez: 10 minutos antes hasta 20 minutos después
        $fechaGeneracion = $horaInicioCarbon->copy()->subMinutes(10);
        $fechaExpiracion = $horaInicioCarbon->copy()->addMinutes(20);

        return self::create([
            'id_horario' => $idHorario,
            'fecha' => $fecha,
            'token' => $token,
            'fecha_generacion' => $fechaGeneracion,
            'fecha_expiracion' => $fechaExpiracion,
            'activo' => true,
            'usos' => 0,
        ]);
    }

    /**
     * Valida si el QR es válido y está dentro del tiempo permitido
     */
    public function esValido()
    {
        return $this->activo && 
               now()->between($this->fecha_generacion, $this->fecha_expiracion);
    }

    /**
     * Incrementa el contador de usos
     */
    public function registrarUso()
    {
        $this->increment('usos');
    }

    /**
     * Obtiene el tiempo restante de vigencia (útil para mostrar en vistas)
     */
    public function getTiempoRestanteAttribute()
    {
        if (!$this->esValido()) {
            return 'Expirado';
        }
        
        return $this->fecha_expiracion->diffForHumans();
    }

    /**
     * Obtiene el estado legible del QR
     */
    public function getEstadoTextoAttribute()
    {
        if (!$this->activo) {
            return 'Inactivo';
        }
        
        if (!$this->esValido()) {
            return 'Expirado';
        }
        
        return 'Activo';
    }
}