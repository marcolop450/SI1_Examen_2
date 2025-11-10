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

    // Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'registro');
    }

    public function horario()
    {
        return $this->belongsTo(Horario::class, 'id_horario');
    }

    // Scopes útiles
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

    /**
     * Calcula el estado de asistencia basado en la hora de llegada
     * 
     * Reglas:
     * - A tiempo: Llega antes o hasta 5 minutos después del inicio
     * - Tardanza: Llega entre 6 y 20 minutos después del inicio  
     * - Falta: Llega más de 20 minutos después
     */
    public static function calcularEstado($horaLlegada, $horaInicio)
    {
        $llegada = Carbon::parse($horaLlegada);
        $inicio = Carbon::parse($horaInicio);
        
        // CORRECCIÓN: Usar diffInMinutes con false para obtener valor con signo
        // Negativo = llegada ANTES del inicio
        // Positivo = llegada DESPUÉS del inicio
        $minutosDiferencia = $inicio->diffInMinutes($llegada, false);
        
        // Si llegó ANTES de la hora de inicio (diferencia negativa)
        if ($minutosDiferencia < 0) {
            return 'A tiempo';
        }
        
        // Si llegó hasta 5 minutos DESPUÉS del inicio
        if ($minutosDiferencia <= 5) {
            return 'A tiempo';
        }
        
        // Entre 6 y 20 minutos después = Tardanza
        if ($minutosDiferencia <= 20) {
            return 'Tardanza';
        }
        
        // Más de 20 minutos después = Falta
        return 'Falta';
    }

    /**
     * Verifica si el registro está dentro del rango permitido
     * Rango: 10 minutos antes hasta 20 minutos después del inicio
     */
    public static function estaDentroDeRango($horaActual, $horaInicio)
    {
        $actual = Carbon::parse($horaActual);
        $inicio = Carbon::parse($horaInicio);
        
        // CORRECCIÓN: Calcular diferencia con signo correcto
        // Negativo = actual está ANTES del inicio
        // Positivo = actual está DESPUÉS del inicio
        $diferenciaMinutos = $inicio->diffInMinutes($actual, false);
        
        // Puede registrar desde 10 minutos antes (diferencia negativa hasta -10)
        // hasta 20 minutos después (diferencia positiva hasta 20)
        return $diferenciaMinutos >= -10 && $diferenciaMinutos <= 20;
    }

    /**
     * Obtiene el badge de color según el estado
     */
    public function getBadgeColorAttribute()
    {
        return match($this->estado) {
            'A tiempo' => 'success',
            'Tardanza' => 'warning',
            'Falta' => 'danger',
            default => 'secondary'
        };
    }

    /**
     * Formatea la fecha y hora de llegada
     */
    public function getLlegadaFormateadaAttribute()
    {
        return $this->fecha->format('d/m/Y') . ' ' . 
               Carbon::parse($this->hora_llegada)->format('H:i');
    }
}