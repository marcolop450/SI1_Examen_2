<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class GrupoMateria extends Pivot
{
    protected $table = 'grupo_materias';

    protected $fillable = [
        'id_grupo',
        'id_materia',
        'gestion',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
        ];
    }
}