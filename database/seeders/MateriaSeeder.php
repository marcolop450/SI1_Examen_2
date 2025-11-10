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
                'es_electiva' => false,
                'horas_semanales' => 270, 
                'dias_semana' => 2, 
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
                'es_electiva' => false,
                'horas_semanales' => 270, 
                'dias_semana' => 3,
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
                'es_electiva' => false,
                'horas_semanales' => 270, 
                'dias_semana' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Redes 1',
                'codigo' => 'RED1',
                'contenido' => 'Fundamentos de redes y protocolos',
                'semestre' => 4,
                'horas_teoricas' => 3,
                'horas_practicas' => 3,
                'creditos' => 5,
                'activo' => true,
                'es_electiva' => false,
                'horas_semanales' => 270, // 4h 30min
                'dias_semana' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
            [
                'nombre' => 'Programacion Grafica',
                'codigo' => 'ELEC104',
                'contenido' => 'Programacion a nivel grafico',
                'semestre' => 8,
                'horas_teoricas' => 2,
                'horas_practicas' => 2,
                'creditos' => 4,
                'activo' => true,
                'es_electiva' => true, 
                'horas_semanales' => 180, 
                'dias_semana' => 1, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Criptografia',
                'codigo' => 'ELEC108',
                'contenido' => 'Seguridad informática',
                'semestre' => 9,
                'horas_teoricas' => 2,
                'horas_practicas' => 1,
                'creditos' => 3,
                'activo' => true,
                'es_electiva' => true, 
                'horas_semanales' => 180, 
                'dias_semana' => 3, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}