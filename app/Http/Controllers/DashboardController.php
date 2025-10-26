<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        //Sacamos el usuario
        $user = auth()->user();
        $rol = $user->rol->nombre ?? 'Sin Rol';

        //Redirigir según el rol
        switch ($rol) {
            case 'Coordinador':
                return view('dashboard.coordinador', compact('user'));
            
            case 'Docente':
                return view('dashboard.docente', compact('user'));
            
            case 'Autoridad':
                return view('dashboard.autoridad', compact('user'));
            
            default:
                return view('dashboard', compact('user'));
        }
    }
}