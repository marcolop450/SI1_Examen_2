<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HorarioController;
use App\Http\Controllers\AsistenciaController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

require __DIR__.'/auth.php';

//Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//Rutas para Coordinador
Route::middleware(['auth', 'role:Coordinador'])->group(function () {
    // Gestión Académica Básica
    Route::resource('docentes', DocenteController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('aulas', AulaController::class);
    
    // Seguridad y Usuarios
    Route::resource('roles', RolController::class);
    Route::resource('permisos', PermisoController::class);
    Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

    // Usuarios
    Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/crear', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('usuarios/{usuario}', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('usuarios/{usuario}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::put('usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
    Route::get('usuarios-inactivos', [UserController::class, 'inactivos'])->name('usuarios.inactivos');
    Route::post('usuarios/{usuario}/reactivar', [UserController::class, 'reactivar'])->name('usuarios.reactivar');
    Route::delete('usuarios/{usuario}/forzar-eliminacion', [UserController::class, 'forceDestroy'])->name('usuarios.forceDestroy');
    Route::get('usuarios-import', [UserController::class, 'importForm'])->name('usuarios.import.form');
    Route::post('usuarios-import', [UserController::class, 'import'])->name('usuarios.import');
    Route::get('usuarios-template', [UserController::class, 'downloadTemplate'])->name('usuarios.template');

    // Gestión de Inactivos (Soft Deletes)
    Route::get('docentes-inactivos', [DocenteController::class, 'inactivos'])->name('docentes.inactivos');
    Route::post('docentes/{docente}/reactivar', [DocenteController::class, 'reactivar'])->name('docentes.reactivar');
    Route::delete('docentes/{docente}/forzar-eliminacion', [DocenteController::class, 'forceDestroy'])->name('docentes.forceDestroy');
    
    Route::get('materias-inactivas', [MateriaController::class, 'inactivos'])->name('materias.inactivos');
    Route::post('materias/{materia}/reactivar', [MateriaController::class, 'reactivar'])->name('materias.reactivar');
    Route::delete('materias/{materia}/forzar-eliminacion', [MateriaController::class, 'forceDestroy'])->name('materias.forceDestroy');
    
    Route::get('aulas-inactivas', [AulaController::class, 'inactivos'])->name('aulas.inactivos');
    Route::post('aulas/{aula}/reactivar', [AulaController::class, 'reactivar'])->name('aulas.reactivar');
    Route::delete('aulas/{aula}/forzar-eliminacion', [AulaController::class, 'forceDestroy'])->name('aulas.forceDestroy');
    
    Route::get('grupos-inactivos', [GrupoController::class, 'inactivos'])->name('grupos.inactivos');
    Route::post('grupos/{grupo}/reactivar', [GrupoController::class, 'reactivar'])->name('grupos.reactivar');
    Route::delete('grupos/{grupo}/forzar-eliminacion', [GrupoController::class, 'forceDestroy'])->name('grupos.forceDestroy');

    // Horarios
    Route::resource('horarios', HorarioController::class);
    Route::get('horarios-inactivos', [HorarioController::class, 'inactivos'])->name('horarios.inactivos');
    Route::post('horarios/{horario}/reactivar', [HorarioController::class, 'reactivar'])->name('horarios.reactivar');
    Route::delete('horarios/{horario}/forzar-eliminacion', [HorarioController::class, 'forceDestroy'])->name('horarios.forceDestroy');
    
    // Consulta de Asistencias (Coordinador puede ver todas)
    Route::get('asistencias/consulta-coordinador', [AsistenciaController::class, 'consultaCoordinador'])->name('asistencias.consulta-coordinador');
});

//Rutas para Docente
Route::middleware(['auth', 'role:Docente'])->group(function () {
    // Horarios del Docente
    Route::get('docente/horarios', [HorarioController::class, 'misHorarios'])->name('docente.horarios');
    
    Route::get('asistencias', [AsistenciaController::class, 'index'])->name('asistencias.index');
    Route::get('asistencias/form/{horario}', [AsistenciaController::class, 'form'])->name('asistencias.form');
    Route::post('asistencias/registrar', [AsistenciaController::class, 'registrar'])->name('asistencias.registrar');
    Route::get('asistencias/historial', [AsistenciaController::class, 'historial'])->name('asistencias.historial');
    
    // Agregar estas dos para justificaciones:
    Route::get('asistencias/justificar/{id}', [AsistenciaController::class, 'justificarForm'])->name('asistencias.justificar.form');
    Route::post('asistencias/justificar/{id}', [AsistenciaController::class, 'justificar'])->name('asistencias.justificar.store');
});

// ============================================
// RUTAS PARA AUTORIDAD ACADÉMICA
// ============================================
Route::middleware(['auth', 'role:Autoridad'])->group(function () {
    
    // Consulta de Horarios - VISTA ESPECÍFICA PARA AUTORIDAD
    Route::get('horarios-consulta', [HorarioController::class, 'consulta'])
        ->name('horarios.consulta');
    
    // Consulta de Asistencias - VISTA ESPECÍFICA PARA AUTORIDAD
    Route::get('asistencias/consulta-autoridad', [AsistenciaController::class, 'consultaAutoridad'])
        ->name('asistencias.consulta-autoridad');
});

// ============================================
// MÓDULO DE REPORTES - ACCESO COMPARTIDO
// Solo requiere autenticación, verificación en controlador
// ============================================
Route::middleware(['auth'])->prefix('reportes')->name('reportes.')->group(function() {
    // Vista principal del centro de reportes
    Route::get('/', [ReporteController::class, 'index'])->name('index');
    
    // Dashboard en tiempo real
    Route::get('/dashboard-tiempo-real', [ReporteController::class, 'dashboardTiempoReal'])
        ->name('dashboard-tiempo-real');
    
    // Reportes específicos con filtros
    Route::get('/horarios', [ReporteController::class, 'horarios'])->name('horarios');
    Route::get('/asistencias', [ReporteController::class, 'asistencias'])->name('asistencias');
    Route::get('/aulas', [ReporteController::class, 'aulas'])->name('aulas');
    
    // Búsqueda de aulas disponibles por franja horaria
    Route::get('/aulas-disponibles', [ReporteController::class, 'aulasDisponibles'])
        ->name('aulas-disponibles');
    
    // Carga horaria por docente (con parámetro opcional)
    Route::get('/carga-horaria-docente/{idDocente?}', [ReporteController::class, 'cargaHorariaDocente'])
        ->name('carga-horaria-docente');
    
    // Exportaciones PDF
    Route::get('/exportar/asistencias-pdf', [ReporteController::class, 'exportarAsistenciasPDF'])
        ->name('exportar.asistencias-pdf');
    Route::get('/exportar/carga-horaria-pdf/{idDocente}', [ReporteController::class, 'exportarCargaHorariaPDF'])
        ->name('exportar.carga-horaria-pdf');
    Route::get('/exportar/horarios/pdf', [ReporteController::class, 'exportarHorariosPDF'])
        ->name('exportar.horarios-pdf');    
    Route::get('/exportar/aulas/pdf', [ReporteController::class, 'exportarAulasPDF'])
        ->name('exportar.aulas-pdf');
    
    // Exportaciones Excel
    Route::get('/exportar/asistencias/excel', [ReporteController::class, 'exportarAsistenciasExcel'])->name('exportar.asistencias-excel');
    Route::get('/exportar/horarios/excel', [ReporteController::class, 'exportarHorariosExcel'])->name('exportar.horarios-excel');
    Route::get('/exportar/aulas/excel', [ReporteController::class, 'exportarAulasExcel'])->name('exportar.aulas-excel');
    Route::get('/exportar/carga-horaria/{idDocente}/excel', [ReporteController::class, 'exportarCargaHorariaExcel'])->name('exportar.carga-horaria-excel');
});

Route::get('/debug/timezone', function () {
    $now = \Carbon\Carbon::now('America/La_Paz');
    
    return response()->json([
        'servidor' => [
            'php_timezone' => date_default_timezone_get(),
            'date()' => date('Y-m-d H:i:s'),
            'gmdate_utc' => gmdate('Y-m-d H:i:s'),
        ],
        'config' => [
            'app_timezone' => config('app.timezone'),
            'db_timezone' => config('database.connections.pgsql.timezone'),
        ],
        'carbon' => [
            'now_sin_timezone' => \Carbon\Carbon::now()->toDateTimeString(),
            'now_lapaz' => $now->toDateTimeString(),
            'timezone' => $now->timezoneName,
        ],
        'database' => [
            'timezone_db' => DB::selectOne("SHOW timezone")->timezone ?? 'N/A',
        ],
        'prueba_asistencia' => [
            'hora_actual' => $now->format('H:i:s'),
            'ejemplo_clase_14_30' => [
                'hora_inicio' => '14:30:00',
                'puede_registrar_desde' => $now->copy()->setTime(14, 20, 0)->format('H:i:s'),
                'puede_registrar_hasta' => $now->copy()->setTime(14, 50, 0)->format('H:i:s'),
            ],
        ],
    ]);
})->middleware('auth');

Route::get('/ver-logs', function () {
    $logFile = storage_path('logs/laravel.log');
    
    if (!file_exists($logFile)) {
        return 'No hay archivo de logs';
    }
    
    $lines = file($logFile);
    $lastLines = array_slice($lines, -100); // Últimas 100 líneas
    
    return '<pre>' . implode('', $lastLines) . '</pre>';
})->middleware('auth');