<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Panel de Control - Docente
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-white">
                                ¡Bienvenido, {{ $user->nombre }} {{ $user->apellido }} ({{ $user->username }})!
                            </h3>
                            <p class="text-blue-100 mt-1">Panel de Docente - Sistema Académico</p>
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

            <!-- Módulos Disponibles -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Horarios -->
                <a href="{{ route('docente.horarios') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-green-50 hover:to-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 shadow-sm group-hover:from-green-200 group-hover:to-green-100 transition-colors">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 group-hover:text-green-700 transition-colors">Mis Horarios</h4>
                                <p class="text-gray-600">Ver horarios asignados</p>
                            </div>
                        </div>

                        <div class="bg-green-50 border-l-4 border-green-500 p-6 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-green-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h5 class="text-lg font-semibold text-green-900 mb-2">Funcionalidades</h5>
                                    <ul class="text-green-800 space-y-1 text-sm">
                                        <li>• Ver horario de clases</li>
                                        <li>• Consultar aulas asignadas</li>
                                        <li>• Revisar calendario académico</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>

                <!-- Asistencia - ACTUALIZADO -->
                <a href="{{ route('asistencias.index') }}" 
                   class="group bg-white hover:bg-gradient-to-br hover:from-blue-50 hover:to-white overflow-hidden shadow-xl rounded-2xl border border-gray-100 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 shadow-sm group-hover:from-blue-200 group-hover:to-blue-100 transition-colors">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800 group-hover:text-blue-700 transition-colors">Registro de Asistencia</h4>
                                <p class="text-gray-600">Registra tu asistencia</p>
                            </div>
                        </div>

                        <div class="bg-blue-50 border-l-4 border-blue-500 p-6 rounded-lg">
                            <div class="flex items-start">
                                <svg class="w-6 h-6 text-blue-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <h5 class="text-lg font-semibold text-blue-900 mb-2">Funcionalidades</h5>
                                    <ul class="text-blue-800 space-y-1 text-sm">
                                        <li>• Registro manual por formulario</li>
                                        <li>• Registro por código QR</li>
                                        <li>• Ver historial de asistencia</li>
                                        <li>• Consultar estadísticas</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <!-- Accesos Rápidos -->
            <div class="mt-8 grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('asistencias.index') }}" 
                   class="flex items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition-all border border-gray-100 hover:border-blue-300">
                    <div class="bg-blue-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800">Registrar Ahora</h6>
                        <p class="text-xs text-gray-600">Registro rápido de asistencia</p>
                    </div>
                </a>

                <a href="{{ route('asistencias.historial') }}" 
                   class="flex items-center p-4 bg-white rounded-lg shadow hover:shadow-md transition-all border border-gray-100 hover:border-purple-300">
                    <div class="bg-purple-100 rounded-lg p-3 mr-4">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h6 class="font-semibold text-gray-800">Ver Historial</h6>
                        <p class="text-xs text-gray-600">Consulta tus registros</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</x-app-layout>