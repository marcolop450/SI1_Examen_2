<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AulaController extends Controller
{
    //Listar aulas solo activas
    public function index()
    {
        $aulas = Aula::where('activo', true)->orderBy('nombre')->get();
        return view('aulas.index', compact('aulas'));
    }

    //Llama a create
    public function create()
    {
        return view('aulas.create');
    }

    //Guardar nueva aula
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:50|unique:aulas,nombre',
            'tipo' => 'required|string|max:30',
            'capacidad' => 'required|integer|min:1',
            'piso' => 'nullable|string|max:100',
            'equipamiento' => 'nullable|string',
        ]);

        //Se usa transcaccion para cuando existe errores haiga un Rollback
        DB::beginTransaction();
        try {
            $aula = Aula::create($request->all());

            Bitacora::create([
                'accion' => 'Crear Aula',
                'descripcion' => "Se creó el aula: {$request->nombre}",
                'tabla_afectada' => 'aulas',
                'registro_afectado' => $aula->id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit(); //Confirma y guarda
            return redirect()->route('aulas.index')->with('success', 'Aula creada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al crear aula: ' . $e->getMessage())->withInput();
        }
    }

    //Envia a mostrar con mas detalles
    public function show(string $id)
    {
        $aula = Aula::findOrFail($id);
        return view('aulas.show', compact('aula'));
    }

    public function edit(string $id)
    {
        $aula = Aula::findOrFail($id);
        return view('aulas.edit', compact('aula'));
    }

    public function update(Request $request, string $id)
    {
        $aula = Aula::findOrFail($id);
        
        $request->validate([
            'nombre' => 'required|string|max:50|unique:aulas,nombre,' . $id,
            'tipo' => 'required|string|max:30',
            'capacidad' => 'required|integer|min:1',
            'piso' => 'nullable|string|max:100',
            'equipamiento' => 'nullable|string',
        ]);
        
        DB::beginTransaction();
        try {
            $aula->update($request->all());

            Bitacora::create([
                'accion' => 'Actualizar Aula',
                'descripcion' => "Se actualizó el aula: {$request->nombre}",
                'tabla_afectada' => 'aulas',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('aulas.index')->with('success', 'Aula actualizada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar aula: ' . $e->getMessage());
        }
    }

    //Desactiva
    public function destroy(string $id)
    {
        $aula = Aula::findOrFail($id);

        if ($aula->horarios()->count() > 0) {
            return back()->with('error', 'No se puede desactivar el aula porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $aula->update(['activo' => false]);

            Bitacora::create([
                'accion' => 'Desactivar Aula',
                'descripcion' => "Se desactivo el aula: {$aula->nombre}",
                'tabla_afectada' => 'aulas',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('aulas.index')->with('success', 'Aula desactivada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar aula: ' . $e->getMessage());
        }
    }

    //Listar aulas inactivas
    public function inactivos()
    {
        $aulas = Aula::where('activo', false)->orderBy('nombre')->get();
        return view('aulas.inactivos', compact('aulas'));
    }

    //Reactivar aula
    public function reactivar(string $id)
    {
        $aula = Aula::findOrFail($id);

        if ($aula->activo) {
            return back()->with('error', 'El aula ya está activa.');
        }

        DB::beginTransaction();
        try {
            $aula->update(['activo' => true]);

            Bitacora::create([
                'accion' => 'Reactivar Aula',
                'descripcion' => "Se reactivó el aula: {$aula->nombre}",
                'tabla_afectada' => 'aulas',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('aulas.inactivos')
                ->with('success', 'Aula reactivada exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar aula: ' . $e->getMessage());
        }
    }

    //Eliminar permanentemente
    public function forceDestroy(string $id)
    {
        $aula = Aula::findOrFail($id);

        if ($aula->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente aulas inactivas.');
        }

        if ($aula->horarios()->count() > 0) {
            return back()->with('error', 'No se puede eliminar porque tiene horarios asignados.');
        }

        DB::beginTransaction();
        try {
            $nombre = $aula->nombre;
            $aula->delete();

            Bitacora::create([
                'accion' => 'Eliminar Aula Permanentemente',
                'descripcion' => "Se eliminó permanentemente el aula: {$nombre}",
                'tabla_afectada' => 'aulas',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('aulas.inactivos')
                ->with('success', 'Aula eliminada permanentemente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar aula: ' . $e->getMessage());
        }
    }
}