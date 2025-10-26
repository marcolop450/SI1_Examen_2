<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AulaSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('aulas')->insert([
            [
                'nombre' => 'Aula 301',
                'tipo' => 'Aula Tradicional',
                'capacidad' => 40,
                'piso' => 'Piso 3',
                'equipamiento' => 'Proyector, Pizarra, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lab 1',
                'tipo' => 'Laboratorio',
                'capacidad' => 30,
                'piso' => 'Piso 2',
                'equipamiento' => '30 Computadoras, Proyector, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Auditorio Principal',
                'tipo' => 'Auditorio',
                'capacidad' => 150,
                'piso' => 'Planta Baja',
                'equipamiento' => 'Sistema de Audio, Proyector, Pantalla Grande',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}