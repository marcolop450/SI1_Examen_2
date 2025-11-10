<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Docente extends Model
{
    use HasFactory;

    protected $primaryKey = 'registro';
    public $incrementing = false;
    protected $keyType = 'integer';

    protected $fillable = [
        'registro',
        'carrera',
        'fecha_ingreso',
        'especialidad',
        'carga_horaria_maxima',  // En HORAS ACADÉMICAS
        'carga_horaria_actual',  // En HORAS ACADÉMICAS
        'activo',
        'id_usuario',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'activo' => 'boolean',
            // CAMBIO: Usar integer en lugar de decimal para coincidir con la BD
            'carga_horaria_maxima' => 'integer',
            'carga_horaria_actual' => 'integer',
        ];
    }

    /**
     * ACCESSORS - Información de carga horaria
     */
    
    /**
     * Obtiene el porcentaje de carga horaria utilizada
     */
    public function getPorcentajeCargaAttribute()
    {
        if ($this->carga_horaria_maxima == 0) {
            return 0;
        }
        return round(($this->carga_horaria_actual / $this->carga_horaria_maxima) * 100, 2);
    }

    /**
     * Obtiene las horas disponibles
     */
    public function getHorasDisponiblesAttribute()
    {
        return $this->carga_horaria_maxima - $this->carga_horaria_actual;
    }

    /**
     * Formatea la carga horaria para mostrar en vistas
     * Ejemplo: "6/80 hrs académicas"
     */
    public function getCargaHorariaFormateadaAttribute()
    {
        return "{$this->carga_horaria_actual}/{$this->carga_horaria_maxima} hrs académicas";
    }

    /**
     * Versión simple para select
     * Ejemplo: "6/80 hrs"
     */
    public function getCargaHorariaSimpleAttribute()
    {
        return "{$this->carga_horaria_actual}/{$this->carga_horaria_maxima} hrs";
    }

    /**
     * Badge con color según porcentaje
     */
    public function getCargaColorAttribute()
    {
        $porcentaje = $this->porcentaje_carga;
        
        if ($porcentaje >= 90) {
            return 'red';
        } elseif ($porcentaje >= 70) {
            return 'yellow';
        } else {
            return 'green';
        }
    }

    //Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }

    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'docente_materias', 'id_docente', 'id_materia')
                    ->withPivot('puede_impartir', 'fecha_asignacion')
                    ->withTimestamps();
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_docente', 'registro');
    }

    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_docente', 'registro');
    }

    /**
     * Scope para docentes con carga disponible (en horas académicas)
     */
    public function scopeConCargaDisponible($query, $horasRequeridas)
    {
        return $query->whereRaw('carga_horaria_maxima - carga_horaria_actual >= ?', [$horasRequeridas]);
    }

    /**
     * Scope para docentes activos
     */
    public function scopeActivos($query)
    {
        return $query->where('activo', true);
    }
}