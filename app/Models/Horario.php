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

    //Scopes
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

    /**
     * Obtiene la hora de inicio en formato H:i
     */
    public function getHoraInicioFormateadaAttribute()
    {
        return substr($this->hora_inicio, 0, 5);
    }

    /**
     * Obtiene la hora final en formato H:i
     */
    public function getHoraFinalFormateadaAttribute()
    {
        return substr($this->hora_final, 0, 5);
    }
}