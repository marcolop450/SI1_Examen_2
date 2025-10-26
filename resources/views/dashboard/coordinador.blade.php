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
            <!-- Bienvenida Mejorada -->
            <div class="bg-gradient-to-r from-blue-600 via-blue-700 to-blue-800 overflow-hidden shadow-xl rounded-2xl p-8 mb-8 relative">
                <div class="absolute top-0 right-0 -mt-4 -mr-4 h-32 w-32 bg-blue-500 rounded-full opacity-20 blur-3xl"></div>
                <div class="absolute bottom-0 left-0 -mb-4 -ml-4 h-24 w-24 bg-blue-400 rounded-full opacity-20 blur-2xl"></div>
                
                <div class="relative z-10">
                    <div class="flex items-center space-x-3 mb-3">
                        <div class="h-12 w-12 bg-white/20 rounded-full flex items-center justify-center backdrop-blur-sm">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">
                                ¡Bienvenido, {{ $user->nombre }} {{ $user->apellido }}!
                            </h3>
                            <p class="text-blue-100 mt-1">Sistema de Gestión Académica - FICCT</p>
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

            <!-- Módulo: Seguridad y Usuarios -->
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
                        <p class="text-sm text-gray-600">Administrar roles y permisos de acceso al sistema</p>
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

            <!-- Módulo: Gestión Académica Básica -->
            <div>
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
        </div>
    </div>
</x-app-layout>