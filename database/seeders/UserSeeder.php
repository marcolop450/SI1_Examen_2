<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->truncate();
        
        DB::table('users')->insert([
            [
                'nombre' => 'Administrador',
                'apellido' => 'Sistema',
                'telefono' => '70000000',
                'ci' => 12345678,
                'sexo' => 'M',
                'correo' => 'admin@ficct.edu.bo',
                'domicilio' => 'FICCT - UAGRM',
                'username' => 'admin',
                'password' => Hash::make('admin123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Juan',
                'apellido' => 'Pérez',
                'telefono' => '77777777',
                'ci' => 87654321,
                'sexo' => 'M',
                'correo' => 'juan.perez@ficct.edu.bo',
                'domicilio' => 'Santa Cruz',
                'username' => 'jperez',
                'password' => Hash::make('docente123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'María',
                'apellido' => 'González',
                'telefono' => '76666666',
                'ci' => 11223344,
                'sexo' => 'F',
                'correo' => 'maria.gonzalez@ficct.edu.bo',
                'domicilio' => 'Santa Cruz',
                'username' => 'mgonzalez',
                'password' => Hash::make('autoridad123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::statement("SELECT setval(pg_get_serial_sequence('users', 'id'), (SELECT MAX(id) FROM users))");
    }
}
