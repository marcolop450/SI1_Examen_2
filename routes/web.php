<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DocenteController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\BitacoraController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\RolController;
use App\Http\Controllers\GrupoController;
use App\Http\Controllers\AulaController;
use App\Http\Controllers\DashboardController;
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
    Route::resource('docentes', DocenteController::class);
    Route::resource('materias', MateriaController::class);
    Route::resource('grupos', GrupoController::class);
    Route::resource('aulas', AulaController::class);
    Route::resource('roles', RolController::class);
    Route::resource('permisos', PermisoController::class);
    Route::get('bitacora', [BitacoraController::class, 'index'])->name('bitacora.index');

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

    Route::get('usuarios-import', [UserController::class, 'importForm'])->name('usuarios.import.form');
    Route::post('usuarios-import', [UserController::class, 'import'])->name('usuarios.import');
    Route::get('usuarios-template', [UserController::class, 'downloadTemplate'])->name('usuarios.template');
});

//Rutas para Docente
Route::middleware(['auth', 'role:Docente'])->group(function () {
    Route::get('/mi-horario', function() {
        return view('docente.horario');
    })->name('docente.horario');
});

//Rutas para Autoridad
Route::middleware(['auth', 'role:Autoridad'])->group(function () {
    Route::get('/reportes', function() {
        return view('autoridad.reportes');
    })->name('autoridad.reportes');
});