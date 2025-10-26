<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GrupoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('grupos')->insert([
            [
                'nombre' => 'SA',
                'turno' => 'Mañana',
                'capacidad_maxima' => 35,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'SB',
                'turno' => 'Tarde',
                'capacidad_maxima' => 35,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'I1',
                'turno' => 'Mañana',
                'capacidad_maxima' => 40,
                'activo' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}