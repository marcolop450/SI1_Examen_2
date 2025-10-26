<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Ejecutar seeders en orden de dependencias
        $this->call([
            RolSeeder::class,        // 1. Primero roles
            PermisoSeeder::class,    // 2. Permisos y asignaciones
            UserSeeder::class,       // 3. Usuarios (necesita roles)
            DocenteSeeder::class,    // 4. Docentes (necesita usuarios)
            MateriaSeeder::class,    // 5. Materias
            GrupoSeeder::class,      // 6. Grupos
            AulaSeeder::class,       // 7. Aulas
        ]);
    }
}