<?php

namespace App\Http\Controllers;

use App\Models\Bitacora;
use Illuminate\Http\Request;

class BitacoraController extends Controller
{
    public function index(Request $request)
    {
        $query = Bitacora::with('usuario')->orderBy('fecha', 'desc');

        //Filtros
        if ($request->filled('usuario')) {
            $query->where('id_usuario', $request->usuario);
        }

        if ($request->filled('accion')) {
            $query->where('accion', 'like', '%' . $request->accion . '%');
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha', '<=', $request->fecha_hasta);
        }

        if ($request->filled('tabla')) {
            $query->where('tabla_afectada', $request->tabla);
        }

        $bitacoras = $query->paginate(50);
        $usuarios = \App\Models\User::select('id', 'nombre', 'apellido')->get();
        $tablas = Bitacora::select('tabla_afectada')->distinct()->pluck('tabla_afectada');

        return view('bitacora.index', compact('bitacoras', 'usuarios', 'tablas'));
    }
}