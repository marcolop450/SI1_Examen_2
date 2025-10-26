<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('docentes')->insert([
            [
                'registro' => 28079,
                'carrera' => 'Ingeniería de Sistemas',
                'fecha_ingreso' => '2020-01-15',
                'especialidad' => 'Programación',
                'carga_horaria_maxima' => 80,
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}