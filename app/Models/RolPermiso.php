<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class RolPermiso extends Pivot
{
    protected $table = 'rol_permisos';
    public $incrementing = false;
    protected $primaryKey = ['id_rol', 'id_permiso'];

    protected $fillable = [
        'id_rol',
        'id_permiso',
        'fecha_asignacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_asignacion' => 'datetime',
        ];
    }
}