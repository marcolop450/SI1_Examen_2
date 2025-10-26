<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha',
        'hora_llegada',
        'hora_salida',
        'estado',
        'metodo_registro',
        'observaciones',
        'justificada',
        'id_docente',
        'id_horario',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'date',
            'hora_llegada' => 'datetime:H:i',
            'hora_salida' => 'datetime:H:i',
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

    //Scopes útiles
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
}