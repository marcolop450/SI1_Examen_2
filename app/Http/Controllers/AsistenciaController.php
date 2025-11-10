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

        // 🔥 SOLUCIÓN HÍBRIDA: Procesar faltas automáticas
        // Solo se ejecuta cada 30 minutos cuando alguien visita la página
        $this->procesarFaltasAutomaticas();

        $fechaActual = now()->format('Y-m-d');
        $horaActual = now()->format('H:i:s');
        
        // Mapeo de días en español
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $diaActual = $diasSemana[now()->format('l')];

        // Obtener horarios del docente para el día actual
        $horarios = Horario::where('id_docente', $docente->registro)
            ->where('dia', $diaActual)
            ->where('activo', true)
            ->with(['materia', 'grupo', 'aula'])
            ->get();

        // Filtrar solo horarios dentro del rango permitido
        $horariosDisponibles = $horarios->filter(function ($horario) use ($horaActual) {
            $horaInicio = Carbon::parse($horario->hora_inicio);
            $horaActualCarbon = Carbon::parse($horaActual);
            
            // 10 minutos antes
            $inicioPermitido = $horaInicio->copy()->subMinutes(10);
            // 20 minutos después
            $finalPermitido = $horaInicio->copy()->addMinutes(20);
            
            return $horaActualCarbon->between($inicioPermitido, $finalPermitido);
        });

        // Verificar asistencias ya registradas hoy
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

    /**
     * 🔥 MÉTODO CLAVE DE LA SOLUCIÓN HÍBRIDA
     * 
     * Registra faltas automáticas pero con "throttle" (límite de frecuencia)
     * para no ejecutarse en cada carga de página
     */
    private function procesarFaltasAutomaticas()
    {
        // PASO 1: Revisar cuándo fue la última ejecución
        $ultimaEjecucion = Cache::get('ultima_ejecucion_faltas_automaticas');
        
        // PASO 2: Si se ejecutó hace menos de 30 minutos, NO hacer nada
        if ($ultimaEjecucion && now()->diffInMinutes($ultimaEjecucion) < 30) {
            \Log::info('Proceso de faltas omitido - Última ejecución hace ' . 
                      now()->diffInMinutes($ultimaEjecucion) . ' minutos');
            return; // ⏭️ SALIR SIN HACER NADA
        }
        
        \Log::info('🚀 Iniciando proceso de faltas automáticas');
        
        // PASO 3: Marcar que se está ejecutando AHORA
        // Guardar en caché por 60 minutos
        Cache::put('ultima_ejecucion_faltas_automaticas', now(), 60);
        
        $fechaActual = now()->format('Y-m-d');
        $horaActual = now();
        
        // Mapeo de días
        $diasSemana = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $diaActual = $diasSemana[now()->format('l')];
        
        // PASO 4: Obtener horarios donde ya pasaron más de 20 minutos
        $horarios = Horario::where('dia', $diaActual)
            ->where('activo', true)
            ->get();
        
        $faltasRegistradas = 0;
        
        foreach ($horarios as $horario) {
            $horaInicio = Carbon::parse($horario->hora_inicio);
            $limiteRegistro = $horaInicio->copy()->addMinutes(20);
            
            // Si ya pasaron más de 20 minutos desde el inicio de clase
            if ($horaActual->greaterThan($limiteRegistro)) {
                
                // Verificar si NO existe asistencia registrada
                $asistenciaExiste = Asistencia::where('id_docente', $horario->id_docente)
                    ->where('id_horario', $horario->id)
                    ->where('fecha', $fechaActual)
                    ->exists();
                
                if (!$asistenciaExiste) {
                    try {
                        // PASO 5: Crear registro de falta
                        Asistencia::create([
                            'fecha' => $fechaActual,
                            'hora_llegada' => null, // No hubo llegada
                            'estado' => 'Falta',
                            'observaciones' => 'Falta automática por no registrar asistencia',
                            'id_docente' => $horario->id_docente,
                            'id_horario' => $horario->id,
                            'justificada' => false,
                        ]);
                        
                        $faltasRegistradas++;
                        
                        \Log::info("✅ Falta registrada - Docente: {$horario->id_docente}, Hora: {$horaInicio->format('H:i')}");
                        
                    } catch (\Exception $e) {
                        \Log::error("❌ Error al registrar falta: " . $e->getMessage());
                    }
                }
            }
        }
        
        \Log::info("✅ Proceso completado - {$faltasRegistradas} faltas registradas");
    }

    /**
     * Muestra el formulario de confirmación para un horario específico
     */
    public function form($id)
    {
        $docente = Auth::user()->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        $horario = Horario::with(['materia', 'grupo', 'aula'])->findOrFail($id);
        
        // Validar que el horario pertenece al docente
        if ($horario->id_docente != $docente->registro) {
            return redirect()->route('asistencias.index')
                ->with('error', 'No tiene autorización para registrar asistencia en este horario.');
        }

        // Validar que no existe asistencia previa hoy
        $fechaActual = now()->format('Y-m-d');
        $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
            ->where('id_horario', $horario->id)
            ->where('fecha', $fechaActual)
            ->first();

        if ($asistenciaExistente) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Ya registró su asistencia para esta clase.');
        }

        // Validar que está dentro del horario permitido
        $horaActual = now()->format('H:i:s');
        $horaInicio = Carbon::parse($horario->hora_inicio);
        $horaActualCarbon = Carbon::parse($horaActual);
        $inicioPermitido = $horaInicio->copy()->subMinutes(10);
        $finalPermitido = $horaInicio->copy()->addMinutes(20);

        if (!$horaActualCarbon->between($inicioPermitido, $finalPermitido)) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Fuera del horario permitido para registrar asistencia.');
        }
        
        return view('asistencias.form', compact('horario'));
    }

    /**
     * Registra asistencia confirmando con nombre de usuario
     */
    public function registrar(Request $request)
    {
        $request->validate([
            'id_horario' => 'required|exists:horarios,id',
            'username' => 'required|string',
            'observaciones' => 'nullable|string|max:500',
        ]);

        $docente = Auth::user()->docente;
        $horario = Horario::findOrFail($request->id_horario);
        $fechaActual = now()->format('Y-m-d');
        $horaActual = now()->format('H:i:s');

        try {
            DB::beginTransaction();

            // Validar que el horario pertenece al docente
            if ($horario->id_docente != $docente->registro) {
                return back()->with('error', 'No tiene autorización para registrar asistencia en este horario.');
            }

            // Validar nombre de usuario
            if (Auth::user()->username !== $request->username) {
                return back()
                    ->withErrors(['username' => 'El nombre de usuario no coincide con su cuenta.'])
                    ->withInput();
            }

            // Validar que no existe asistencia previa
            $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
                ->where('id_horario', $request->id_horario)
                ->where('fecha', $fechaActual)
                ->first();

            if ($asistenciaExistente) {
                return back()->with('error', 'Ya registró su asistencia para esta clase.');
            }

            // Validar rango de tiempo permitido
            $horaInicio = Carbon::parse($horario->hora_inicio);
            $horaActualCarbon = Carbon::parse($horaActual);
            $inicioPermitido = $horaInicio->copy()->subMinutes(10);
            $finalPermitido = $horaInicio->copy()->addMinutes(20);

            if (!$horaActualCarbon->between($inicioPermitido, $finalPermitido)) {
                return back()->with('error', 'Fuera del horario permitido para registrar asistencia. Puede registrar desde 10 minutos antes hasta 20 minutos después de la hora de inicio.');
            }

            // Calcular estado de asistencia
            $estado = $this->calcularEstado($horaActual, $horario->hora_inicio);

            // Crear registro de asistencia
            $asistencia = Asistencia::create([
                'fecha' => $fechaActual,
                'hora_llegada' => $horaActual,
                'estado' => $estado,
                'observaciones' => $request->observaciones,
                'id_docente' => $docente->registro,
                'id_horario' => $request->id_horario,
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

            $mensaje = $estado === 'A tiempo' 
                ? 'Asistencia registrada correctamente.' 
                : "Asistencia registrada con estado: {$estado}";

            return redirect()->route('asistencias.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('Error al registrar asistencia:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage());
        }
    }

    /**
     * Historial de asistencias del docente
     */
    public function historial(Request $request)
    {
        $docente = Auth::user()->docente;
        
        $query = Asistencia::where('id_docente', $docente->registro)
            ->with(['horario.materia', 'horario.grupo', 'horario.aula'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_llegada', 'desc');

        // Filtros opcionales
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

        // Estadísticas del docente
        $estadisticas = [
            'total' => Asistencia::where('id_docente', $docente->registro)->count(),
            'a_tiempo' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'A tiempo')->count(),
            'tardanzas' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'Tardanza')->count(),
            'faltas' => Asistencia::where('id_docente', $docente->registro)->where('estado', 'Falta')->count(),
        ];

        return view('asistencias.historial', compact('asistencias', 'estadisticas'));
    }

    /**
     * Consulta de asistencias para el coordinador
     */
    public function consultaCoordinador(Request $request)
    {
        // Query base con relaciones
        $query = Asistencia::with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula']);

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por docente
        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }

        // Filtro por grupo
        if ($request->filled('id_grupo')) {
            $query->whereHas('horario', function($q) use ($request) {
                $q->where('id_grupo', $request->id_grupo);
            });
        }

        // Ordenar y paginar
        $asistencias = $query->orderBy('fecha', 'desc')
                            ->orderBy('hora_llegada', 'desc')
                            ->paginate(20);

        // Calcular estadísticas con los filtros aplicados
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

        // Obtener listas para filtros
        $docentes = Docente::where('activo', true)->with('usuario')->get();
        $grupos = Grupo::where('activo', true)->get();

        return view('asistencias.consulta-coordinador', compact('asistencias', 'estadisticas', 'docentes', 'grupos'));
    }

    /**
     * Consulta de asistencias para autoridades (mismo que coordinador)
     */
    public function consultaAutoridad(Request $request)
    {
        // Query base con relaciones
        $query = Asistencia::with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula']);

        // Filtro por rango de fechas
        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Filtro por docente
        if ($request->filled('id_docente')) {
            $query->where('id_docente', $request->id_docente);
        }

        // Filtro por grupo
        if ($request->filled('id_grupo')) {
            $query->whereHas('horario', function($q) use ($request) {
                $q->where('id_grupo', $request->id_grupo);
            });
        }

        // Ordenar y paginar
        $asistencias = $query->orderBy('fecha', 'desc')
                            ->orderBy('hora_llegada', 'desc')
                            ->paginate(20);

        // Calcular estadísticas con los filtros aplicados
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

        // Obtener listas para filtros
        $docentes = Docente::where('activo', true)->with('usuario')->get();
        $grupos = Grupo::where('activo', true)->get();

        return view('asistencias.consulta-autoridad', compact('asistencias', 'estadisticas', 'docentes', 'grupos'));
    }

    /**
     * Justificar una falta o tardanza
     */
    public function justificar(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'required|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $asistencia = Asistencia::findOrFail($id);

            // Validar que la asistencia pertenece al docente actual
            if ($asistencia->id_docente != Auth::user()->docente->registro) {
                return redirect()->route('asistencias.historial')
                    ->with('error', 'No tiene autorización para justificar esta asistencia.');
            }

            // Validar que el estado sea justificable
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

    /**
     * Muestra el formulario para justificar una asistencia
     */
    public function justificarForm($id)
    {
        $asistencia = Asistencia::with(['horario.materia', 'horario.grupo'])
            ->findOrFail($id);
        
        // Validar que la asistencia pertenece al docente actual
        if ($asistencia->id_docente != Auth::user()->docente->registro) {
            return redirect()->route('asistencias.historial')
                ->with('error', 'No tiene autorización para justificar esta asistencia.');
        }
        
        // Validar que el estado sea justificable
        if ($asistencia->estado === 'A tiempo') {
            return redirect()->route('asistencias.historial')
                ->with('error', 'No es necesario justificar una asistencia a tiempo.');
        }
        
        // Validar que no esté ya justificada
        if ($asistencia->justificada) {
            return redirect()->route('asistencias.historial')
                ->with('info', 'Esta asistencia ya está justificada.');
        }
        
        return view('asistencias.justificar', compact('asistencia'));
    }

    /**
     * Calcular estado de asistencia según la hora de llegada
     */
    private function calcularEstado($horaLlegada, $horaInicio)
    {
        return Asistencia::calcularEstado($horaLlegada, $horaInicio);
    }
}