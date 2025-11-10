<?php

namespace App\Http\Controllers;

use App\Models\Asistencia;
use App\Models\Horario;
use App\Models\Docente;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Materia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AsistenciasExport;
use App\Exports\HorariosExport;
use App\Exports\AulasExport;
use App\Exports\CargaHorariaDocenteExport;

class ReporteController extends Controller
{
    /**
     * ========================================
     * VISTA PRINCIPAL DE REPORTES
     * ========================================
     */
    public function index()
    {
        // KPIs Generales del Sistema
        $estadisticas = [
            'total_docentes' => Docente::where('activo', true)->count(),
            'total_horarios' => Horario::where('activo', true)->count(),
            'total_grupos' => Grupo::where('activo', true)->count(),
            'total_aulas' => Aula::where('activo', true)->count(),
            'total_materias' => Materia::where('activo', true)->count(),
            'asistencias_mes' => Asistencia::whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->count(),
            'promedio_puntualidad' => $this->calcularPromedioPuntualidad(),
            'docentes_activos_hoy' => Asistencia::whereDate('fecha', now())
                ->distinct('id_docente')
                ->count('id_docente'),
        ];

        // Tendencia de asistencias últimos 7 días
        $tendenciaAsistencias = Asistencia::whereBetween('fecha', [now()->subDays(6), now()])
            ->selectRaw("DATE(fecha) as dia, 
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'A tiempo' THEN 1 ELSE 0 END) as a_tiempo,
                SUM(CASE WHEN estado = 'Tardanza' THEN 1 ELSE 0 END) as tardanzas,
                SUM(CASE WHEN estado = 'Falta' THEN 1 ELSE 0 END) as faltas")
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // Top 5 docentes más puntuales del mes
        $topDocentes = Docente::where('activo', true)
            ->with('usuario')
            ->get()
            ->map(function ($docente) {
                $asistencias = Asistencia::where('id_docente', $docente->registro)
                    ->whereMonth('fecha', now()->month)
                    ->whereYear('fecha', now()->year)
                    ->get();

                $total = $asistencias->count();
                $aTiempo = $asistencias->where('estado', 'A tiempo')->count();

                return [
                    'docente' => $docente,
                    'total' => $total,
                    'a_tiempo' => $aTiempo,
                    'porcentaje' => $total > 0 ? round(($aTiempo / $total) * 100, 2) : 0,
                ];
            })
            ->filter(fn($item) => $item['total'] > 0)
            ->sortByDesc('porcentaje')
            ->take(5);

        // Aulas más utilizadas
        $topAulas = Horario::where('activo', true)
            ->where('es_virtual', false)
            ->whereNotNull('id_aula')
            ->select('id_aula', DB::raw('COUNT(*) as total'))
            ->groupBy('id_aula')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->with('aula')
            ->get();

        return view('reportes.index', compact(
            'estadisticas',
            'tendenciaAsistencias',
            'topDocentes',
            'topAulas'
        ));
    }

    /**
     * ========================================
     * DASHBOARD EN TIEMPO REAL
     * ========================================
     */
    public function dashboardTiempoReal()
    {
        $diaActual = $this->traducirDia(now()->locale('es')->dayName);
        $horaActual = now()->format('H:i:s');

        // Clases en curso AHORA
        $clasesEnCurso = Horario::where('activo', true)
            ->where('dia', $diaActual)
            ->whereTime('hora_inicio', '<=', $horaActual)
            ->whereTime('hora_final', '>=', $horaActual)
            ->with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->get();

        // Próximas clases (siguientes 2 horas)
        $proximasClases = Horario::where('activo', true)
            ->where('dia', $diaActual)
            ->whereTime('hora_inicio', '>', $horaActual)
            ->whereTime('hora_inicio', '<=', now()->addHours(2)->format('H:i:s'))
            ->with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->orderBy('hora_inicio')
            ->get();

        // Asistencias registradas HOY
        $asistenciasHoy = Asistencia::whereDate('fecha', now())
            ->with(['docente.usuario', 'horario.materia', 'horario.grupo'])
            ->orderBy('hora_llegada', 'desc')
            ->get();

        // Alertas: clases sin asistencia registrada (ya pasó hora inicio)
        $alertasSinAsistencia = Horario::where('activo', true)
            ->where('dia', $diaActual)
            ->whereTime('hora_inicio', '<', $horaActual)
            ->whereDoesntHave('asistencias', function($q) {
                $q->whereDate('fecha', now());
            })
            ->with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->get();

        $estadisticas = [
            'clases_en_curso' => $clasesEnCurso->count(),
            'proximas_clases' => $proximasClases->count(),
            'asistencias_hoy' => $asistenciasHoy->count(),
            'alertas' => $alertasSinAsistencia->count(),
            'docentes_activos_hoy' => $asistenciasHoy->unique('id_docente')->count(),
            'asistencias_a_tiempo' => $asistenciasHoy->where('estado', 'A tiempo')->count(),
            'tardanzas_hoy' => $asistenciasHoy->where('estado', 'Tardanza')->count(),
            'faltas_hoy' => $asistenciasHoy->where('estado', 'Falta')->count(),
        ];

        return view('reportes.dashboard-tiempo-real', compact(
            'clasesEnCurso',
            'proximasClases',
            'asistenciasHoy',
            'alertasSinAsistencia',
            'estadisticas',
            'diaActual'
        ));
    }

    /**
     * ========================================
     * REPORTE DE HORARIOS
     * ========================================
     */
    public function horarios(Request $request)
    {
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');
        $filtroDia = $request->input('dia');

        // Obtener listas para filtros
        $docentes = Docente::where('activo', true)->with('usuario')->get();
        $grupos = Grupo::where('activo', true)->get();
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        // Query base
        $queryHorarios = Horario::where('activo', true);

        if ($filtroDocente) {
            $queryHorarios->where('id_docente', $filtroDocente);
        }
        if ($filtroGrupo) {
            $queryHorarios->where('id_grupo', $filtroGrupo);
        }
        if ($filtroDia) {
            $queryHorarios->where('dia', $filtroDia);
        }

        // Estadísticas
        $estadisticas = [
            'total_horarios' => (clone $queryHorarios)->count(),
            'horarios_presenciales' => (clone $queryHorarios)->where('es_virtual', false)->count(),
            'horarios_virtuales' => (clone $queryHorarios)->where('es_virtual', true)->count(),
            'docentes_con_horarios' => (clone $queryHorarios)->distinct('id_docente')->count('id_docente'),
            'grupos_con_horarios' => (clone $queryHorarios)->distinct('id_grupo')->count('id_grupo'),
        ];

        // Distribución por día
        $distribucionPorDia = (clone $queryHorarios)
            ->select('dia', DB::raw('COUNT(*) as total'))
            ->groupBy('dia')
            ->get()
            ->pluck('total', 'dia');

        // Aulas más utilizadas
        $aulasMasUsadas = (clone $queryHorarios)
            ->where('es_virtual', false)
            ->whereNotNull('id_aula')
            ->select('id_aula', DB::raw('COUNT(*) as total'))
            ->groupBy('id_aula')
            ->with('aula')
            ->orderBy('total', 'desc')
            ->limit(10)
            ->get();

        // Docentes con más horas
        $docentesConMasHoras = Docente::where('activo', true)
            ->when($filtroDocente, fn($q) => $q->where('registro', $filtroDocente))
            ->orderBy('carga_horaria_actual', 'desc')
            ->limit(10)
            ->with('usuario')
            ->get();

        // Horarios completos (para tabla detallada)
        $horarios = (clone $queryHorarios)
            ->with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->paginate(20);

        return view('reportes.horarios', compact(
            'estadisticas',
            'distribucionPorDia',
            'aulasMasUsadas',
            'docentesConMasHoras',
            'horarios',
            'docentes',
            'grupos',
            'diasSemana',
            'filtroDocente',
            'filtroGrupo',
            'filtroDia'
        ));
    }

    /**
     * ========================================
     * REPORTE DE ASISTENCIAS
     * ========================================
     */
    public function asistencias(Request $request)
    {
        $request->validate([
            'fecha_inicio' => 'nullable|date|before_or_equal:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ]);

        $fechaInicio = $request->input('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', now()->format('Y-m-d'));
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');
        $filtroEstado = $request->input('estado');

        // Listas para filtros
        $docentes = Docente::where('activo', true)->with('usuario')->get();
        $grupos = Grupo::where('activo', true)->get();

        // Query base
        $queryAsistencias = Asistencia::whereBetween('fecha', [$fechaInicio, $fechaFin]);

        if ($filtroDocente) {
            $queryAsistencias->where('id_docente', $filtroDocente);
        }
        if ($filtroGrupo) {
            $queryAsistencias->whereHas('horario', fn($q) => $q->where('id_grupo', $filtroGrupo));
        }
        if ($filtroEstado) {
            $queryAsistencias->where('estado', $filtroEstado);
        }

        // Estadísticas del período
        $estadisticas = [
            'total' => (clone $queryAsistencias)->count(),
            'a_tiempo' => (clone $queryAsistencias)->where('estado', 'A tiempo')->count(),
            'tardanzas' => (clone $queryAsistencias)->where('estado', 'Tardanza')->count(),
            'faltas' => (clone $queryAsistencias)->where('estado', 'Falta')->count(),
            'justificadas' => (clone $queryAsistencias)->where('justificada', true)->count(),
        ];

        // Calcular porcentajes
        if ($estadisticas['total'] > 0) {
            $estadisticas['porcentaje_a_tiempo'] = round(($estadisticas['a_tiempo'] / $estadisticas['total']) * 100, 2);
            $estadisticas['porcentaje_tardanzas'] = round(($estadisticas['tardanzas'] / $estadisticas['total']) * 100, 2);
            $estadisticas['porcentaje_faltas'] = round(($estadisticas['faltas'] / $estadisticas['total']) * 100, 2);
        } else {
            $estadisticas['porcentaje_a_tiempo'] = 0;
            $estadisticas['porcentaje_tardanzas'] = 0;
            $estadisticas['porcentaje_faltas'] = 0;
        }

        // Ranking de docentes por puntualidad
        $queryDocentes = Docente::where('activo', true)->with('usuario');
        if ($filtroDocente) {
            $queryDocentes->where('registro', $filtroDocente);
        }

        $rankingDocentes = $queryDocentes->get()
            ->map(function ($docente) use ($fechaInicio, $fechaFin, $filtroGrupo) {
                $queryAsist = Asistencia::where('id_docente', $docente->registro)
                    ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

                if ($filtroGrupo) {
                    $queryAsist->whereHas('horario', fn($q) => $q->where('id_grupo', $filtroGrupo));
                }

                $asistencias = $queryAsist->get();
                $total = $asistencias->count();
                $aTiempo = $asistencias->where('estado', 'A tiempo')->count();
                $tardanzas = $asistencias->where('estado', 'Tardanza')->count();
                $faltas = $asistencias->where('estado', 'Falta')->count();

                return [
                    'docente' => $docente,
                    'total' => $total,
                    'a_tiempo' => $aTiempo,
                    'tardanzas' => $tardanzas,
                    'faltas' => $faltas,
                    'porcentaje_puntualidad' => $total > 0 ? round(($aTiempo / $total) * 100, 2) : 0,
                ];
            })
            ->filter(fn($item) => $item['total'] > 0)
            ->sortByDesc('a_tiempo')
            ->values()
            ->take(15);

        // Asistencias por día de la semana
        $asistenciasPorDia = (clone $queryAsistencias)
            ->with('horario')
            ->get()
            ->groupBy(fn($asistencia) => $asistencia->horario->dia ?? 'Sin horario')
            ->map(function ($group) {
                return [
                    'total' => $group->count(),
                    'a_tiempo' => $group->where('estado', 'A tiempo')->count(),
                    'tardanzas' => $group->where('estado', 'Tardanza')->count(),
                    'faltas' => $group->where('estado', 'Falta')->count(),
                ];
            });

        // Tendencia últimos 7 días
        $tendenciaUltimos7Dias = Asistencia::whereBetween('fecha', [now()->subDays(6), now()])
            ->when($filtroDocente, fn($q) => $q->where('id_docente', $filtroDocente))
            ->selectRaw("DATE(fecha) as dia, 
                COUNT(*) as total,
                SUM(CASE WHEN estado = 'A tiempo' THEN 1 ELSE 0 END) as a_tiempo")
            ->groupBy('dia')
            ->orderBy('dia')
            ->get();

        // Docentes con más faltas
        $docentesConMasFaltas = Asistencia::whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->where('estado', 'Falta')
            ->select('id_docente', DB::raw('COUNT(*) as total_faltas'))
            ->groupBy('id_docente')
            ->orderBy('total_faltas', 'desc')
            ->limit(5)
            ->with('docente.usuario')
            ->get();

        // Listado detallado de asistencias
        $asistencias = (clone $queryAsistencias)
            ->with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula'])
            ->orderBy('fecha', 'desc')
            ->orderBy('hora_llegada', 'desc')
            ->paginate(20);

        return view('reportes.asistencias', compact(
            'estadisticas',
            'rankingDocentes',
            'asistenciasPorDia',
            'tendenciaUltimos7Dias',
            'docentesConMasFaltas',
            'asistencias',
            'fechaInicio',
            'fechaFin',
            'filtroDocente',
            'filtroGrupo',
            'filtroEstado',
            'docentes',
            'grupos'
        ));
    }

    /**
     * ========================================
     * REPORTE DE AULAS
     * ========================================
     */
    public function aulas(Request $request)
    {
        $filtroAula = $request->input('aula');
        $filtroDia = $request->input('dia');

        $aulas = Aula::where('activo', true)->get();
        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        // Estadísticas generales
        $estadisticas = [
            'total_aulas' => Aula::where('activo', true)->count(),
            'aulas_ocupadas' => Horario::where('activo', true)
                ->where('es_virtual', false)
                ->whereNotNull('id_aula')
                ->distinct('id_aula')
                ->count('id_aula'),
        ];

        // Ocupación por aula
        $ocupacionAulas = Aula::where('activo', true)
            ->when($filtroAula, fn($q) => $q->where('id', $filtroAula))
            ->withCount(['horarios' => function ($query) use ($filtroDia) {
                $query->where('activo', true);
                if ($filtroDia) {
                    $query->where('dia', $filtroDia);
                }
            }])
            ->get()
            ->map(function ($aula) use ($filtroDia) {
                $queryHorarios = Horario::where('id_aula', $aula->id)->where('activo', true);
                
                if ($filtroDia) {
                    $queryHorarios->where('dia', $filtroDia);
                }
                
                $horariosDetallados = $queryHorarios->get();

                return [
                    'aula' => $aula,
                    'total_horarios' => $horariosDetallados->count(),
                    'horas_semanales' => $this->calcularHorasSemanalesAula($horariosDetallados),
                    'porcentaje_ocupacion' => $this->calcularPorcentajeOcupacion($horariosDetallados),
                ];
            })
            ->sortByDesc('total_horarios');

        // Aulas libres por día
        $aulasLibresPorDia = [];
        foreach ($diasSemana as $dia) {
            $aulasLibresPorDia[$dia] = Aula::where('activo', true)
                ->whereNotIn('id', function ($query) use ($dia) {
                    $query->select('id_aula')
                        ->from('horarios')
                        ->where('dia', $dia)
                        ->where('activo', true)
                        ->whereNotNull('id_aula');
                })
                ->count();
        }

        return view('reportes.aulas', compact(
            'estadisticas',
            'ocupacionAulas',
            'aulasLibresPorDia',
            'aulas',
            'diasSemana',
            'filtroAula',
            'filtroDia'
        ));
    }

    /**
     * ========================================
     * AULAS DISPONIBLES POR FRANJA HORARIA
     * ========================================
     */
    public function aulasDisponibles(Request $request)
    {
        $dia = $request->input('dia', $this->traducirDia(now()->locale('es')->dayName));
        $horaInicio = $request->input('hora_inicio', '08:00');
        $horaFin = $request->input('hora_fin', '10:00');

        $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];

        // Aulas ocupadas en ese rango
        $aulasOcupadas = Horario::where('activo', true)
            ->where('dia', $dia)
            ->where('es_virtual', false)
            ->whereNotNull('id_aula')
            ->where(function($query) use ($horaInicio, $horaFin) {
                $query->whereBetween('hora_inicio', [$horaInicio, $horaFin])
                      ->orWhereBetween('hora_final', [$horaInicio, $horaFin])
                      ->orWhere(function($q) use ($horaInicio, $horaFin) {
                          $q->where('hora_inicio', '<=', $horaInicio)
                            ->where('hora_final', '>=', $horaFin);
                      });
            })
            ->with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->get();

        // Aulas disponibles
        $aulasDisponibles = Aula::where('activo', true)
            ->whereNotIn('id', $aulasOcupadas->pluck('id_aula')->unique())
            ->get();

        return view('reportes.aulas-disponibles', compact(
            'aulasDisponibles',
            'aulasOcupadas',
            'dia',
            'horaInicio',
            'horaFin',
            'diasSemana'
        ));
    }

    /**
     * ========================================
     * CARGA HORARIA POR DOCENTE
     * ========================================
     */
    public function cargaHorariaDocente(Request $request, $idDocente = null)
    {
        $docentes = Docente::where('activo', true)->with('usuario')->get();
        
        if ($idDocente) {
            $docente = Docente::with('usuario')->findOrFail($idDocente);
            
            $horarios = Horario::where('id_docente', $docente->registro)
                ->where('activo', true)
                ->with(['materia', 'grupo', 'aula'])
                ->orderBy('dia')
                ->orderBy('hora_inicio')
                ->get();
            
            // Calcular horas por día
            $horasPorDia = $horarios->groupBy('dia')->map(function($grupo) {
                return $grupo->sum(function($horario) {
                    $inicio = Carbon::parse($horario->hora_inicio);
                    $fin = Carbon::parse($horario->hora_final);
                    return round($inicio->diffInMinutes($fin) / 60, 2);
                });
            });
            
            $totalHorasSemanales = $horasPorDia->sum();
            
            // Asistencias del mes
            $asistenciasMes = Asistencia::where('id_docente', $docente->registro)
                ->whereMonth('fecha', now()->month)
                ->whereYear('fecha', now()->year)
                ->get();
            
            $estadisticasAsistencia = [
                'total' => $asistenciasMes->count(),
                'a_tiempo' => $asistenciasMes->where('estado', 'A tiempo')->count(),
                'tardanzas' => $asistenciasMes->where('estado', 'Tardanza')->count(),
                'faltas' => $asistenciasMes->where('estado', 'Falta')->count(),
            ];
            
            return view('reportes.carga-horaria-docente', compact(
                'docente',
                'horarios',
                'horasPorDia',
                'totalHorasSemanales',
                'estadisticasAsistencia',
                'docentes'
            ));
        }
        
        return view('reportes.seleccionar-docente', compact('docentes'));
    }

    /**
     * ========================================
     * EXPORTAR A PDF - ASISTENCIAS
     * ========================================
     */
    public function exportarAsistenciasPDF(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', now()->format('Y-m-d'));
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');

        $query = Asistencia::with(['docente.usuario', 'horario.materia', 'horario.grupo', 'horario.aula'])
            ->whereBetween('fecha', [$fechaInicio, $fechaFin]);

        if ($filtroDocente) {
            $query->where('id_docente', $filtroDocente);
        }
        if ($filtroGrupo) {
            $query->whereHas('horario', fn($q) => $q->where('id_grupo', $filtroGrupo));
        }

        $asistencias = $query->orderBy('fecha', 'desc')->get();

        $estadisticas = [
            'total' => $asistencias->count(),
            'a_tiempo' => $asistencias->where('estado', 'A tiempo')->count(),
            'tardanzas' => $asistencias->where('estado', 'Tardanza')->count(),
            'faltas' => $asistencias->where('estado', 'Falta')->count(),
        ];

        $pdf = PDF::loadView('reportes.pdf.asistencias', compact(
            'asistencias',
            'estadisticas',
            'fechaInicio',
            'fechaFin'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('reporte_asistencias_' . date('Y-m-d') . '.pdf');
    }

    /**
     * ========================================
     * EXPORTAR A PDF - CARGA HORARIA DOCENTE
     * ========================================
     */
    public function exportarCargaHorariaPDF($idDocente)
    {
        $docente = Docente::with('usuario')->findOrFail($idDocente);
        
        $horarios = Horario::where('id_docente', $docente->registro)
            ->where('activo', true)
            ->with(['materia', 'grupo', 'aula'])
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $horasPorDia = $horarios->groupBy('dia')->map(function($grupo) {
            return $grupo->sum(function($horario) {
                $inicio = Carbon::parse($horario->hora_inicio);
                $fin = Carbon::parse($horario->hora_final);
                return round($inicio->diffInMinutes($fin) / 60, 2);
            });
        });

        $totalHorasSemanales = $horasPorDia->sum();

        $pdf = PDF::loadView('reportes.pdf.carga-horaria', compact(
            'docente',
            'horarios',
            'horasPorDia',
            'totalHorasSemanales'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('carga_horaria_' . $docente->registro . '.pdf');
    }

    /**
     * ========================================
     * EXPORTAR A PDF - HORARIOS
     * ========================================
     */
    public function exportarHorariosPDF(Request $request)
    {
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');
        $filtroDia = $request->input('dia');

        $query = Horario::where('activo', true)
            ->with(['docente.usuario', 'materia', 'grupo', 'aula']);

        if ($filtroDocente) {
            $query->where('id_docente', $filtroDocente);
        }
        if ($filtroGrupo) {
            $query->where('id_grupo', $filtroGrupo);
        }
        if ($filtroDia) {
            $query->where('dia', $filtroDia);
        }

        $horarios = $query->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $estadisticas = [
            'total_horarios' => $horarios->count(),
            'horarios_presenciales' => $horarios->where('es_virtual', false)->count(),
            'horarios_virtuales' => $horarios->where('es_virtual', true)->count(),
            'docentes_con_horarios' => $horarios->unique('id_docente')->count(),
            'grupos_con_horarios' => $horarios->unique('id_grupo')->count(),
        ];

        $pdf = PDF::loadView('reportes.pdf.horarios', compact(
            'horarios',
            'estadisticas',
            'filtroDocente',
            'filtroGrupo',
            'filtroDia'
        ))->setPaper('a4', 'landscape');

        return $pdf->download('reporte_horarios_' . date('Y-m-d') . '.pdf');
    }

    /**
     * ========================================
     * EXPORTAR A PDF - AULAS
     * ========================================
     */
    public function exportarAulasPDF(Request $request)
    {
        $filtroAula = $request->input('aula');
        $filtroDia = $request->input('dia');

        $ocupacionAulas = Aula::where('activo', true)
            ->when($filtroAula, fn($q) => $q->where('id', $filtroAula))
            ->get()
            ->map(function ($aula) use ($filtroDia) {
                $queryHorarios = Horario::where('id_aula', $aula->id)->where('activo', true);
                
                if ($filtroDia) {
                    $queryHorarios->where('dia', $filtroDia);
                }
                
                $horariosDetallados = $queryHorarios->get();

                return [
                    'aula' => $aula,
                    'total_horarios' => $horariosDetallados->count(),
                    'horas_semanales' => $this->calcularHorasSemanalesAula($horariosDetallados),
                    'porcentaje_ocupacion' => $this->calcularPorcentajeOcupacion($horariosDetallados),
                ];
            })
            ->sortByDesc('total_horarios');

        $estadisticas = [
            'total_aulas' => Aula::where('activo', true)->count(),
            'aulas_ocupadas' => Horario::where('activo', true)
                ->where('es_virtual', false)
                ->whereNotNull('id_aula')
                ->distinct('id_aula')
                ->count('id_aula'),
        ];

        $pdf = PDF::loadView('reportes.pdf.aulas', compact(
            'ocupacionAulas',
            'estadisticas',
            'filtroAula',
            'filtroDia'
        ))->setPaper('a4', 'portrait');

        return $pdf->download('reporte_aulas_' . date('Y-m-d') . '.pdf');
    }
    /**
     * ========================================
     * EXPORTAR A EXCEL - ASISTENCIAS
     * ========================================
     */
    public function exportarAsistenciasExcel(Request $request)
    {
        $fechaInicio = $request->input('fecha_inicio', now()->startOfMonth()->format('Y-m-d'));
        $fechaFin = $request->input('fecha_fin', now()->format('Y-m-d'));
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');

        $nombreArchivo = 'asistencias_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new AsistenciasExport($fechaInicio, $fechaFin, $filtroDocente, $filtroGrupo),
            $nombreArchivo
        );
    }

    /**
     * ========================================
     * EXPORTAR A EXCEL - HORARIOS
     * ========================================
     */
    public function exportarHorariosExcel(Request $request)
    {
        $filtroDocente = $request->input('docente');
        $filtroGrupo = $request->input('grupo');
        $filtroDia = $request->input('dia');

        $nombreArchivo = 'horarios_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new HorariosExport($filtroDocente, $filtroGrupo, $filtroDia),
            $nombreArchivo
        );
    }

    /**
     * ========================================
     * EXPORTAR A EXCEL - AULAS
     * ========================================
     */
    public function exportarAulasExcel()
    {
        $nombreArchivo = 'aulas_ocupacion_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new AulasExport(),
            $nombreArchivo
        );
    }
    
    public function exportarCargaHorariaExcel($idDocente)
    {
        $nombreArchivo = 'carga_horaria_docente_' . $idDocente . '_' . date('Y-m-d_His') . '.xlsx';

        return Excel::download(
            new CargaHorariaDocenteExport($idDocente),
            $nombreArchivo
        );
    }
    /**
     * ========================================
     * MÉTODOS AUXILIARES
     * ========================================
     */
    private function calcularPromedioPuntualidad()
    {
        $total = Asistencia::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->count();

        if ($total == 0) return 0;

        $aTiempo = Asistencia::whereMonth('fecha', now()->month)
            ->whereYear('fecha', now()->year)
            ->where('estado', 'A tiempo')
            ->count();

        return round(($aTiempo / $total) * 100, 2);
    }

    private function calcularHorasSemanalesAula($horarios)
    {
        $totalMinutos = 0;

        foreach ($horarios as $horario) {
            $inicio = Carbon::parse($horario->hora_inicio);
            $fin = Carbon::parse($horario->hora_final);
            $totalMinutos += $inicio->diffInMinutes($fin);
        }

        return round($totalMinutos / 60, 2);
    }

    private function calcularPorcentajeOcupacion($horarios)
    {
        $horasDisponibles = 72; // 6 días x 12 horas
        $horasOcupadas = $this->calcularHorasSemanalesAula($horarios);

        if ($horasDisponibles == 0) return 0;

        return round(($horasOcupadas / $horasDisponibles) * 100, 2);
    }

    private function traducirDia($dia)
    {
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo',
        ];

        return $dias[$dia] ?? ucfirst($dia);
    }
}