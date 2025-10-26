<?php

namespace App\Http\Controllers;

use App\Models\Permiso;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PermisoController extends Controller
{
    public function index()
    {
        $permisos = Permiso::all();
        return view('permisos.index', compact('permisos'));
    }

    public function create()
    {
        return view('permisos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:permisos,nombre',
            'descripcion' => 'nullable|string|max:200',
        ]);

        DB::beginTransaction();
        try {
            $permiso = Permiso::create($request->all());

            Bitacora::create([
                'accion' => 'Crear Permiso',
                'descripcion' => "Se creó el permiso: {$request->nombre}",
                'tabla_afectada' => 'permisos',
                'registro_afectado' => $permiso->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('permisos.index')->with('success', 'Permiso creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear permiso: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $permiso = Permiso::findOrFail($id);
        return view('permisos.edit', compact('permiso'));
    }

    public function update(Request $request, string $id)
    {
        $permiso = Permiso::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:50|unique:permisos,nombre,' . $id,
            'descripcion' => 'nullable|string|max:200',
        ]);

        DB::beginTransaction();
        try {
            $permiso->update($request->all());

            Bitacora::create([
                'accion' => 'Actualizar Permiso',
                'descripcion' => "Se actualizó el permiso: {$request->nombre}",
                'tabla_afectada' => 'permisos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('permisos.index')->with('success', 'Permiso actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar permiso: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $permiso = Permiso::findOrFail($id);

        DB::beginTransaction();
        try {
            $permisoNombre = $permiso->nombre;
            $permiso->roles()->detach();
            $permiso->delete();

            Bitacora::create([
                'accion' => 'Eliminar Permiso',
                'descripcion' => "Se eliminó el permiso: {$permisoNombre}",
                'tabla_afectada' => 'permisos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('permisos.index')->with('success', 'Permiso eliminado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar permiso: ' . $e->getMessage());
        }
    }
}