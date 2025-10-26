<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Rol;
use App\Models\Docente;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel; //Para importar en el excel
use App\Imports\UsersImport;

class UserController extends Controller
{
    //Listar usuarios
    public function index()
    {
        $usuarios = User::with('rol')->where('activo', true)->orderBy('nombre')->get();
        return view('usuarios.index', compact('usuarios'));
    }

    //Formulario crear usuario
    public function create()
    {
        $roles = Rol::all();
        return view('usuarios.create', compact('roles'));
    }

    //Guardar usuario individual
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|integer|unique:users,ci',
            'correo' => 'required|email|unique:users,correo',
            'telefono' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F',
            'domicilio' => 'nullable|string|max:200',
            'username' => 'required|string|max:50|unique:users,username',
            'password' => 'required|string|min:6',
            'id_rol' => 'required|exists:rols,id',
            //Campos adicionales para docente
            'registro' => 'required_if:crear_docente,true|nullable|integer|unique:docentes,registro',
            'carrera' => 'required_if:crear_docente,true|nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'fecha_ingreso' => 'required_if:crear_docente,true|nullable|date',
            'carga_horaria_maxima' => 'required_if:crear_docente,true|nullable|integer|min:1|max:80',
        ]);

        DB::beginTransaction();
        try {
            //Obtener el siguiente ID disponible. Eje : (5) -> (6)
            $nextId = DB::table('users')->max('id') + 1;
            DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH $nextId");

            $user = User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'ci' => $request->ci,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'sexo' => $request->sexo,
                'domicilio' => $request->domicilio,
                'username' => $request->username,
                'password' => Hash::make($request->password),
                'activo' => true,
                'id_rol' => $request->id_rol,
            ]);

            //Verificar si el rol seleccionado es Docente
            $rol = Rol::find($request->id_rol);
            
            if ($rol && strtolower($rol->nombre) === 'docente') {
                //Crear registro en tabla docente automáticamente
                $registro = $request->registro ?? rand(10000, 99999);
                
                Docente::create([
                    'registro' => $registro,
                    'carrera' => $request->carrera ?? 'Ingeniería de Sistemas',
                    'especialidad' => $request->especialidad ?? 'Programación',
                    'fecha_ingreso' => $request->fecha_ingreso ?? now(),
                    'carga_horaria_maxima' => $request->carga_horaria_maxima ?? 40,
                    'carga_horaria_actual' => 0,
                    'activo' => true,
                    'id_usuario' => $user->id,
                ]);

                $descripcion = "Se creó el usuario docente: {$request->username} ({$request->nombre} {$request->apellido}) - Registro: {$registro}";
            } else {
                $descripcion = "Se creó el usuario: {$request->username} ({$request->nombre} {$request->apellido})";
            }

            Bitacora::create([
                'accion' => 'Crear Usuario',
                'descripcion' => $descripcion,
                'tabla_afectada' => 'users',
                'registro_afectado' => $user->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'Usuario creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear usuario: ' . $e->getMessage())->withInput();
        }
    }

    //Ver usuario
    public function show(string $id)
    {
        $usuario = User::with('rol')->findOrFail($id);
        return view('usuarios.show', compact('usuario'));
    }

    //Formulario editar
    public function edit(string $id)
    {
        $usuario = User::findOrFail($id);
        $roles = Rol::all();
        return view('usuarios.edit', compact('usuario', 'roles'));
    }

    //Actualizar usuario
    public function update(Request $request, string $id)
    {
        $usuario = User::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|integer|unique:users,ci,' . $id,
            'correo' => 'required|email|unique:users,correo,' . $id,
            'telefono' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F',
            'domicilio' => 'nullable|string|max:200',
            'username' => 'required|string|max:50|unique:users,username,' . $id,
            'password' => 'nullable|string|min:6',
            'id_rol' => 'required|exists:rols,id',
        ]);

        DB::beginTransaction();
        try {
            $data = [
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'ci' => $request->ci,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'sexo' => $request->sexo,
                'domicilio' => $request->domicilio,
                'username' => $request->username,
                'id_rol' => $request->id_rol,
            ];

            //solo actualizar password si se proporcionó uno nuevo
            if ($request->filled('password')) {
                $data['password'] = Hash::make($request->password);
            }

            $usuario->update($data);

            Bitacora::create([
                'accion' => 'Actualizar Usuario',
                'descripcion' => "Se actualizó el usuario: {$request->username}",
                'tabla_afectada' => 'users',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'Usuario actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar usuario: ' . $e->getMessage());
        }
    }

    // Desactivar usuario
    public function destroy(string $id)
    {
        $usuario = User::findOrFail($id);

        // No permitir desactivar al usuario actual
        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes desactivar tu propia cuenta.');
        }

        DB::beginTransaction();
        try {
            $usuario->update(['activo' => false]);

            //Docente, también desactivar el registro de docente
            if ($usuario->docente) {
                $usuario->docente->update(['activo' => false]);
            }

            Bitacora::create([
                'accion' => 'Desactivar Usuario',
                'descripcion' => "Se desactivo el usuario: {$usuario->username}",
                'tabla_afectada' => 'users',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('usuarios.index')->with('success', 'Usuario desactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar usuario: ' . $e->getMessage());
        }
    }

    //Mostrar formulario de carga masiva
    public function importForm()
    {
        return view('usuarios.import');
    }

    //Procesar carga masiva Excel/CSV
    public function import(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:xlsx,xls,csv|max:5120', // Max 5MB
        ]);

        DB::beginTransaction();
        try {
            $file = $request->file('archivo');
            
            $import = new UsersImport();
            Excel::import($import, $file);

            $resultados = $import->getResultados();

            Bitacora::create([
                'accion' => 'Carga Masiva de Usuarios',
                'descripcion' => "Se importaron {$resultados['exitosos']} usuarios. Errores: {$resultados['errores']}",
                'tabla_afectada' => 'users',
                'registro_afectado' => null,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('usuarios.index')
                ->with('success', "Importación completada. Exitosos: {$resultados['exitosos']}, Errores: {$resultados['errores']}")
                ->with('detalles', $resultados['detalles']);

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al importar archivo: ' . $e->getMessage());
        }
    }

    //plantilla Excel
    public function downloadTemplate()
    {
        $filename = 'plantilla_usuarios.xlsx';
        $headers = [
            'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();
        
        $sheet->setCellValue('A1', 'nombre');
        $sheet->setCellValue('B1', 'apellido');
        $sheet->setCellValue('C1', 'ci');
        $sheet->setCellValue('D1', 'correo');
        $sheet->setCellValue('E1', 'telefono');
        $sheet->setCellValue('F1', 'sexo');
        $sheet->setCellValue('G1', 'rol');
        $sheet->setCellValue('H1', 'registro');
        $sheet->setCellValue('I1', 'carrera');
        $sheet->setCellValue('J1', 'especialidad');
        $sheet->setCellValue('K1', 'fecha_ingreso');
        $sheet->setCellValue('L1', 'carga_horaria_maxima');
        
        //Ejemplo por defecto
        $sheet->setCellValue('A2', 'Marco');
        $sheet->setCellValue('B2', 'Lopez');
        $sheet->setCellValue('C2', '12345678');
        $sheet->setCellValue('D2', 'MarLop@ejemplo.com');
        $sheet->setCellValue('E2', '70123456');
        $sheet->setCellValue('F2', 'M');
        $sheet->setCellValue('G2', 'Docente');
        $sheet->setCellValue('H2', '28079');
        $sheet->setCellValue('I2', 'Ingeniería de Sistemas');
        $sheet->setCellValue('J2', 'Programación');
        $sheet->setCellValue('K2', '2024-01-15');
        $sheet->setCellValue('L2', '40');

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        
        return response()->streamDownload(function() use ($writer) {
            $writer->save('php://output');
        }, $filename, $headers);
    }
    public function inactivos()
    {
        $usuarios = User::with('rol')->where('activo', false)->orderBy('nombre')->get();
        return view('usuarios.inactivos', compact('usuarios'));
    }

    public function reactivar(string $id)
    {
        $usuario = User::findOrFail($id);

        if ($usuario->activo) {
            return back()->with('error', 'El usuario ya está activo.');
        }

        DB::beginTransaction();
        try {
            $usuario->update(['activo' => true]);

            //Docente, también reactivar el registro de docente
            if ($usuario->docente) {
                $usuario->docente->update(['activo' => true]);
            }

            Bitacora::create([
                'accion' => 'Reactivar Usuario',
                'descripcion' => "Se reactivó el usuario: {$usuario->username}",
                'tabla_afectada' => 'users',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('usuarios.inactivos')
                ->with('success', 'Usuario reactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar usuario: ' . $e->getMessage());
        }
    }

    //Eliminar permanentemente usuario
    public function forceDestroy(string $id)
    {
        $usuario = User::findOrFail($id);

        //No permitir eliminar al usuario actual
        if ($usuario->id == auth()->id()) {
            return back()->with('error', 'No puedes eliminar tu propia cuenta.');
        }

        //Solo permitir eliminar usuarios inactivos
        if ($usuario->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente usuarios inactivos. Desactívalo primero.');
        }

        DB::beginTransaction();
        try {
            $username = $usuario->username;

            //Eliminar docente si existe
            if ($usuario->docente) {
                $usuario->docente->delete();
            }

            $usuario->delete();

            Bitacora::create([
                'accion' => 'Eliminar Usuario Permanentemente',
                'descripcion' => "Se eliminó permanentemente el usuario: {$username}",
                'tabla_afectada' => 'users',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('usuarios.inactivos')
                ->with('success', 'Usuario eliminado permanentemente de la base de datos.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar usuario: ' . $e->getMessage());
        }
    }
}