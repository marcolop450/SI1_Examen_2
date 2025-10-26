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
        'carga_horaria_maxima',
        'carga_horaria_actual',
        'activo',
        'id_usuario',
    ];

    protected function casts(): array
    {
        return [
            'fecha_ingreso' => 'date',
            'activo' => 'boolean',
            'carga_horaria_maxima' => 'integer',
            'carga_horaria_actual' => 'integer',
        ];
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
}