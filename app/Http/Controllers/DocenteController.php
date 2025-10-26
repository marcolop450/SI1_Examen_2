<?php

namespace App\Http\Controllers;

use App\Models\Docente;
use App\Models\User;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DocenteController extends Controller
{
    //Listar todos los docentes
    public function index()
    {
        $docentes = Docente::with('usuario')->where('activo', true)->get();
        return view('docentes.index', compact('docentes'));
    }

    //Mostrar formulario de crear
    public function create()
    {
        return view('docentes.create');
    }

    //Guardar nuevo docente
    public function store(Request $request)
    {
        $request->validate([
            'registro' => 'required|integer|unique:docentes,registro',
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'ci' => 'required|integer|unique:users,ci',
            'correo' => 'required|email|unique:users,correo',
            'telefono' => 'nullable|string|max:20',
            'sexo' => 'required|in:M,F',
            'carrera' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'fecha_ingreso' => 'required|date',
            'carga_horaria_maxima' => 'required|integer|min:1|max:80',
        ]);

        DB::beginTransaction();
        try {
            $nextId = DB::table('users')->max('id') + 1;
            DB::statement("ALTER SEQUENCE users_id_seq RESTART WITH $nextId");
            $user = User::create([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'ci' => $request->ci,
                'correo' => $request->correo,
                'telefono' => $request->telefono,
                'sexo' => $request->sexo,
                'username' => strtolower(substr($request->nombre, 0, 1) . $request->apellido),
                'password' => Hash::make('123456'), //Todo usuario que se cree, Tendra esta contraseña temporal
                'activo' => true,
                'id_rol' => 2, 
            ]);

            $docente = Docente::create([
                'registro' => $request->registro,
                'carrera' => $request->carrera,
                'especialidad' => $request->especialidad,
                'fecha_ingreso' => $request->fecha_ingreso,
                'carga_horaria_maxima' => $request->carga_horaria_maxima,
                'carga_horaria_actual' => 0,
                'activo' => true,
                'id_usuario' => $user->id,
            ]);

            Bitacora::create([
                'accion' => 'Crear Docente',
                'descripcion' => "Se creó el docente: {$request->nombre} {$request->apellido} (Registro: {$request->registro})",
                'tabla_afectada' => 'docentes',
                'registro_afectado' => $request->registro,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente creado exitosamente. Usuario: ' . $user->username . ' | Contraseña: 123456');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear docente: ' . $e->getMessage())->withInput();
        }
    }

    //Mostrar
    public function show(string $registro)
    {
        $docente = Docente::with('usuario')->findOrFail($registro);
        return view('docentes.show', compact('docente'));
    }

    public function edit(string $registro)
    {
        $docente = Docente::with('usuario')->findOrFail($registro);
        return view('docentes.edit', compact('docente'));
    }

    public function update(Request $request, string $registro)
    {
        $docente = Docente::findOrFail($registro);
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'apellido' => 'required|string|max:100',
            'telefono' => 'nullable|string|max:20',
            'carrera' => 'nullable|string|max:100',
            'especialidad' => 'nullable|string|max:100',
            'carga_horaria_maxima' => 'required|integer|min:1|max:80',
        ]);

        DB::beginTransaction();
        try {
            $docente->usuario->update([
                'nombre' => $request->nombre,
                'apellido' => $request->apellido,
                'telefono' => $request->telefono,
            ]);

            $docente->update([
                'carrera' => $request->carrera,
                'especialidad' => $request->especialidad,
                'carga_horaria_maxima' => $request->carga_horaria_maxima,
            ]);

            Bitacora::create([
                'accion' => 'Actualizar Docente',
                'descripcion' => "Se actualizó el docente: {$request->nombre} {$request->apellido} (Registro: {$registro})",
                'tabla_afectada' => 'docentes',
                'registro_afectado' => $registro,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar docente: ' . $e->getMessage());
        }
    }

    //Desactivar docente
    public function destroy(string $registro)
    {
        $docente = Docente::findOrFail($registro);

        if ($docente->horarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar el docente porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $docente->update(['activo' => false]);
            $docente->usuario->update(['activo' => false]);

            Bitacora::create([
                'accion' => 'Desactivar Docente',
                'descripcion' => "Se desactivo el docente: {$docente->usuario->nombre} {$docente->usuario->apellido} (Registro: {$registro})",
                'tabla_afectada' => 'docentes',
                'registro_afectado' => $registro,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('docentes.index')
                ->with('success', 'Docente desactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar docente: ' . $e->getMessage());
        }
    }
    public function inactivos()
    {
        $docentes = Docente::with('usuario')->where('activo', false)->get();
        return view('docentes.inactivos', compact('docentes'));
    }

    public function reactivar(string $registro)
    {
        $docente = Docente::findOrFail($registro);

        if ($docente->activo) {
            return back()->with('error', 'El docente ya está activo.');
        }

        DB::beginTransaction();
        try {
            $docente->update(['activo' => true]);
            $docente->usuario->update(['activo' => true]);

            Bitacora::create([
                'accion' => 'Reactivar Docente',
                'descripcion' => "Se reactivó el docente: {$docente->usuario->nombre} {$docente->usuario->apellido} (Registro: {$registro})",
                'tabla_afectada' => 'docentes',
                'registro_afectado' => $registro,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('docentes.inactivos')
                ->with('success', 'Docente reactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar docente: ' . $e->getMessage());
        }
    }

    //Eliminar permanentemente
    public function forceDestroy(string $registro)
    {
        $docente = Docente::findOrFail($registro);

        if ($docente->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente docentes inactivos.');
        }

        if ($docente->horarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $nombre = $docente->usuario->nombre . ' ' . $docente->usuario->apellido;
            
            $docente->usuario->delete();
            $docente->delete();

            Bitacora::create([
                'accion' => 'Eliminar Docente Permanentemente',
                'descripcion' => "Se eliminó permanentemente el docente: {$nombre} (Registro: {$registro})",
                'tabla_afectada' => 'docentes',
                'registro_afectado' => $registro,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('docentes.inactivos')
                ->with('success', 'Docente eliminado permanentemente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar docente: ' . $e->getMessage());
        }
    }
}