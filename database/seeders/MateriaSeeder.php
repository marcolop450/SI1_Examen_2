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
                'codigo' => 'SIS-101',
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
                'codigo' => 'PRG-101',
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
                'codigo' => 'BDD-101',
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