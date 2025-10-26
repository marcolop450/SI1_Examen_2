<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermisoSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('permisos')->insert([
            ['nombre' => 'gestionar_horarios', 'descripcion' => 'Crear, editar y eliminar horarios', 'fecha_creacion' => now()],
            ['nombre' => 'gestionar_docentes', 'descripcion' => 'Administrar información de docentes', 'fecha_creacion' => now()],
            ['nombre' => 'gestionar_materias', 'descripcion' => 'Administrar materias', 'fecha_creacion' => now()],
            ['nombre' => 'gestionar_aulas', 'descripcion' => 'Administrar aulas', 'fecha_creacion' => now()],
            ['nombre' => 'ver_reportes', 'descripcion' => 'Acceso a reportes y estadísticas', 'fecha_creacion' => now()],
            ['nombre' => 'registrar_asistencia', 'descripcion' => 'Registrar asistencia propia', 'fecha_creacion' => now()],
            ['nombre' => 'ver_horario_propio', 'descripcion' => 'Ver horario asignado', 'fecha_creacion' => now()],
        ]);

        DB::table('rol_permisos')->insert([
            //Coordinador, Todos los permisos
            ['id_rol' => 1, 'id_permiso' => 1, 'fecha_asignacion' => now()],
            ['id_rol' => 1, 'id_permiso' => 2, 'fecha_asignacion' => now()],
            ['id_rol' => 1, 'id_permiso' => 3, 'fecha_asignacion' => now()],
            ['id_rol' => 1, 'id_permiso' => 4, 'fecha_asignacion' => now()],
            ['id_rol' => 1, 'id_permiso' => 5, 'fecha_asignacion' => now()],
            
            // Docente, Permisos limitados
            ['id_rol' => 2, 'id_permiso' => 6, 'fecha_asignacion' => now()],
            ['id_rol' => 2, 'id_permiso' => 7, 'fecha_asignacion' => now()],
            
            // Autoridad, Solo reportes
            ['id_rol' => 3, 'id_permiso' => 5, 'fecha_asignacion' => now()],
        ]);
    }
}