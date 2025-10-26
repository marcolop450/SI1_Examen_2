<?php

namespace App\Http\Controllers;

use App\Models\Materia;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MateriaController extends Controller
{
    //Listar materias
    public function index()
    {
        $materias = Materia::where('activo', true)->orderBy('semestre')->get();
        return view('materias.index', compact('materias'));
    }

    public function create()
    {
        return view('materias.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias,codigo',
            'contenido' => 'nullable|string',
            'semestre' => 'required|integer|between:1,10',
            'horas_teoricas' => 'required|integer|min:0',
            'horas_practicas' => 'required|integer|min:0',
            'creditos' => 'required|integer|min:1|max:10',
        ]);

        DB::beginTransaction();
        try {
            $materia = Materia::create($request->all());

            Bitacora::create([
                'accion' => 'Crear Materia',
                'descripcion' => "Se creó la materia: {$request->nombre} ({$request->codigo})",
                'tabla_afectada' => 'materias',
                'registro_afectado' => $materia->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('materias.index')->with('success', 'Materia creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear materia: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $materia = Materia::findOrFail($id);
        return view('materias.show', compact('materia'));
    }

    public function edit(string $id)
    {
        $materia = Materia::findOrFail($id);
        return view('materias.edit', compact('materia'));
    }

    public function update(Request $request, string $id)
    {
        $materia = Materia::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:100',
            'codigo' => 'required|string|max:20|unique:materias,codigo,' . $id,
            'contenido' => 'nullable|string',
            'semestre' => 'required|integer|between:1,10',
            'horas_teoricas' => 'required|integer|min:0',
            'horas_practicas' => 'required|integer|min:0',
            'creditos' => 'required|integer|min:1|max:10',
        ]);

        DB::beginTransaction();
        try {
            $materia->update($request->all());

            Bitacora::create([
                'accion' => 'Actualizar Materia',
                'descripcion' => "Se actualizó la materia: {$request->nombre} ({$request->codigo})",
                'tabla_afectada' => 'materias',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('materias.index')->with('success', 'Materia actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar materia: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $materia = Materia::findOrFail($id);

        if ($materia->horarios()->count() > 0) {
            return back()->with('error', 'No se puede desactivar la materia porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $materia->update(['activo' => false]);

            Bitacora::create([
                'accion' => 'Desactivar Materia',
                'descripcion' => "Se desactivo la materia: {$materia->nombre} ({$materia->codigo})",
                'tabla_afectada' => 'materias',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('materias.index')->with('success', 'Materia desactivada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar materia: ' . $e->getMessage());
        }
    }
    //Listar materias inactivas
    public function inactivos()
    {
        $materias = Materia::where('activo', false)->orderBy('semestre')->get();
        return view('materias.inactivos', compact('materias'));
    }

    //Reactivar materia
    public function reactivar(string $id)
    {
        $materia = Materia::findOrFail($id);

        if ($materia->activo) {
            return back()->with('error', 'La materia ya está activa.');
        }

        DB::beginTransaction();
        try {
            $materia->update(['activo' => true]);

            Bitacora::create([
                'accion' => 'Reactivar Materia',
                'descripcion' => "Se reactivó la materia: {$materia->nombre} ({$materia->codigo})",
                'tabla_afectada' => 'materias',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('materias.inactivos')
                ->with('success', 'Materia reactivada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar materia: ' . $e->getMessage());
        }
    }

    //Eliminar permanentemente materia
    public function forceDestroy(string $id)
    {
        $materia = Materia::findOrFail($id);

        if ($materia->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente materias inactivas.');
        }

        if ($materia->horarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $nombre = $materia->nombre . ' (' . $materia->codigo . ')';
            $materia->delete();

            Bitacora::create([
                'accion' => 'Eliminar Materia Permanentemente',
                'descripcion' => "Se eliminó permanentemente la materia: {$nombre}",
                'tabla_afectada' => 'materias',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('materias.inactivos')
                ->with('success', 'Materia eliminada permanentemente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar materia: ' . $e->getMessage());
        }
    }
}