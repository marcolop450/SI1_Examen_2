<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DocenteSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'nombre' => 'Marco',
                'apellido' => 'Alejandro',
                'telefono' => '75555555',
                'ci' => 22334455,
                'sexo' => 'M',
                'correo' => 'kakislop54@gmail.com',
                'domicilio' => 'Santa Cruz',
                'username' => 'MalAle',
                'password' => Hash::make('docente123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Ana',
                'apellido' => 'Martínez',
                'telefono' => '74444444',
                'ci' => 33445566,
                'sexo' => 'F',
                'correo' => 'ana.martinez@ficct.edu.bo',
                'domicilio' => 'Santa Cruz',
                'username' => 'amartinez',
                'password' => Hash::make('docente123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 2, // Docente
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Luis',
                'apellido' => 'Fernández',
                'telefono' => '73333333',
                'ci' => 44556677,
                'sexo' => 'M',
                'correo' => 'luis.fernandez@ficct.edu.bo',
                'domicilio' => 'Santa Cruz',
                'username' => 'lfernandez',
                'password' => Hash::make('docente123'),
                'activo' => true,
                'ultimo_acceso' => null,
                'id_rol' => 2, // Docente
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);

        DB::table('docentes')->insert([
            [
                'registro' => 28079,
                'carrera' => 'Ingeniería de Sistemas',
                'fecha_ingreso' => '2020-01-15',
                'especialidad' => 'Sistemas de Información',
                'carga_horaria_maxima' => 80, 
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => 2, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registro' => 28080,
                'carrera' => 'Ingeniería de Sistemas',
                'fecha_ingreso' => '2019-03-10',
                'especialidad' => 'Programación',
                'carga_horaria_maxima' => 80,
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => 4, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registro' => 28081,
                'carrera' => 'Ingeniería de Sistemas',
                'fecha_ingreso' => '2021-08-20',
                'especialidad' => 'Base de Datos',
                'carga_horaria_maxima' => 80,
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => 5, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'registro' => 28082,
                'carrera' => 'Ingeniería de Sistemas',
                'fecha_ingreso' => '2018-02-05',
                'especialidad' => 'Redes',
                'carga_horaria_maxima' => 80,
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => 6, 
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}