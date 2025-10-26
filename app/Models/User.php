<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'users';

    protected $fillable = [
        'nombre',
        'apellido',
        'telefono',
        'ci',
        'sexo',
        'correo',
        'domicilio',
        'username',
        'password',
        'activo',
        'ultimo_acceso',
        'id_rol',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'activo' => 'boolean',
            'ultimo_acceso' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function username()
    {
        return 'username'; 
    }

    //Relaciones
    public function rol()
    {
        return $this->belongsTo(Rol::class, 'id_rol');
    }

    public function docente()
    {
        return $this->hasOne(Docente::class, 'id_usuario');
    }

    public function bitacoras()
    {
        return $this->hasMany(Bitacora::class, 'id_usuario');
    }

    public function getEmailForPasswordReset()
    {
        return $this->correo;
    }
}