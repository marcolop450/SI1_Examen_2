<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Grupo extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'turno',
        'capacidad_maxima',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'capacidad_maxima' => 'integer',
        ];
    }

    //Relaciones
    public function materias()
    {
        return $this->belongsToMany(Materia::class, 'grupo_materias', 'id_grupo', 'id_materia')
                    ->withPivot('gestion', 'activo')
                    ->withTimestamps();
    }

    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_grupo');
    }
}