<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'codigo',
        'contenido',
        'semestre',
        'horas_teoricas',
        'horas_practicas',
        'creditos',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'semestre' => 'integer',
            'horas_teoricas' => 'integer',
            'horas_practicas' => 'integer',
            'creditos' => 'integer',
        ];
    }

    //Relaciones
    public function docentes()
    {
        return $this->belongsToMany(Docente::class, 'docente_materias', 'id_materia', 'id_docente')
                    ->withPivot('puede_impartir', 'fecha_asignacion')
                    ->withTimestamps();
    }

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_materias', 'id_materia', 'id_grupo')
                    ->withPivot('gestion', 'activo')
                    ->withTimestamps();
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_materia');
    }
}