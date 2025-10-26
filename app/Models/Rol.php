<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rol extends Model
{
    use HasFactory;

    protected $table = 'rols';
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
    public function usuarios()
    {
        return $this->hasMany(User::class, 'id_rol');
    }

    public function permisos()
    {
        return $this->belongsToMany(Permiso::class, 'rol_permisos', 'id_rol', 'id_permiso')
                    ->withPivot('fecha_asignacion');
    }
}