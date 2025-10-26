<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Aula extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'capacidad',
        'piso',
        'equipamiento',
        'activo',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'capacidad' => 'integer',
        ];
    }

    //Relaciones
    public function horarios()
    {
        return $this->hasMany(Horario::class, 'id_aula');
    }
}