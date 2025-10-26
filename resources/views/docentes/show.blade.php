<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Docente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">Registro: {{ $docente->registro }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</p>
                        </div>
                        <a href="{{ route('docentes.edit', $docente->registro) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Docente
                        </a>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Personal -->
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                Información Personal
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Nombre Completo</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">CI</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->ci }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Sexo</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h4 class="text-sm font-semibold text-green-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Contacto
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Correo Electrónico</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->correo }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Teléfono</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->telefono ?? 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información Académica -->
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200">
                            <h4 class="text-sm font-semibold text-purple-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                </svg>
                                Información Académica
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Carrera</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->carrera ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Especialidad</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->especialidad ?? 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información Laboral -->
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <h4 class="text-sm font-semibold text-orange-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Información Laboral
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Fecha de Ingreso</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->fecha_ingreso->format('d/m/Y') }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Carga Horaria</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $docente->carga_horaria_actual }}/{{ $docente->carga_horaria_maxima }} horas
                                    </p>
                                    <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-blue-600 h-2 rounded-full" 
                                             style="width: {{ ($docente->carga_horaria_actual / $docente->carga_horaria_maxima) * 100 }}%"></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 md:col-span-2">
                            <h4 class="text-sm font-semibold text-gray-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Información del Sistema
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Registro</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->registro }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Usuario</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $docente->usuario->username }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Estado</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $docente->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con botón volver -->
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('docentes.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver a Docentes
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>