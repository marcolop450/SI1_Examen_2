<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('rols')->insert([
            [
                'nombre' => 'Coordinador',
                'descripcion' => 'Administrador del sistema, gestiona horarios y asignaciones',
                'fecha_creacion' => now(),
            ],
            [
                'nombre' => 'Docente',
                'descripcion' => 'Profesor que imparte clases y registra asistencia',
                'fecha_creacion' => now(),
            ],
            [
                'nombre' => 'Autoridad',
                'descripcion' => 'Autoridad académica con acceso a reportes',
                'fecha_creacion' => now(),
            ],
        ]);
    }
}