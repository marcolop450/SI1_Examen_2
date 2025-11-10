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
                'nombre' => 'Aula 31',
                'tipo' => 'Aula Tradicional',
                'capacidad' => 40,
                'piso' => 'Piso 3',
                'equipamiento' => 'Pizarra, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aula 22',
                'tipo' => 'Aula Tradicional',
                'capacidad' => 70,
                'piso' => 'Piso 2',
                'equipamiento' => 'Proyector, Pizarra, , Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aula 13',
                'tipo' => 'Aula Tradicional',
                'capacidad' => 80,
                'piso' => 'Piso 1',
                'equipamiento' => 'Proyector, Pizarra, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Aula 40',
                'tipo' => 'Auditorio',
                'capacidad' => 120,
                'piso' => 'Piso 4',
                'equipamiento' => 'Proyector, Pizarra',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'nombre' => 'Lab 41',
                'tipo' => 'Laboratorio',
                'capacidad' => 60,
                'piso' => 'Piso 4',
                'equipamiento' => '50 Computadoras, Proyector, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lab 45',
                'tipo' => 'Laboratorio',
                'capacidad' => 60,
                'piso' => 'Piso 4',
                'equipamiento' => '50 Computadoras, Proyector',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Lab 43',
                'tipo' => 'Laboratorio',
                'capacidad' => 28,
                'piso' => 'Piso 4',
                'equipamiento' => '28 Computadoras, Proyector, Aire Acondicionado',
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}