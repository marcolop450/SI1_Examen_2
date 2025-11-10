<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Horario;
use App\Models\Bitacora;
use App\Models\Docente;
use App\Models\User;
use App\Models\Grupo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Carbon\Carbon;

class AsistenciaController extends Controller
{
    /**
     * Muestra el formulario de registro de asistencia
     */
    public function index()
    {
        $docente = Auth::user()->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        $this->procesarFaltasAutomaticas();

        // 🔥 CORRECCIÓN: Usar timezone de La Paz explícitamente
        $now = Carbon::now('America/La_Paz');
        $fechaActual = $now->format('Y-m-d');
        $horaActual = $now->format('H:i:s');
        
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $diaActual = $diasSemana[$now->format('l')];

        $horarios = Horario::where('id_docente', $docente->registro)
            ->where('dia', $diaActual)
            ->where('activo', true)
            ->with(['materia', 'grupo', 'aula'])
            ->get();

        $horariosDisponibles = $horarios->filter(function ($horario) use ($now) {
            $horaInicio = Carbon::parse($horario->hora_inicio)->setDate($now->year, $now->month, $now->day);
            $inicioPermitido = $horaInicio->copy()->subMinutes(10);
            $finalPermitido = $horaInicio->copy()->addMinutes(20);
            
            return $now->between($inicioPermitido, $finalPermitido);
        });

        $asistenciasRegistradas = Asistencia::where('id_docente', $docente->registro)
            ->where('fecha', $fechaActual)
            ->pluck('id_horario')
            ->toArray();

        return view('asistencias.index', compact(
            'horariosDisponibles',
            'asistenciasRegistradas',
            'fechaActual',
            'horaActual'
        ));
    }

    private function procesarFaltasAutomaticas()
    {
        $ultimaEjecucion = Cache::get('ultima_ejecucion_faltas_automaticas');
        
        if ($ultimaEjecucion && now()->diffInMinutes($ultimaEjecucion) < 30) {
            return;
        }
        
        Cache::put('ultima_ejecucion_faltas_automaticas', now(), 60);
        
        $now = Carbon::now('America/La_Paz');
        $fechaActual = $now->format('Y-m-d');
        
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $diaActual = $diasSemana[$now->format('l')];
        
        $horarios = Horario::where('dia', $diaActual)
            ->where('activo', true)
            ->get();
        
        $faltasRegistradas = 0;
        
        foreach ($horarios as $horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio)->setDate($now->year, $now->month, $now->day);
            $limiteRegistro = $horaInicio->copy()->addMinutes(20);
            
            if ($now->greaterThan($limiteRegistro)) {
                $asistenciaExiste = Asistencia::where('id_docente', $horario->id_docente)
                    ->where('id_horario', $horario->id)
                    ->where('fecha', $fechaActual)
                    ->exists();
                
                if (!$asistenciaExiste) {
                    try {
                        Asistencia::create([
                            'fecha' => $fechaActual,
                            'hora_llegada' => null,
                            'estado' => 'Falta',
                            'observaciones' => 'Falta automática por no registrar asistencia',
                            'id_docente' => $horario->id_docente,
                            'id_horario' => $horario->id,
                            'justificada' => false,
                        ]);
                        
                        $faltasRegistradas++;
                        
                    } catch (\Exception $e) {
                        \Log::error("Error al registrar falta: " . $e->getMessage());
                    }
                }
            }
        }
    }

    public function form($id)
    {
        $docente = Auth::user()->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        $horario = Horario::with(['materia', 'grupo', 'aula'])->findOrFail($id);
        
        if ($horario->id_docente != $docente->registro) {
            return redirect()->route('asistencias.index')
                ->with('error', 'No tiene autorización para registrar asistencia en este horario.');
        }

        // 🔥 CORRECCIÓN: Usar timezone explícito
        $now = Carbon::now('America/La_Paz');
        $fechaActual = $now->format('Y-m-d');
        
        $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
            ->where('id_horario', $horario->id)
            ->where('fecha', $fechaActual)
            ->first();

        if ($asistenciaExistente) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Ya registró su asistencia para esta clase.');
        }

        $horaInicio = Carbon::parse($horario->hora_inicio)->setDate($now->year, $now->month, $now->day);
        $inicioPermitido = $horaInicio->copy()->subMinutes(10);
        $finalPermitido = $horaInicio->copy()->addMinutes(20);

        if (!$now->between($inicioPermitido, $finalPermitido)) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Fuera del horario permitido para registrar asistencia.');
        }
        
        return view('asistencias.form', compact('horario'));
    }

    /**
     * 🔥 MÉTODO PRINCIPAL CORREGIDO
     */
    public function registrar(Request $request)
    {
        // Log inicial para debugging
        \Log::info('=== INICIO REGISTRO ASISTENCIA ===', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'ip' => $request->ip(),
            'timezone_server' => config('app.timezone'),
            'timezone_env' => env('APP_TIMEZONE'),
            'now' => now()->toDateTimeString(),
            'now_lapaz' => Carbon::now('America/La_Paz')->toDateTimeString(),
        ]);

        $request->validate([
            'id_horario' => 'required|exists:horarios,id',
            'username' => 'required|string',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $docente = Auth::user()->docente;
        
        if (!$docente) {
            \Log::error('Docente no encontrado para usuario', ['user_id' => Auth::id()]);
            return back()->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        $horario = Horario::findOrFail($request->id_horario);
        
        // 🔥 CORRECCIÓN CRÍTICA: Usar timezone de La Paz
        $now = Carbon::now('America/La_Paz');
        $fechaActual = $now->format('Y-m-d');
        $horaActual = $now->format('H:i:s');

        \Log::info('Datos de tiempo', [
            'fecha_actual' => $fechaActual,
            'hora_actual' => $horaActual,
            'hora_inicio_horario' => $horario->hora_inicio,
        ]);

        try {
            DB::beginTransaction();

            // Validación 1: Horario pertenece al docente
            if ($horario->id_docente != $docente->registro) {
                \Log::warning('Intento de registro en horario ajeno', [
                    'horario_docente' => $horario->id_docente,
                    'docente_actual' => $docente->registro
                ]);
                return back()->with('error', 'No tiene autorización para registrar asistencia en este horario.');
            }

            // Validación 2: Username correcto
            if (Auth::user()->username !== $request->username) {
                \Log::warning('Username incorrecto', [
                    'esperado' => Auth::user()->username,
                    'recibido' => $request->username
                ]);
                return back()
                    ->withErrors(['username' => 'El nombre de usuario no coincide con su cuenta.'])
                    ->withInput();
            }

            // Validación 3: No existe asistencia previa
            $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
                ->where('id_horario', $request->id_horario)
                ->where('fecha', $fechaActual)
                ->first();

            if ($asistenciaExistente) {
                \Log::info('Asistencia ya existe', ['asistencia_id' => $asistenciaExistente->id]);
                return back()->with('error', 'Ya registró su asistencia para esta clase.');
            }

            // Validación 4: Rango de tiempo permitido
            $horaInicio = Carbon::parse($horario->hora_inicio)->setDate($now->year, $now->month, $now->day);
            $inicioPermitido = $horaInicio->copy()->subMinutes(10);
            $finalPermitido = $horaInicio->copy()->addMinutes(20);

            \Log::info('Validación de rango horario', [
                'hora_actual' => $now->format('H:i:s'),
                'hora_inicio' => $horaInicio->format('H:i:s'),
                'inicio_permitido' => $inicioPermitido->format('H:i:s'),
                'final_permitido' => $finalPermitido->format('H:i:s'),
                'esta_en_rango' => $now->between($inicioPermitido, $finalPermitido)
            ]);

            if (!$now->between($inicioPermitido, $finalPermitido)) {
                return back()->with('error', 'Fuera del horario permitido para registrar asistencia. Puede registrar desde 10 minutos antes hasta 20 minutos después de la hora de inicio.');
            }

            // 🔥 CALCULAR ESTADO CORRECTAMENTE
            $estado = $this->calcularEstado($horaActual, $horario->hora_inicio);
            $minutosDif = Asistencia::calcularMinutosDiferencia($horaActual, $horario->hora_inicio);

            \Log::info('Estado calculado', [
                'estado' => $estado,
                'hora_llegada' => $horaActual,
                'hora_inicio' => $horario->hora_inicio,
                'minutos_diferencia' => $minutosDif
            ]);

            // Crear registro de asistencia
            $asistencia = Asistencia::create([
                'fecha' => $fechaActual,
                'hora_llegada' => $horaActual,
                'estado' => $estado,
                'observaciones' => $request->observaciones,
                'id_docente' => $docente->registro,
                'id_horario' => $request->id_horario,
                'justificada' => false,
            ]);

            \Log::info('Asistencia creada exitosamente', [
                'asistencia_id' => $asistencia->id,
                'estado' => $asistencia->estado
            ]);

            // Registrar en bitácora
            Bitacora::create([
                'accion' => 'Registro Asistencia',
                'descripcion' => "Docente {$docente->usuario->nombre} {$docente->usuario->apellido} registró asistencia. Estado: {$estado}",
                'tabla_afectada' => 'asistencias',
                'registro_afectado' => $asistencia->id,
                'ip_direccion' => $request->ip(),
                'id_usuario' => Auth::id(),
            ]);

            DB::commit();

            \Log::info('=== ASISTENCIA REGISTRADA EXITOSAMENTE ===');

            $mensaje = $estado === 'A tiempo' 
                ? 'Asistencia registrada correctamente.' 
                : "Asistencia registrada con estado: {$estado}";

            return redirect()->route('asistencias.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('=== ERROR AL REGISTRAR ASISTENCIA ===', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * 🔥 Delegar al método del modelo
     */
    private function calcularEstado($horaLlegada, $horaInicio)
    {
        return Asistencia::calcularEstado($horaLlegada, $horaInicio);
    }

    public function historial(Request $request)
    {
        $docente = Auth::user()->docente;
        
        $query = Asistencia::where('id_docente', $docente->registro)
            ->with(['horario.materia', 'horario.grupo', 'horario.aula'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_llegada', 'desc');

        if ($request->filled('fecha_inicio')) {
            $query->where('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->where('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        $asistencias = $query->paginate(20);

        $estadisticas = [
            'total' => Asistencia::where('id_docente', $docente->registro)->count(),
            'a_tiempo' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'A tiempo')->count(),
            'tardanzas' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'Tardanza')->count(),
            'faltas' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'Falta')->count(),
        ];

        return view('asistencias.historial', compact('asistencias', 'estadisticas'));
    }

    public function consultaCoordinador(Request $request)
    {
        $query = Asistencia::with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula']);

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }
        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }
        if ($request->filled('id_grupo')) {
            $query->whereHas('horario', function($q) use ($request) {
                $q->where('id_grupo', $request->id_grupo);
            });
        }

        $asistencias = $query->orderBy('fecha', 'desc')
                            ->orderBy('hora_llegada', 'desc')
                            ->paginate(20);

        $estadisticasQuery = Asistencia::query();
        
        if ($request->filled('fecha_inicio')) {
            $estadisticasQuery->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $estadisticasQuery->whereDate('fecha', '<=', $request->fecha_fin);
        }
        if ($request->filled('estado')) {
            $estadisticasQuery->where('estado', $request->estado);
        }
        if ($request->filled('id_docente')) {
            $estadisticasQuery->where('id_docente', $request->id_docente);
        }
        if ($request->filled('id_grupo')) {
            $estadisticasQuery->whereHas('horario', function($q) use ($request) {
                $q->where('id_grupo', $request->id_grupo);
            });
        }

        $estadisticas = [
            'total' => $estadisticasQuery->count(),
            'a_tiempo' => (clone $estadisticasQuery)->where('estado', 'A tiempo')->count(),
            'tardanzas' => (clone $estadisticasQuery)->where('estado', 'Tardanza')->count(),
            'faltas' => (clone $estadisticasQuery)->where('estado', 'Falta')->count(),
        ];

        $docentes = Docente::where('activo', true)->with('usuario')->get();
        $grupos = Grupo::where('activo', true)->get();

        return view('asistencias.consulta-coordinador', compact('asistencias', 'estadisticas', 'docentes', 'grupos'));
    }

    public function consultaAutoridad(Request $request)
    {
        return $this->consultaCoordinador($request);
    }

    public function justificar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $asistencia = Asistencia::findOrFail($id);

            if ($asistencia->id_docente != Auth::user()->docente->registro) {
                return redirect()->route('asistencias.historial')
                    ->with('error', 'No tiene autorización para justificar esta asistencia.');
            }

            if ($asistencia->estado === 'A tiempo') {
                return redirect()->route('asistencias.historial')
                    ->with('error', 'No es necesario justificar una asistencia a tiempo.');
            }

            $asistencia->update([
                'justificada' => true,
                'observaciones' => $request->observaciones,
            ]);

            Bitacora::create([
                'accion' => 'Justificar Asistencia',
                'descripcion' => "Asistencia justificada: ID {$id}",
                'tabla_afectada' => 'asistencias',
                'registro_afectado' => $id,
                'ip_direccion' => $request->ip(),
                'id_usuario' => Auth::id(),
            ]);

            DB::commit();

            return redirect()->route('asistencias.historial')
                ->with('success', 'Asistencia justificada correctamente.');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('asistencias.historial')
                ->with('error', 'Error al justificar asistencia: ' . $e->getMessage());
        }
    }

    public function justificarForm($id)
    {
        $asistencia = Asistencia::with(['horario.materia', 'horario.grupo'])
            ->findOrFail($id);
        
        if ($asistencia->id_docente != Auth::user()->docente->registro) {
            return redirect()->route('asistencias.historial')
                ->with('error', 'No tiene autorización para justificar esta asistencia.');
        }
        
        if ($asistencia->estado === 'A tiempo') {
            return redirect()->route('asistencias.historial')
                ->with('error', 'No es necesario justificar una asistencia a tiempo.');
        }
        
        if ($asistencia->justificada) {
            return redirect()->route('asistencias.historial')
                ->with('info', 'Esta asistencia ya está justificada.');
        }
        
        return view('asistencias.justificar', compact('asistencia'));
    }
}