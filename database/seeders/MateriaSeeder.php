<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MateriaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('materias')->insert([
            [
                'nombre' => 'Sistemas de Información I',
                'codigo' => 'SI1',
                'contenido' => 'Introducción a los sistemas de información',
                'semestre' => 5,
                'horas_teoricas' => 4,
                'horas_practicas' => 2,
                'creditos' => 6,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Programación I',
                'codigo' => 'PRG1',
                'contenido' => 'Fundamentos de programación',
                'semestre' => 1,
                'horas_teoricas' => 3,
                'horas_practicas' => 3,
                'creditos' => 5,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Base de Datos I',
                'codigo' => 'BD1',
                'contenido' => 'Diseño y modelado de bases de datos',
                'semestre' => 3,
                'horas_teoricas' => 4,
                'horas_practicas' => 2,
                'creditos' => 6,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}