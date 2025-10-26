<?php

namespace App\Http\Controllers;

use App\Models\Rol;
use App\Models\Permiso;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RolController extends Controller
{
    //Listar Roles
    public function index()
    {
        $roles = Rol::with('permisos')->get();
        return view('roles.index', compact('roles'));
    }

    public function create()
    {
        $permisos = Permiso::all();
        return view('roles.create', compact('permisos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:rols,nombre',
            'descripcion' => 'nullable|string|max:200',
            'permisos' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $rol = Rol::create([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            if ($request->has('permisos')) {
                $rol->permisos()->attach($request->permisos);
            }

            Bitacora::create([
                'accion' => 'Crear Rol',
                'descripcion' => "Se creó el rol: {$request->nombre}",
                'tabla_afectada' => 'rols',
                'registro_afectado' => $rol->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear rol: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $rol = Rol::with('permisos')->findOrFail($id);
        return view('roles.show', compact('rol'));
    }

    public function edit(string $id)
    {
        $rol = Rol::with('permisos')->findOrFail($id);
        $permisos = Permiso::all();
        return view('roles.edit', compact('rol', 'permisos'));
    }

    public function update(Request $request, string $id)
    {
        $rol = Rol::findOrFail($id);

        //Validar que no sea un rol base
        if (in_array($rol->nombre, ['Coordinador', 'Docente', 'Autoridad'])) {
            return back()->with('error', 'No se puede modificar un rol predeterminado del sistema.');
        }
        
        $request->validate([
            'nombre' => 'required|string|max:50|unique:rols,nombre,' . $id,
            'descripcion' => 'nullable|string|max:200',
            'permisos' => 'nullable|array',
        ]);

        DB::beginTransaction();
        try {
            $rol->update([
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
            ]);

            //Sincronizar permisos
            if ($request->has('permisos')) {
                $rol->permisos()->sync($request->permisos);
            } else {
                $rol->permisos()->detach();
            }

            Bitacora::create([
                'accion' => 'Actualizar Rol',
                'descripcion' => "Se actualizó el rol: {$request->nombre}",
                'tabla_afectada' => 'rols',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar rol: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $rol = Rol::findOrFail($id);

        if (in_array($rol->nombre, ['Coordinador', 'Docente', 'Autoridad'])) {
            return back()->with('error', 'No se puede desactivar un rol predeterminado del sistema.');
        }

        if ($rol->usuarios()->count() > 0) {
            return back()->with('error', 'No se puede desactivar el rol porque tiene usuarios asignados.');
        }

        DB::beginTransaction();
        try {
            $rolNombre = $rol->nombre;
            $rol->permisos()->detach();
            $rol->delete();

            Bitacora::create([
                'accion' => 'Desactivar Rol',
                'descripcion' => "Se desactivo el rol: {$rolNombre}",
                'tabla_afectada' => 'rols',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('roles.index')->with('success', 'Rol desactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar rol: ' . $e->getMessage());
        }
    }
}