<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Control - Coordinador
            </h2>
            <div class="flex items-center space-x-2">
                <div class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm text-gray-600">En línea</span>
            </div>
        </div>
    </x-slot>

    <div class="py-8 sm:py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Bienvenida Mejorada con Estadísticas Rápidas -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 overflow-hidden shadow-xl rounded-2xl mb-8 relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 bg-blue-500 rounded-full opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-24 w-24 bg-blue-400 rounded-full opacity-20 blur-2xl"></div>
                
                <div class="relative z-10 p-8">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                        <!-- Información del Usuario -->
                        <div>
                            <div class="flex items-center space-x-3 mb-3">
                                <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-3xl font-bold text-white">
                                        ¡Bienvenido, {{ $user->nombre }}!
                                    </h3>
                                    <p class="text-blue-100 mt-1">Sistema de Gestión Académica - FICCT</p>
                                </div>
                            </div>
                            <div class="flex items-center space-x-2 text-blue-100 text-sm">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Accesos Rápidos Destacados -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-10">
                <!-- Crear Horario -->
                <a href="{{ route('horarios.create') }}" 
                   class="group relative bg-gradient-to-br from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-white overflow-hidden transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Crear Horario</h3>
                        <p class="text-teal-100 text-sm">Asigna nuevos horarios rápidamente</p>
                    </div>
                </a>

                <!-- Consultar Asistencias -->
                <a href="{{ route('asistencias.consulta-coordinador') }}" 
                   class="group relative bg-gradient-to-br from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-white overflow-hidden transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Ver Asistencias</h3>
                        <p class="text-orange-100 text-sm">Supervisa asistencias docentes</p>
                    </div>
                </a>

                <!-- Gestionar Usuarios -->
                <a href="{{ route('usuarios.index') }}" 
                   class="group relative bg-gradient-to-br from-indigo-500 to-indigo-600 hover:from-indigo-600 hover:to-indigo-700 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 p-6 text-white overflow-hidden transform hover:scale-105">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 h-24 w-24 bg-white/10 rounded-full blur-2xl"></div>
                    <div class="relative z-10">
                        <div class="flex items-center justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-3 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <svg class="w-6 h-6 group-hover:translate-x-2 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold mb-2">Gestionar Usuarios</h3>
                        <p class="text-indigo-100 text-sm">Administra accesos al sistema</p>
                    </div>
                </a>
            </div>

            <!-- Módulo: Seguridad y Usuarios (PQ1) -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Seguridad y Usuarios</h4>
                        <p class="text-sm text-gray-500">Gestiona el acceso y permisos del sistema</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Roles y Permisos -->
                    <a href="{{ route('roles.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-4 group-hover:from-purple-200 group-hover:to-purple-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                            </div>
                            <span class="text-purple-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors">Roles y Permisos</h5>
                        <p class="text-sm text-gray-600">Administrar roles y permisos de acceso</p>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">Sistema de control de accesos</span>
                        </div>
                    </a>

                    <!-- Usuarios -->
                    <a href="{{ route('usuarios.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-indigo-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl p-4 group-hover:from-indigo-200 group-hover:to-indigo-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                                </svg>
                            </div>
                            <span class="text-indigo-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-700 transition-colors">Usuarios</h5>
                        <p class="text-sm text-gray-600">Administrar usuarios del sistema académico</p>
                    </a>

                    <!-- Bitácora -->
                    <a href="{{ route('bitacora.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-gray-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-gray-300 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-gray-100 to-gray-50 rounded-xl p-4 group-hover:from-gray-200 group-hover:to-gray-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <span class="text-gray-700 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-gray-900 transition-colors">Bitácora</h5>
                        <p class="text-sm text-gray-600">Ver historial de actividades del sistema</p>
                    </a>
                </div>
            </div>

            <!-- Módulo: Gestión Académica Básica (PQ2) -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Gestión Académica Básica</h4>
                        <p class="text-sm text-gray-500">Administra recursos académicos principales</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Docentes -->
                    <a href="{{ route('docentes.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 group-hover:from-blue-200 group-hover:to-blue-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-blue-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-700 transition-colors">Docentes</h5>
                        <p class="text-sm text-gray-600">Administrar docentes</p>
                    </a>

                    <!-- Materias -->
                    <a href="{{ route('materias.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 group-hover:from-green-200 group-hover:to-green-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-green-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-700 transition-colors">Materias</h5>
                        <p class="text-sm text-gray-600">Administrar materias</p>
                    </a>

                    <!-- Grupos -->
                    <a href="{{ route('grupos.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-amber-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl p-4 group-hover:from-amber-200 group-hover:to-amber-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-amber-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-amber-700 transition-colors">Grupos</h5>
                        <p class="text-sm text-gray-600">Administrar grupos</p>
                    </a>

                    <!-- Aulas -->
                    <a href="{{ route('aulas.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-red-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-red-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-4 group-hover:from-red-200 group-hover:to-red-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="text-red-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-red-700 transition-colors">Aulas</h5>
                        <p class="text-sm text-gray-600">Administrar aulas</p>
                    </a>
                </div>
            </div>

            <!-- Módulo: Gestión Académica Básica (PQ2) -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Gestión Académica Básica</h4>
                        <p class="text-sm text-gray-500">Administra recursos académicos principales</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <!-- Docentes -->
                    <a href="{{ route('docentes.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 group-hover:from-blue-200 group-hover:to-blue-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-blue-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-blue-700 transition-colors">Docentes</h5>
                        <p class="text-sm text-gray-600">Administrar docentes</p>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ \App\Models\Docente::where('activo', true)->count() }} docentes activos</span>
                        </div>
                    </a>

                    <!-- Materias -->
                    <a href="{{ route('materias.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 group-hover:from-green-200 group-hover:to-green-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                            </div>
                            <span class="text-green-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-green-700 transition-colors">Materias</h5>
                        <p class="text-sm text-gray-600">Administrar materias</p>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ \App\Models\Materia::where('activo', true)->count() }} materias activas</span>
                        </div>
                    </a>

                    <!-- Grupos -->
                    <a href="{{ route('grupos.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-amber-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-amber-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-amber-100 to-amber-50 rounded-xl p-4 group-hover:from-amber-200 group-hover:to-amber-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                            <span class="text-amber-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-amber-700 transition-colors">Grupos</h5>
                        <p class="text-sm text-gray-600">Administrar grupos</p>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ \App\Models\Grupo::where('activo', true)->count() }} grupos activos</span>
                        </div>
                    </a>

                    <!-- Aulas -->
                    <a href="{{ route('aulas.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-red-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-red-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-4 group-hover:from-red-200 group-hover:to-red-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="text-red-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-red-700 transition-colors">Aulas</h5>
                        <p class="text-sm text-gray-600">Administrar aulas</p>
                        <div class="mt-3 pt-3 border-t border-gray-100">
                            <span class="text-xs text-gray-500">{{ \App\Models\Aula::where('activo', true)->count() }} aulas disponibles</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Módulo: Asignación de Horarios (PQ3) -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Asignación de Horarios</h4>
                        <p class="text-sm text-gray-500">Gestiona la programación de clases</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Gestionar Horarios -->
                    <a href="{{ route('horarios.index') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-teal-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-teal-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-teal-100 to-teal-50 rounded-xl p-4 group-hover:from-teal-200 group-hover:to-teal-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-teal-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-teal-700 transition-colors">Gestionar Horarios</h5>
                        <p class="text-sm text-gray-600">Administra horarios académicos, asigna clases a docentes y previene conflictos</p>
                    </a>

                    <!-- Crear Nuevo Horario -->
                    <a href="{{ route('horarios.create') }}" 
                       class="group bg-gradient-to-br from-teal-500 to-teal-600 hover:from-teal-600 hover:to-teal-700 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-teal-600 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-white/20 rounded-xl p-4 backdrop-blur-sm">
                                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                                </svg>
                            </div>
                            <span class="text-white group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-white mb-2">Crear Nuevo Horario</h5>
                        <p class="text-sm text-teal-100">Asigna rápidamente nuevos horarios de clases (7:00 AM - 21:15 PM)</p>
                        <div class="mt-3 pt-3 border-t border-white/20">
                            <span class="text-xs text-white/80">Intervalos de 45 minutos</span>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Módulo: Control de Asistencia (PQ4) -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Control de Asistencia</h4>
                        <p class="text-sm text-gray-500">Supervisión y reportes de asistencia docente</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Consultar Asistencias -->
                    <a href="{{ route('asistencias.consulta-coordinador') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-orange-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-orange-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-orange-100 to-orange-50 rounded-xl p-4 group-hover:from-orange-200 group-hover:to-orange-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                                </svg>
                            </div>
                            <span class="text-orange-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                        </div>
                        <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-orange-700 transition-colors">Consultar Asistencias</h5>
                        <p class="text-sm text-gray-600">Supervisa y verifica registros de asistencia de todos los docentes</p>
                    </a>
                </div>
            </div>
            <!-- Módulo: Reportes Académicos -->
            <div class="mb-10">
                <div class="flex items-center mb-6">
                    <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl p-3 mr-4 shadow-lg">
                        <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <div>
                        <h4 class="text-2xl font-bold text-gray-800">Reportes Académicos</h4>
                        <p class="text-sm text-gray-500">Centro completo de análisis y estadísticas</p>
                    </div>
                </div>

                <!-- Reportes Principales (Grid de 3 columnas) -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <!-- Dashboard Tiempo Real -->
                    <a href="{{ route('reportes.dashboard-tiempo-real') }}" 
                       class="group bg-gradient-to-br from-red-50 to-white hover:from-red-100 hover:to-red-50 rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border-2 border-red-200 hover:border-red-400 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-red-100 to-red-50 rounded-xl p-4 group-hover:from-red-200 group-hover:to-red-100 transition-colors shadow-md">
                                <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                            </div>
                            <span class="bg-red-100 text-red-700 text-xs font-bold px-3 py-1 rounded-full animate-pulse">EN VIVO</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-red-700 transition-colors">Dashboard Tiempo Real</h5>
                        <p class="text-sm text-gray-600">Monitoreo de clases en curso</p>
                    </a>

                    <!-- Reporte de Horarios -->
                    <a href="{{ route('reportes.horarios') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-blue-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 group-hover:from-blue-200 group-hover:to-blue-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <span class="text-blue-600 group-hover:translate-x-2 transition-transform text-xl">→</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-blue-700 transition-colors">Horarios</h5>
                        <p class="text-sm text-gray-600">Análisis de carga académica</p>
                    </a>

                    <!-- Reporte de Asistencias -->
                    <a href="{{ route('reportes.asistencias') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-green-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 group-hover:from-green-200 group-hover:to-green-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <span class="text-green-600 group-hover:translate-x-2 transition-transform text-xl">→</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-green-700 transition-colors">Asistencias</h5>
                        <p class="text-sm text-gray-600">Estadísticas de puntualidad</p>
                    </a>

                    <!-- Reporte de Aulas -->
                    <a href="{{ route('reportes.aulas') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-4 group-hover:from-purple-200 group-hover:to-purple-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                </svg>
                            </div>
                            <span class="text-purple-600 group-hover:translate-x-2 transition-transform text-xl">→</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors">Aulas</h5>
                        <p class="text-sm text-gray-600">Ocupación de espacios</p>
                    </a>

                    <!-- Aulas Disponibles -->
                    <a href="{{ route('reportes.aulas-disponibles') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-indigo-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-indigo-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-indigo-100 to-indigo-50 rounded-xl p-4 group-hover:from-indigo-200 group-hover:to-indigo-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <span class="text-indigo-600 group-hover:translate-x-2 transition-transform text-xl">→</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-indigo-700 transition-colors">Buscar Aulas</h5>
                        <p class="text-sm text-gray-600">Disponibilidad por horario</p>
                    </a>

                    <!-- Carga Horaria Docente -->
                    <a href="{{ route('reportes.carga-horaria-docente') }}" 
                       class="group bg-white hover:bg-gradient-to-br hover:from-yellow-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-yellow-200 transform hover:-translate-y-1">
                        <div class="flex items-start justify-between mb-4">
                            <div class="bg-gradient-to-br from-yellow-100 to-yellow-50 rounded-xl p-4 group-hover:from-yellow-200 group-hover:to-yellow-100 transition-colors shadow-sm">
                                <svg class="w-8 h-8 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                            </div>
                            <span class="text-yellow-600 group-hover:translate-x-2 transition-transform text-xl">→</span>
                        </div>
                        <h5 class="text-lg font-bold text-gray-800 mb-2 group-hover:text-yellow-700 transition-colors">Carga Horaria</h5>
                        <p class="text-sm text-gray-600">Por docente individual</p>
                    </a>
                </div>

                <!-- Botón Principal de Reportes -->
                <div class="pt-4 border-t border-gray-200">
                    <a href="{{ route('reportes.index') }}" 
                       class="group flex items-center justify-center w-full bg-gradient-to-r from-green-500 to-green-600 hover:from-green-600 hover:to-green-700 text-white font-semibold py-4 px-6 rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
                        <svg class="w-5 h-5 mr-2 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                        </svg>
                        <span>Centro Completo de Reportes</span>
                        <svg class="w-5 h-5 ml-2 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                        </svg>
                    </a>
                </div>

                <!-- Características de Reportes -->
                <div class="mt-6 bg-gradient-to-br from-green-50 to-emerald-50 border-2 border-green-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <h5 class="text-sm font-bold text-green-900 mb-3">✨ Características del Sistema de Reportes:</h5>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-2 text-green-800 text-xs">
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Dashboard en tiempo real con clases activas</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Rankings de puntualidad docente</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Análisis de ocupación de aulas</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Búsqueda de espacios disponibles</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Filtros avanzados por período y docente</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Exportación a PDF y Excel</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Gráficos y visualizaciones interactivas</span>
                                </div>
                                <div class="flex items-center">
                                    <span class="text-green-600 mr-2">✓</span>
                                    <span>Alertas de clases sin asistencia</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Sección de Ayuda Rápida -->
            <div class="bg-gradient-to-br from-gray-50 to-white rounded-2xl shadow-lg p-8 border border-gray-200">
                <div class="flex items-start space-x-4">
                    <div class="bg-blue-100 rounded-xl p-3 flex-shrink-0">
                        <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <h3 class="text-xl font-bold text-gray-800 mb-2">¿Necesitas ayuda?</h3>
                        <p class="text-gray-600 mb-4">Información útil para gestionar el sistema académico</p>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="h-2 w-2 bg-teal-500 rounded-full"></div>
                                    <span class="font-semibold text-gray-800 text-sm">Horarios</span>
                                </div>
                                <p class="text-xs text-gray-600">Intervalos de 45 min (7:00 AM - 21:15 PM). Total: 270 min semanales por materia.</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="h-2 w-2 bg-orange-500 rounded-full"></div>
                                    <span class="font-semibold text-gray-800 text-sm">Asistencias</span>
                                </div>
                                <p class="text-xs text-gray-600">Los docentes registran entrada y salida. Revisa el cumplimiento desde la consulta.</p>
                            </div>
                            <div class="bg-white rounded-lg p-4 border border-gray-200">
                                <div class="flex items-center space-x-2 mb-2">
                                    <div class="h-2 w-2 bg-purple-500 rounded-full"></div>
                                    <span class="font-semibold text-gray-800 text-sm">Seguridad</span>
                                </div>
                                <p class="text-xs text-gray-600">Todas las acciones quedan registradas en la bitácora del sistema.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>