<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class DocenteMateria extends Pivot
{
    protected $table = 'docente_materias';

    protected $fillable = [
        'id_docente',
        'id_materia',
        'puede_impartir',
        'fecha_asignacion',
    ];

    protected function casts(): array
    {
        return [
            'puede_impartir' => 'boolean',
            'fecha_asignacion' => 'datetime',
        ];
    }
}
