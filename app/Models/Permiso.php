<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permiso extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_creacion',
    ];

    protected function casts(): array
    {
        return [
            'fecha_creacion' => 'datetime',
        ];
    }

    //Relaciones
    public function roles()
    {
        return $this->belongsToMany(Rol::class, 'rol_permisos', 'id_permiso', 'id_rol')
                    ->withPivot('fecha_asignacion');
                    // SIN ->withTimestamps()
    }
}