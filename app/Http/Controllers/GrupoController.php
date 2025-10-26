<?php

namespace App\Http\Controllers;

use App\Models\Grupo;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GrupoController extends Controller
{
    //Se enlista los grupos
    public function index()
    {
        $grupos = Grupo::where('activo', true)->orderBy('nombre')->get();
        return view('grupos.index', compact('grupos'));
    }

    public function create()
    {
        return view('grupos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:10',
            'turno' => 'required|string|max:20',
            'capacidad_maxima' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $grupo = Grupo::create($request->all());

            Bitacora::create([
                'accion' => 'Crear Grupo',
                'descripcion' => "Se creó el grupo: {$request->nombre}",
                'tabla_afectada' => 'grupos',
                'registro_afectado' => $grupo->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('grupos.index')->with('success', 'Grupo creado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear grupo: ' . $e->getMessage())->withInput();
        }
    }

    public function show(string $id)
    {
        $grupo = Grupo::findOrFail($id);
        return view('grupos.show', compact('grupo'));
    }

    public function edit(string $id)
    {
        $grupo = Grupo::findOrFail($id);
        return view('grupos.edit', compact('grupo'));
    }

    public function update(Request $request, string $id)
    {
        $grupo = Grupo::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:10',
            'turno' => 'required|string|max:20',
            'capacidad_maxima' => 'required|integer|min:1',
        ]);

        DB::beginTransaction();
        try {
            $grupo->update($request->all());

            Bitacora::create([
                'accion' => 'Actualizar Grupo',
                'descripcion' => "Se actualizó el grupo: {$request->nombre}",
                'tabla_afectada' => 'grupos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('grupos.index')->with('success', 'Grupo actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar grupo: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $grupo = Grupo::findOrFail($id);

        if ($grupo->horarios()->count() > 0) {
            return back()->with('error', 'No se puede desactivar el grupo porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $grupo->update(['activo' => false]);

            Bitacora::create([
                'accion' => 'Desactivar Grupo',
                'descripcion' => "Se desactivo el grupo: {$grupo->nombre}",
                'tabla_afectada' => 'grupos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('grupos.index')->with('success', 'Grupo desactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar grupo: ' . $e->getMessage());
        }
    }

    //Listar grupos inactivos
    public function inactivos()
    {
        $grupos = Grupo::where('activo', false)->orderBy('nombre')->get();
        return view('grupos.inactivos', compact('grupos'));
    }

    //Reactivar
    public function reactivar(string $id)
    {
        $grupo = Grupo::findOrFail($id);

        if ($grupo->activo) {
            return back()->with('error', 'El grupo ya está activo.');
        }

        DB::beginTransaction();
        try {
            $grupo->update(['activo' => true]);

            Bitacora::create([
                'accion' => 'Reactivar Grupo',
                'descripcion' => "Se reactivó el grupo: {$grupo->nombre}",
                'tabla_afectada' => 'grupos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('grupos.inactivos')
                ->with('success', 'Grupo reactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar grupo: ' . $e->getMessage());
        }
    }

    //Eliminar permanentemente grupo
    public function forceDestroy(string $id)
    {
        $grupo = Grupo::findOrFail($id);

        if ($grupo->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente grupos inactivos.');
        }

        if ($grupo->horarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $nombre = $grupo->nombre;
            $grupo->delete();

            Bitacora::create([
                'accion' => 'Eliminar Grupo Permanentemente',
                'descripcion' => "Se eliminó permanentemente el grupo: {$nombre}",
                'tabla_afectada' => 'grupos',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('grupos.inactivos')
                ->with('success', 'Grupo eliminado permanentemente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar grupo: ' . $e->getMessage());
        }
    }
}