<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Horario extends Model
{
    use HasFactory;

    protected $fillable = [
        'dia',
        'hora_inicio',
        'hora_final',
        'gestion',
        'activo',
        'observaciones',
        'es_virtual',
        'id_docente',
        'id_materia',
        'id_grupo',
        'id_aula',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'es_virtual' => 'boolean',
            'hora_inicio' => 'datetime:H:i',
            'hora_final' => 'datetime:H:i',
        ];
    }

    //Relaciones
    public function docente()
    {
        return $this->belongsTo(Docente::class, 'id_docente', 'registro');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'id_materia');
    }

    public function grupo()
    {
        return $this->belongsTo(Grupo::class, 'id_grupo');
    }

    public function aula()
    {
        return $this->belongsTo(Aula::class, 'id_aula');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_horario');
    }

    //Scopes útiles
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }

    public function scopeVirtuales($query)
    {
        return $query->where('es_virtual', true);
    }

    public function scopePresenciales($query)
    {
        return $query->where('es_virtual', false);
    }

    public function scopePorGestion($query, $gestion)
    {
        return $query->where('gestion', $gestion);
    }
}
