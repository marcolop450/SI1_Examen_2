<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora_llegada',
        'hora_salida',
        'estado',
        'observaciones',
        'justificada',
        'id_docente',
        'id_horario',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'justificada' => 'boolean',
        ];
    }

    //Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'registro');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    //Scopes
    public function scopeATiempo($query)
    {
        return $query->where('estado', 'A tiempo');
    }

    public function scopeTardanzas($query)
    {
        return $query->where('estado', 'Tardanza');
    }

    public function scopeFaltas($query)
    {
        return $query->where('estado', 'Falta');
    }

    public function scopeJustificadas($query)
    {
        return $query->where('justificada', true);
    }

    public function scopePorFecha($query, $fecha)
    {
        return $query->whereDate('fecha', $fecha);
    }

    public function scopePorDocente($query, $idDocente)
    {
        return $query->where('id_docente', $idDocente);
    }

    public static function calcularEstado($horaLlegada, $horaInicio)
    {
        try {
            $now = Carbon::now('America/La_Paz');
            
            $llegada = Carbon::createFromFormat('H:i:s', $horaLlegada, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            $inicio = Carbon::createFromFormat('H:i:s', $horaInicio, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            \Log::info('🔍 Calculando estado', [
                'hora_llegada' => $horaLlegada,
                'hora_inicio' => $horaInicio,
                'llegada_carbon' => $llegada->format('Y-m-d H:i:s'),
                'inicio_carbon' => $inicio->format('Y-m-d H:i:s'),
                'llegada_lessThan_inicio' => $llegada->lessThan($inicio),
                'llegada_greaterThan_inicio' => $llegada->greaterThan($inicio),
            ]);
            if ($llegada->lessThanOrEqualTo($inicio)) {
                \Log::info('✅ Estado: A tiempo (llegó antes o exacto)');
                return 'A tiempo';
            }
            
            $minutosRetraso = $inicio->diffInMinutes($llegada, false);
            
            \Log::info('⏰ Minutos de retraso calculados', [
                'minutos_retraso' => $minutosRetraso
            ]);
            if ($minutosRetraso <= 5) {
                \Log::info('✅ Estado: A tiempo (dentro de 5 min de tolerancia)');
                return 'A tiempo';
            }
            if ($minutosRetraso <= 20) {
                \Log::info('⚠️ Estado: Tardanza');
                return 'Tardanza';
            }
            
            // Más de 20 minutos = Falta
            \Log::info('❌ Estado: Falta');
            return 'Falta';
            
        } catch (\Exception $e) {
            \Log::error('💥 Error en calcularEstado', [
                'horaLlegada' => $horaLlegada,
                'horaInicio' => $horaInicio,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return 'Falta'; // Por seguridad
        }
    }

    public static function estaDentroDeRango($horaActual, $horaInicio)
    {
        try {
            $now = Carbon::now('America/La_Paz');
            
            $actual = Carbon::createFromFormat('H:i:s', $horaActual, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            $inicio = Carbon::createFromFormat('H:i:s', $horaInicio, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            $limiteInferior = $inicio->copy()->subMinutes(10); 
            $limiteSuperior = $inicio->copy()->addMinutes(20); 
            
            \Log::info('🔍 Verificando rango permitido', [
                'hora_actual' => $actual->format('H:i:s'),
                'limite_inferior' => $limiteInferior->format('H:i:s'),
                'limite_superior' => $limiteSuperior->format('H:i:s'),
                'esta_en_rango' => $actual->between($limiteInferior, $limiteSuperior)
            ]);
            
            return $actual->between($limiteInferior, $limiteSuperior);
            
        } catch (\Exception $e) {
            \Log::error('Error en estaDentroDeRango', [
                'horaActual' => $horaActual,
                'horaInicio' => $horaInicio,
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    public static function calcularMinutosDiferencia($horaLlegada, $horaInicio)
    {
        try {
            $now = Carbon::now('America/La_Paz');
            
            $llegada = Carbon::createFromFormat('H:i:s', $horaLlegada, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            $inicio = Carbon::createFromFormat('H:i:s', $horaInicio, 'America/La_Paz')
                ->setDate($now->year, $now->month, $now->day);
            
            if ($llegada->lessThan($inicio)) {
                return -$inicio->diffInMinutes($llegada);
            }           
            return $llegada->diffInMinutes($inicio);
            
        } catch (\Exception $e) {
            \Log::error('Error en calcularMinutosDiferencia', [
                'error' => $e->getMessage()
            ]);
            return 0;
        }
    }

    public function getBadgeColorAttribute()
    {
        return match($this->estado) {
            'A tiempo' => 'success',
            'Tardanza' => 'warning',
            'Falta' => 'danger',
            default => 'secondary'
        };
    }

    public function getLlegadaFormateadaAttribute()
    {
        if (!$this->hora_llegada) {
            return 'Sin registro';
        }
        
        return $this->fecha->format('d/m/Y') . ' ' . 
               Carbon::parse($this->hora_llegada)->format('H:i');
    }
}