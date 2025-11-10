<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Control - Autoridad
            </h2>
            <div class="flex items-center space-x-2">
                <div class="h-2 w-2 bg-green-500 rounded-full animate-pulse"></div>
                <span class="text-sm text-gray-600">En línea</span>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 overflow-hidden shadow-xl rounded-2xl p-8 mb-8 relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 bg-blue-500 rounded-full opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-24 w-24 bg-blue-400 rounded-full opacity-20 blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">
                                ¡Bienvenido, {{ Auth::user()->nombre }} {{ Auth::user()->apellido }} ({{ $user->username }})!
                            </h3>
                            <p class="text-blue-100 mt-1">Panel de Autoridad Académica</p>
                        </div>
                    </div>
                    <div class="mt-4 flex items-center space-x-2 text-blue-100 text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <span>{{ now()->locale('es')->isoFormat('dddd, D [de] MMMM [de] YYYY') }}</span>
                    </div>
                </div>
            </div>

            <!-- Módulo: Consulta de Horarios -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-8">
                <div class="p-8">
                    <div class="flex items-center mb-6">
                        <div class="bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl p-3 mr-4 shadow-lg">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-2xl font-bold text-gray-800">Consulta de Horarios</h4>
                            <p class="text-sm text-gray-500">Visualización de horarios académicos</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Consultar Horarios -->
                        <a href="{{ route('horarios.consulta') }}" 
                           class="group bg-white hover:bg-gradient-to-br hover:from-purple-50 hover:to-white rounded-xl shadow-md hover:shadow-2xl transition-all duration-300 p-6 border border-gray-100 hover:border-purple-200 transform hover:-translate-y-1">
                            <div class="flex items-start justify-between mb-4">
                                <div class="bg-gradient-to-br from-purple-100 to-purple-50 rounded-xl p-4 group-hover:from-purple-200 group-hover:to-purple-100 transition-colors shadow-sm">
                                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                    </svg>
                                </div>
                                <span class="text-purple-600 group-hover:translate-x-2 transition-transform text-2xl">→</span>
                            </div>
                            <h5 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-purple-700 transition-colors">Consultar Horarios</h5>
                            <p class="text-sm text-gray-600">Ver horarios de docentes, grupos y aulas</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Módulo: Control de Asistencia -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 mb-8">
                <div class="p-8">
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

                    <div class="grid grid-cols-1 md:grid-cols-1 gap-6">
                        <!-- Consultar Asistencias -->
                        <a href="{{ route('asistencias.consulta-autoridad') }}" 
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
                            <p class="text-sm text-gray-600">Ver y supervisar registros de asistencia de todos los docentes</p>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Módulo: Reportes Académicos - RENOVADO -->
            <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                <div class="p-8">
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
            </div>

        </div>
    </div>
</x-app-layout>