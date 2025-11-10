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
    // Constante para zona horaria
    private const TIMEZONE = 'America/La_Paz';
    
    /**
     * Obtiene la fecha/hora actual en La Paz
     */
    private function getNowLaPaz()
    {
        return Carbon::now(self::TIMEZONE);
    }
    
    public function index()
    {
        $docente = Auth::user()->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        // Procesar faltas automáticas
        $this->procesarFaltasAutomaticas();

        $now = $this->getNowLaPaz();
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

        // Obtener horarios del día
        $horarios = Horario::where('id_docente', $docente->registro)
            ->where('dia', $diaActual)
            ->where('activo', true)
            ->with(['materia', 'grupo', 'aula'])
            ->get();

        // Filtrar horarios disponibles usando el método del modelo
        $horaActual = $now->format('H:i:s');
        $horariosDisponibles = $horarios->filter(function ($horario) use ($horaActual) {
            return Asistencia::estaDentroDeRango($horaActual, $horario->hora_inicio);
        });

        // Obtener asistencias ya registradas hoy
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
        // Usar cache con TTL más corto y clave única por día
        $now = $this->getNowLaPaz();
        $cacheKey = 'faltas_automaticas_' . $now->format('Y-m-d');
        
        // Si ya se procesó hoy, salir
        if (Cache::has($cacheKey)) {
            \Log::info('Faltas automáticas ya procesadas hoy', ['fecha' => $now->format('Y-m-d')]);
            return;
        }
        
        \Log::info('Iniciando procesamiento de faltas automáticas', [
            'fecha' => $now->format('Y-m-d'),
            'hora' => $now->format('H:i:s')
        ]);
        
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
        
        // Obtener todos los horarios del día
        $horarios = Horario::where('dia', $diaActual)
            ->where('activo', true)
            ->get();
        
        $faltasRegistradas = 0;
        
        foreach ($horarios as $horario) {
            try {
                // Crear Carbon con la hora del horario
                $horaInicio = Carbon::createFromFormat(
                    'Y-m-d H:i:s',
                    $now->format('Y-m-d') . ' ' . $horario->hora_inicio,
                    self::TIMEZONE
                );
                
                $limiteRegistro = $horaInicio->copy()->addMinutes(20);
                
                // Si ya pasó el límite de registro
                if ($now->greaterThan($limiteRegistro)) {
                    // Verificar si ya existe registro de asistencia
                    $asistenciaExiste = Asistencia::where('id_docente', $horario->id_docente)
                        ->where('id_horario', $horario->id)
                        ->where('fecha', $fechaActual)
                        ->exists();
                    
                    if (!$asistenciaExiste) {
                        $asistencia = Asistencia::create([
                            'fecha' => $fechaActual,
                            'hora_llegada' => null,
                            'estado' => 'Falta',
                            'observaciones' => 'Falta automática por no registrar asistencia',
                            'id_docente' => $horario->id_docente,
                            'id_horario' => $horario->id,
                            'justificada' => false,
                        ]);
                        
                        $faltasRegistradas++;
                        
                        \Log::info('Falta automática registrada', [
                            'id_asistencia' => $asistencia->id,
                            'id_horario' => $horario->id,
                            'id_docente' => $horario->id_docente
                        ]);
                    }
                }
            } catch (\Exception $e) {
                \Log::error("Error al procesar horario", [
                    'error' => $e->getMessage(),
                    'id_horario' => $horario->id ?? 'N/A'
                ]);
            }
        }
        
        // Marcar como procesado por hoy (expira en 24 horas)
        Cache::put($cacheKey, true, now()->endOfDay());
        
        \Log::info('Procesamiento de faltas completado', [
            'faltas_registradas' => $faltasRegistradas
        ]);
    }

    public function form($id)
    {
        $docente = Auth::user()->docente;
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        $horario = Horario::with(['materia', 'grupo', 'aula'])->findOrFail($id);
        
        // Verificar autorización
        if ($horario->id_docente != $docente->registro) {
            return redirect()->route('asistencias.index')
                ->with('error', 'No tiene autorización para registrar asistencia en este horario.');
        }

        $now = $this->getNowLaPaz();
        $fechaActual = $now->format('Y-m-d');
        
        // Verificar si ya existe asistencia
        $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
            ->where('id_horario', $horario->id)
            ->where('fecha', $fechaActual)
            ->first();

        if ($asistenciaExistente) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Ya registró su asistencia para esta clase.');
        }

        // Validar rango horario usando el método del modelo
        $horaActual = $now->format('H:i:s');
        
        if (!Asistencia::estaDentroDeRango($horaActual, $horario->hora_inicio)) {
            return redirect()->route('asistencias.index')
                ->with('error', 'Fuera del horario permitido para registrar asistencia.');
        }
        
        return view('asistencias.form', compact('horario'));
    }

    public function registrar(Request $request)
    {
        $now = $this->getNowLaPaz();
        
        // LOG INICIAL - CRÍTICO
        \Log::info('════════════════════════════════════════');
        \Log::info('🚀 INICIO REGISTRO ASISTENCIA', [
            'user_id' => Auth::id(),
            'username' => Auth::user()->username,
            'request_username' => $request->username,
            'id_horario' => $request->id_horario,
            'fecha_hora_lapaz' => $now->toDateTimeString(),
            'ip' => $request->ip(),
        ]);

        // Validación
        try {
            $request->validate([
                'id_horario' => 'required|exists:horarios,id',
                'username' => 'required|string',
                'observaciones' => 'nullable|string|max:500',
            ]);
            \Log::info('✅ Validación pasada');
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('❌ Error de validación', [
                'errors' => $e->errors()
            ]);
            throw $e;
        }

        $docente = Auth::user()->docente;
        
        if (!$docente) {
            \Log::error('❌ Docente no encontrado', ['user_id' => Auth::id()]);
            return back()->with('error', 'No se encontró información de docente asociada a su usuario.');
        }

        \Log::info('👤 Docente encontrado', [
            'registro' => $docente->registro,
            'nombre' => $docente->usuario->nombre ?? 'N/A'
        ]);

        $horario = Horario::findOrFail($request->id_horario);
        
        $fechaActual = $now->format('Y-m-d');
        $horaActual = $now->format('H:i:s');

        \Log::info('⏰ Datos de tiempo', [
            'fecha_actual' => $fechaActual,
            'hora_actual' => $horaActual,
            'hora_inicio_horario' => $horario->hora_inicio,
        ]);

        try {
            DB::beginTransaction();
            \Log::info('📊 Transacción iniciada');

            // Verificar autorización
            if ($horario->id_docente != $docente->registro) {
                \Log::warning('⚠️ Horario no pertenece al docente', [
                    'horario_docente' => $horario->id_docente,
                    'docente_actual' => $docente->registro
                ]);
                DB::rollBack();
                return back()->with('error', 'No tiene autorización para registrar asistencia en este horario.');
            }

            // Verificar username
            if (Auth::user()->username !== $request->username) {
                \Log::warning('⚠️ Username incorrecto', [
                    'esperado' => Auth::user()->username,
                    'recibido' => $request->username
                ]);
                DB::rollBack();
                return back()
                    ->withErrors(['username' => 'El nombre de usuario no coincide con su cuenta.'])
                    ->withInput();
            }

            // Verificar duplicado
            $asistenciaExistente = Asistencia::where('id_docente', $docente->registro)
                ->where('id_horario', $request->id_horario)
                ->where('fecha', $fechaActual)
                ->first();

            if ($asistenciaExistente) {
                \Log::info('⚠️ Asistencia ya existe', ['id' => $asistenciaExistente->id]);
                DB::rollBack();
                return back()->with('error', 'Ya registró su asistencia para esta clase.');
            }

            // Validar rango horario
            $horaInicio = Carbon::createFromFormat(
                'Y-m-d H:i:s',
                $now->format('Y-m-d') . ' ' . $horario->hora_inicio,
                self::TIMEZONE
            );
            
            $inicioPermitido = $horaInicio->copy()->subMinutes(10);
            $finalPermitido = $horaInicio->copy()->addMinutes(20);

            \Log::info('🕐 Validación de rango', [
                'hora_actual' => $now->format('H:i:s'),
                'inicio_permitido' => $inicioPermitido->format('H:i:s'),
                'final_permitido' => $finalPermitido->format('H:i:s'),
                'esta_en_rango' => $now->between($inicioPermitido, $finalPermitido)
            ]);

            if (!$now->between($inicioPermitido, $finalPermitido)) {
                \Log::warning('❌ Fuera de rango horario');
                DB::rollBack();
                return back()->with('error', 'Fuera del horario permitido para registrar asistencia.');
            }

            // Calcular estado
            $estado = Asistencia::calcularEstado($horaActual, $horario->hora_inicio);

            \Log::info('📝 Intentando crear asistencia', [
                'fecha' => $fechaActual,
                'hora_llegada' => $horaActual,
                'estado' => $estado,
                'id_docente' => $docente->registro,
                'id_horario' => $request->id_horario,
            ]);

            // CREAR ASISTENCIA
            $asistencia = Asistencia::create([
                'fecha' => $fechaActual,
                'hora_llegada' => $horaActual,
                'estado' => $estado,
                'observaciones' => $request->observaciones,
                'id_docente' => $docente->registro,
                'id_horario' => $request->id_horario,
                'justificada' => false,
            ]);

            \Log::info('✅ ASISTENCIA CREADA', [
                'id' => $asistencia->id,
                'estado' => $asistencia->estado,
                'fecha' => $asistencia->fecha,
                'hora' => $asistencia->hora_llegada
            ]);

            // Bitácora
            Bitacora::create([
                'accion' => 'Registro Asistencia',
                'descripcion' => "Docente {$docente->usuario->nombre} {$docente->usuario->apellido} registró asistencia. Estado: {$estado}",
                'tabla_afectada' => 'asistencias',
                'registro_afectado' => $asistencia->id,
                'ip_direccion' => $request->ip(),
                'id_usuario' => Auth::id(),
            ]);

            DB::commit();
            \Log::info('✅ TRANSACCIÓN COMMIT EXITOSO');
            \Log::info('════════════════════════════════════════');

            $mensaje = $estado === 'A tiempo' 
                ? 'Asistencia registrada correctamente.' 
                : "Asistencia registrada con estado: {$estado}";

            return redirect()->route('asistencias.index')->with('success', $mensaje);

        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error('💥 ERROR CRÍTICO AL REGISTRAR', [
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ]);
            \Log::info('════════════════════════════════════════');
            
            return back()->with('error', 'Error al registrar asistencia: ' . $e->getMessage());
        }
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