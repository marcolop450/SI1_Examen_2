<?php

namespace App\Http\Controllers;

use App\Models\Horario;
use App\Models\Docente;
use App\Models\Materia;
use App\Models\Grupo;
use App\Models\Aula;
use App\Models\Bitacora;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HorarioController extends Controller
{
    const MINUTOS_POR_HORA_ACADEMICA = 45;
    private function generarHorariosDisponibles()
    {
        $horarios = [];
        $inicio = Carbon::createFromTime(7, 0);
        $fin = Carbon::createFromTime(21, 15); 
        
        while ($inicio->lessThanOrEqualTo($fin)) {
            $horarios[] = $inicio->format('H:i');
            $inicio->addMinutes(self::MINUTOS_POR_HORA_ACADEMICA);
        }
        
        return $horarios;
    }

    public function index(Request $request)
    {
        $query = Horario::with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->where('activo', true);

        if ($request->filled('gestion')) {
            $query->where('gestion', $request->gestion);
        }
        if ($request->filled('docente')) {
            $query->where('id_docente', $request->docente);
        }
        if ($request->filled('grupo')) {
            $query->where('id_grupo', $request->grupo);
        }
        if ($request->filled('dia')) {
            $query->where('dia', $request->dia);
        }

        $horarios = $query->orderBy('dia')
                         ->orderBy('hora_inicio')
                         ->paginate(20);

        $docentes = Docente::with('usuario')->where('activo', true)->get();
        $grupos = Grupo::where('activo', true)->get();
        $gestiones = Horario::select('gestion')->distinct()->pluck('gestion');

        return view('horarios.index', compact('horarios', 'docentes', 'grupos', 'gestiones'));
    }

    public function consulta(Request $request)
    {
        $query = Horario::with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->where('activo', true);

        if ($request->filled('gestion')) {
            $query->where('gestion', $request->gestion);
        }
        if ($request->filled('docente')) {
            $query->where('id_docente', $request->docente);
        }
        if ($request->filled('grupo')) {
            $query->where('id_grupo', $request->grupo);
        }
        if ($request->filled('dia')) {
            $query->where('dia', $request->dia);
        }

        $horarios = $query->orderBy('dia')
                        ->orderBy('hora_inicio')
                        ->paginate(20);

        $docentes = Docente::with('usuario')->where('activo', true)->get();
        $grupos = Grupo::where('activo', true)->get();
        $gestiones = Horario::select('gestion')->distinct()->pluck('gestion');

        return view('horarios.consulta-autoridad', compact('horarios', 'docentes', 'grupos', 'gestiones'));
    }

    public function show(string $id)
    {
        $horario = Horario::with([
            'docente.usuario',
            'materia',
            'grupo',
            'aula'
        ])->findOrFail($id);
        $minutos = $this->calcularDuracionEnMinutos($horario->hora_inicio, $horario->hora_final);
        $horasAcademicas = round($minutos / self::MINUTOS_POR_HORA_ACADEMICA, 2);

        return view('horarios.show', compact(
            'horario',
            'horasAcademicas'
        ));
    }

    public function create()
    {
        $docentes = Docente::with('usuario')->where('activo', true)->get();
        $materias = Materia::where('activo', true)->get();
        $grupos = Grupo::where('activo', true)->get();
        $aulas = Aula::where('activo', true)->get();
        $horariosDisponibles = $this->generarHorariosDisponibles();
        return view('horarios.create', compact('docentes', 'materias', 'grupos', 'aulas', 'horariosDisponibles'));
    }

    public function store(Request $request)
    {
        \Log::info('=== INICIO: Crear Horarios ===');
        \Log::info('Datos recibidos:', $request->all());

        try {
            $validated = $request->validate([
                'id_docente' => 'required|exists:docentes,registro',
                'id_materia' => 'required|exists:materias,id',
                'id_grupo' => 'required|exists:grupos,id',
                'id_aula' => 'nullable|exists:aulas,id',
                'dias' => 'required|array|min:1|max:3',
                'dias.*' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
                'hora_inicio' => 'required|date_format:H:i',
                'gestion' => 'required|string|max:10',
                'es_virtual' => 'nullable|boolean',
                'observaciones' => 'nullable|string',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Error de validación:', $e->errors());
            return back()->withErrors($e->errors())->withInput();
        }

        if (count($request->dias) !== count(array_unique($request->dias))) {
            return back()->withErrors(['dias' => 'No puede seleccionar el mismo día múltiples veces.'])->withInput();
        }

        $esVirtual = $request->has('es_virtual') && $request->es_virtual;
        if (!$esVirtual && !$request->id_aula) {
            return back()->withErrors(['id_aula' => 'El aula es obligatoria para clases presenciales.'])->withInput();
        }

        DB::beginTransaction();
        try {
            $materia = Materia::findOrFail($request->id_materia);
            $docente = Docente::findOrFail($request->id_docente);
            $grupo = Grupo::findOrFail($request->id_grupo);
            $minutosSemanales = $materia->es_electiva ? 180 : 270;
            $cantidadDias = count($request->dias);
            $minutosPorDia = round($minutosSemanales / $cantidadDias);
            
            $horasPorDia = $minutosPorDia / self::MINUTOS_POR_HORA_ACADEMICA;
            $horasTotalesSemana = $horasPorDia * $cantidadDias;
            $horasTotalesEnteras = (int) round($horasTotalesSemana);            
            $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
            $horaFinal = $horaInicio->copy()->addMinutes($minutosPorDia)->format('H:i');
            $limiteHora = Carbon::createFromTime(23, 0);
            $horaFinalCarbon = Carbon::createFromFormat('H:i', $horaFinal);

            if ($horaFinalCarbon->greaterThan($limiteHora) || $horaFinalCarbon->lessThan($horaInicio)) {
                DB::rollback();
                return back()->withErrors([
                    'error' => "La hora final calculada ({$horaFinal}) excede el límite permitido de 23:00 (11:00 PM) o cruza la medianoche. " .
                            "Por favor, seleccione una hora de inicio más temprana."
                ])->withInput();
            }
            $cargaNueva = $docente->carga_horaria_actual + $horasTotalesEnteras;
            if ($cargaNueva > $docente->carga_horaria_maxima) {
                DB::rollback();
                return back()->withErrors([
                    'error' => "El docente excedería su carga horaria máxima. " .
                            "Carga actual: {$docente->carga_horaria_actual} hrs, " .
                            "Carga a agregar: {$horasTotalesEnteras} hrs, " .
                            "Nueva carga: {$cargaNueva} hrs, " .
                            "Máxima permitida: {$docente->carga_horaria_maxima} hrs académicas"
                ])->withInput();
            }

            $horariosCreados = [];

            foreach ($request->dias as $dia) {
                if ($this->verificarGrupoMateriaEnDia($request->id_grupo, $request->id_materia, $dia, $request->gestion)) {
                    DB::rollback();
                    return back()->withErrors([
                        'error' => "El grupo {$grupo->nombre} ya tiene asignada la materia {$materia->nombre} el día {$dia}. " .
                                "Un grupo no puede tener la misma materia dos veces en el mismo día."
                    ])->withInput();
                }

                if ($this->verificarConflictoDocente($request->id_docente, $dia, $request->hora_inicio, $horaFinal, $request->gestion)) {
                    DB::rollback();
                    return back()->withErrors(['error' => "El docente ya tiene un horario asignado el día {$dia} en ese horario."])->withInput();
                }

                if (!$esVirtual && $request->id_aula) {
                    if ($this->verificarConflictoAula($request->id_aula, $dia, $request->hora_inicio, $horaFinal, $request->gestion)) {
                        DB::rollback();
                        return back()->withErrors(['error' => "El aula ya está ocupada el día {$dia} en ese horario."])->withInput();
                    }
                }

                if ($this->verificarConflictoGrupo($request->id_grupo, $dia, $request->hora_inicio, $horaFinal, $request->gestion)) {
                    DB::rollback();
                    return back()->withErrors(['error' => "El grupo ya tiene un horario asignado el día {$dia} en ese horario."])->withInput();
                }

                $horario = Horario::create([
                    'dia' => $dia,
                    'hora_inicio' => $request->hora_inicio,
                    'hora_final' => $horaFinal,
                    'gestion' => $request->gestion,
                    'activo' => true,
                    'observaciones' => $request->observaciones,
                    'es_virtual' => $esVirtual,
                    'id_docente' => $request->id_docente,
                    'id_materia' => $request->id_materia,
                    'id_grupo' => $request->id_grupo,
                    'id_aula' => $esVirtual ? null : $request->id_aula,
                ]);

                $horariosCreados[] = $horario;
            }
            $docente->carga_horaria_actual = $docente->carga_horaria_actual + $horasTotalesEnteras;
            $docente->save();

            //Enviamos a Bitacora
            Bitacora::create([
                'accion' => 'Crear Horarios',
                'descripcion' => "Horarios creados para {$cantidadDias} días: {$request->hora_inicio}-{$horaFinal} " .
                                "({$horasTotalesEnteras} hrs académicas totales) " .
                                "- Docente: {$docente->usuario->nombre}",
                'tabla_afectada' => 'horarios',
                'registro_afectado' => implode(',', array_map(fn($h) => $h->id, $horariosCreados)),
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();

            return redirect()->route('horarios.index')
                ->with('success', 
                    "Se crearon {$cantidadDias} horarios exitosamente. " .
                    "Total semanal: {$horasTotalesEnteras} horas académicas."
                );

        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('ERROR al crear horarios:', [
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ]);
            return back()->with('error', 'Error al crear horarios: ' . $e->getMessage())->withInput();
        }
    }

    public function edit(string $id)
    {
        $horario = Horario::findOrFail($id);
        $docentes = Docente::with('usuario')->where('activo', true)->get();
        $materias = Materia::where('activo', true)->get();
        $grupos = Grupo::where('activo', true)->get();
        $aulas = Aula::where('activo', true)->get();
        $horariosDisponibles = $this->generarHorariosDisponibles();

        return view('horarios.edit', compact('horario', 'docentes', 'materias', 'grupos', 'aulas', 'horariosDisponibles'));
    }

    public function update(Request $request, string $id)
    {
        $horario = Horario::findOrFail($id);
        
        $request->validate([
            'id_docente' => 'required|exists:docentes,registro',
            'id_materia' => 'required|exists:materias,id',
            'id_grupo' => 'required|exists:grupos,id',
            'id_aula' => 'nullable|exists:aulas,id',
            'dia' => 'required|in:Lunes,Martes,Miércoles,Jueves,Viernes,Sábado',
            'hora_inicio' => 'required|date_format:H:i',
            'gestion' => 'required|string|max:10',
            'es_virtual' => 'boolean',
            'observaciones' => 'nullable|string',
        ]);

        if (!$request->es_virtual && !$request->id_aula) {
            return back()->withErrors(['id_aula' => 'El aula es obligatoria para clases presenciales.'])->withInput();
        }

        DB::beginTransaction();
        try {
             $materia = Materia::findOrFail($request->id_materia);
            
            $diasConMismaMateria = Horario::where('id_grupo', $request->id_grupo)
                ->where('id_materia', $request->id_materia)
                ->where('gestion', $request->gestion)
                ->where('activo', true)
                ->distinct('dia')
                ->count('dia');
            
            $esElMismoDia = ($horario->dia == $request->dia && 
                           $horario->id_grupo == $request->id_grupo && 
                           $horario->id_materia == $request->id_materia);
            
            if (!$esElMismoDia) {
                $diasConMismaMateria++;
            }
            
            $minutosSemanales = $materia->es_electiva ? 180 : 270;
            $minutosPorDia = round($minutosSemanales / max(1, $diasConMismaMateria));           
            $horaInicio = Carbon::createFromFormat('H:i', $request->hora_inicio);
            $horaFinal = $horaInicio->copy()->addMinutes($minutosPorDia)->format('H:i');
            $limiteHora = Carbon::createFromTime(23, 0);
            $horaFinalCarbon = Carbon::createFromFormat('H:i', $horaFinal);

            if ($horaFinalCarbon->greaterThan($limiteHora) || $horaFinalCarbon->lessThan($horaInicio)) {
                DB::rollback();
                return back()->withErrors([
                    'error' => "La hora final calculada ({$horaFinal}) excede el límite permitido de 23:00 (11:00 PM) o cruza la medianoche. " .
                            "Por favor, seleccione una hora de inicio más temprana."
                ])->withInput();
            }

            if ($this->verificarGrupoMateriaEnDia($request->id_grupo, $request->id_materia, $request->dia, $request->gestion, $id)) {
                DB::rollback();
                $grupo = Grupo::find($request->id_grupo);
                $materia = Materia::find($request->id_materia);
                return back()->withErrors([
                    'error' => "El grupo {$grupo->nombre} ya tiene asignada la materia {$materia->nombre} el día {$request->dia}. " .
                            "Un grupo no puede tener la misma materia dos veces en el mismo día."
                ])->withInput();
            }

            $conflictoDocente = Horario::where('id_docente', $request->id_docente)
                ->where('dia', $request->dia)
                ->where('gestion', $request->gestion)
                ->where('id', '!=', $id)
                ->where('activo', true)
                ->where(function($q) use ($horaFinal, $request) {
                    $q->where(function($q2) use ($horaFinal, $request) {
                        $q2->where('hora_inicio', '<', $horaFinal)
                        ->where('hora_final', '>', $request->hora_inicio);
                    });
                })
                ->exists();

            if ($conflictoDocente) {
                return back()->withErrors(['error' => 'El docente ya tiene un horario asignado en ese día y hora.'])->withInput();
            }

            $minutosAnterior = $this->calcularDuracionEnMinutos($horario->hora_inicio, $horario->hora_final);
            $horasAnteriores = (int) round($minutosAnterior / self::MINUTOS_POR_HORA_ACADEMICA);     
            $docenteAnterior = Docente::findOrFail($horario->id_docente);
            $docenteAnterior->carga_horaria_actual = max(0, $docenteAnterior->carga_horaria_actual + $horasAnteriores);
            $docenteAnterior->save();
            $minutosNuevos = $minutosPorDia;
            $horasNuevas = (int) round($minutosNuevos / self::MINUTOS_POR_HORA_ACADEMICA);        
            $docenteNuevo = Docente::findOrFail($request->id_docente);

            if (($docenteNuevo->carga_horaria_actual + $horasNuevas) > $docenteNuevo->carga_horaria_maxima) {
                DB::rollback();
                return back()->withErrors(['error' => 'El docente excedería su carga horaria máxima.'])->withInput();
            }

            $horario->update([
                'dia' => $request->dia,
                'hora_inicio' => $request->hora_inicio,
                'hora_final' => $horaFinal,
                'gestion' => $request->gestion,
                'observaciones' => $request->observaciones,
                'es_virtual' => $request->es_virtual ?? false,
                'id_docente' => $request->id_docente,
                'id_materia' => $request->id_materia,
                'id_grupo' => $request->id_grupo,
                'id_aula' => $request->es_virtual ? null : $request->id_aula,
            ]);

            $docenteNuevo->carga_horaria_actual = $docenteNuevo->carga_horaria_actual + $horasNuevas;
            $docenteNuevo->save();

            Bitacora::create([
                'accion' => 'Actualizar Horario',
                'descripcion' => "Horario actualizado: ID {$id} - {$horasNuevas} hrs académicas",
                'tabla_afectada' => 'horarios',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('horarios.index')->with('success', 'Horario actualizado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al actualizar horario: ' . $e->getMessage());
        }
    }

    public function destroy(string $id)
    {
        $horario = Horario::findOrFail($id);

        DB::beginTransaction();
        try {
            $minutos = $this->calcularDuracionEnMinutos($horario->hora_inicio, $horario->hora_final);
            $horas = (int) round($minutos / self::MINUTOS_POR_HORA_ACADEMICA);
            
            $docente = Docente::findOrFail($horario->id_docente);
            $docente->carga_horaria_actual = max(0, $docente->carga_horaria_actual + $horas);
            $docente->save();

            $horario->update(['activo' => false]);

            Bitacora::create([
                'accion' => 'Desactivar Horario',
                'descripcion' => "Horario desactivado: ID {$id} - {$horas} hrs académicas liberadas",
                'tabla_afectada' => 'horarios',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('horarios.index')->with('success', 'Horario desactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al desactivar horario: ' . $e->getMessage());
        }
    }

    public function inactivos(Request $request)
    {
        $query = Horario::with(['docente.usuario', 'materia', 'grupo', 'aula'])
            ->where('activo', false);

        if ($request->filled('gestion')) {
            $query->where('gestion', $request->gestion);
        }
        if ($request->filled('docente')) {
            $query->where('id_docente', $request->docente);
        }

        $horarios = $query->orderBy('dia')
                        ->orderBy('hora_inicio')
                        ->paginate(20);

        $docentes = Docente::with('usuario')->where('activo', true)->get();
        $gestiones = Horario::select('gestion')->distinct()->pluck('gestion');

        return view('horarios.inactivos', compact('horarios', 'docentes', 'gestiones'));
    }

    public function reactivar(string $id)
    {
        $horario = Horario::findOrFail($id);

        if ($horario->activo) {
            return back()->with('error', 'El horario ya está activo.');
        }

        DB::beginTransaction();
        try {
            if ($this->verificarConflictoDocente($horario->id_docente, $horario->dia, $horario->hora_inicio, $horario->hora_final, $horario->gestion)) {
                return back()->with('error', 'No se puede reactivar: el docente ya tiene un horario asignado en ese día y hora.');
            }

            if (!$horario->es_virtual && $horario->id_aula) {
                if ($this->verificarConflictoAula($horario->id_aula, $horario->dia, $horario->hora_inicio, $horario->hora_final, $horario->gestion)) {
                    return back()->with('error', 'No se puede reactivar: el aula ya está ocupada en ese día y hora.');
                }
            }

            if ($this->verificarConflictoGrupo($horario->id_grupo, $horario->dia, $horario->hora_inicio, $horario->hora_final, $horario->gestion)) {
                return back()->with('error', 'No se puede reactivar: el grupo ya tiene un horario asignado en ese día y hora.');
            }

            $docente = Docente::findOrFail($horario->id_docente);
            $minutos = $this->calcularDuracionEnMinutos($horario->hora_inicio, $horario->hora_final);
            $horas = (int) round($minutos / self::MINUTOS_POR_HORA_ACADEMICA);
            
            if (($docente->carga_horaria_actual + $horas) > $docente->carga_horaria_maxima) {
                return back()->with('error', "No se puede reactivar: el docente excedería su carga horaria máxima.");
            }

            $horario->update(['activo' => true]);
            
            $docente->carga_horaria_actual = $docente->carga_horaria_actual - $horas;
            $docente->save();

            Bitacora::create([
                'accion' => 'Reactivar Horario',
                'descripcion' => "Se reactivó el horario: {$horario->dia} {$horario->hora_inicio}-{$horario->hora_final} (ID: {$id})",
                'tabla_afectada' => 'horarios',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('horarios.inactivos')
                ->with('success', 'Horario reactivado exitosamente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al reactivar horario: ' . $e->getMessage());
        }
    }

    public function forceDestroy(string $id)
    {
        $horario = Horario::findOrFail($id);

        if ($horario->activo) {
            return back()->with('error', 'Solo puedes eliminar permanentemente horarios inactivos.');
        }

        DB::beginTransaction();
        try {
            $descripcion = "Horario eliminado: {$horario->dia} {$horario->hora_inicio}-{$horario->hora_final} - " .
                        "Docente: {$horario->docente->usuario->nombre} {$horario->docente->usuario->apellido}";
            
            $horario->delete();

            Bitacora::create([
                'accion' => 'Eliminar Horario Permanentemente',
                'descripcion' => $descripcion,
                'tabla_afectada' => 'horarios',
                'registro_afectado' => $id,
                'ip_direccion' => request()->ip(),
                'id_usuario' => auth()->id(),
            ]);

            DB::commit();
            return redirect()->route('horarios.inactivos')
                ->with('success', 'Horario eliminado permanentemente.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Error al eliminar horario: ' . $e->getMessage());
        }
    }

    public function misHorarios()
    {
        $docente = Docente::where('id_usuario', auth()->id())->first();
        
        if (!$docente) {
            return redirect()->route('dashboard')
                ->with('error', 'No se encontró información de docente para este usuario.');
        }

        $horarios = Horario::with(['materia', 'grupo', 'aula'])
            ->where('id_docente', $docente->registro)
            ->where('activo', true)
            ->orderBy('dia')
            ->orderBy('hora_inicio')
            ->get();

        $horariosPorDia = $horarios->groupBy('dia');

        return view('docente.mis-horarios', compact('horarios', 'horariosPorDia', 'docente'));
    }

    private function verificarConflictoDocente($idDocente, $dia, $horaInicio, $horaFinal, $gestion)
    {
        return Horario::where('id_docente', $idDocente)
            ->where('dia', $dia)
            ->where('gestion', $gestion)
            ->where('activo', true)
            ->where(function($q) use ($horaInicio, $horaFinal) {
                $q->where(function($q2) use ($horaInicio, $horaFinal) {
                    $q2->where('hora_inicio', '<', $horaFinal)
                    ->where('hora_final', '>', $horaInicio);
                });
            })
            ->exists();
    }

    private function verificarConflictoAula($idAula, $dia, $horaInicio, $horaFinal, $gestion)
    {
        return Horario::where('id_aula', $idAula)
            ->where('dia', $dia)
            ->where('gestion', $gestion)
            ->where('activo', true)
            ->where(function($q) use ($horaInicio, $horaFinal) {
                $q->where(function($q2) use ($horaInicio, $horaFinal) {
                    $q2->where('hora_inicio', '<', $horaFinal)
                    ->where('hora_final', '>', $horaInicio);
                });
            })
            ->exists();
    }

    private function verificarConflictoGrupo($idGrupo, $dia, $horaInicio, $horaFinal, $gestion)
    {
        return Horario::where('id_grupo', $idGrupo)
            ->where('dia', $dia)
            ->where('gestion', $gestion)
            ->where('activo', true)
            ->where(function($q) use ($horaInicio, $horaFinal) {
                $q->where(function($q2) use ($horaInicio, $horaFinal) {
                    $q2->where('hora_inicio', '<', $horaFinal)
                    ->where('hora_final', '>', $horaInicio);
                });
            })
            ->exists();
    }

    private function verificarGrupoMateriaEnDia($idGrupo, $idMateria, $dia, $gestion, $excluirId = null)
    {
        $query = Horario::where('id_grupo', $idGrupo)
            ->where('id_materia', $idMateria)
            ->where('dia', $dia)
            ->where('gestion', $gestion)
            ->where('activo', true);
        
        if ($excluirId) {
            $query->where('id', '!=', $excluirId);
        }
        
        return $query->exists();
    }

    private function calcularDuracionEnMinutos($horaInicio, $horaFinal)
    {
        $inicio = Carbon::createFromFormat('H:i', substr($horaInicio, 0, 5));
        $final = Carbon::createFromFormat('H:i', substr($horaFinal, 0, 5));
        return $final->diffInMinutes($inicio);
    }
}