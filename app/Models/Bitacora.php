<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bitacora extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'accion',
        'descripcion',
        'tabla_afectada',
        'registro_afectado',
        'ip_direccion',
        'id_usuario',
        'fecha',
    ];

    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    //Relaciones
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario');
    }
}