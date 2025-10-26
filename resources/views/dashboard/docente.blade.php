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
                                ¡Bienvenido, {{ $user->nombre }} {{ $user->apellido }}!
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
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-gradient-to-br from-green-100 to-green-50 rounded-xl p-4 shadow-sm">
                                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">Mis Horarios</h4>
                                <p class="text-gray-600">Próximamente</p>
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
                </div>

                <!-- Asistencia -->
                <div class="bg-white overflow-hidden shadow-xl rounded-2xl border border-gray-100">
                    <div class="p-8">
                        <div class="flex items-center space-x-4 mb-6">
                            <div class="bg-gradient-to-br from-blue-100 to-blue-50 rounded-xl p-4 shadow-sm">
                                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                                </svg>
                            </div>
                            <div>
                                <h4 class="text-2xl font-bold text-gray-800">Registro de Asistencia</h4>
                                <p class="text-gray-600">Próximamente</p>
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
                                        <li>• Registrar asistencia de estudiantes</li>
                                        <li>• Ver historial de asistencia</li>
                                        <li>• Generar reportes</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Información Adicional -->
            <div class="mt-6 bg-gradient-to-r from-amber-50 to-amber-100 border border-amber-200 rounded-2xl p-6 shadow-md">
                <div class="flex items-start">
                    <div class="bg-amber-200 rounded-lg p-2 mr-4">
                        <svg class="w-6 h-6 text-amber-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div>
                        <h5 class="text-lg font-semibold text-amber-900 mb-1">Módulos en Desarrollo</h5>
                        <p class="text-amber-800">Estamos trabajando para brindarte las mejores herramientas para la gestión de tus clases. Pronto podrás acceder a todas las funcionalidades.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>