<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Materia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $materia->codigo }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $materia->nombre }}</p>
                        </div>
                        <a href="{{ route('materias.edit', $materia->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Materia
                        </a>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Información Básica -->
                        <div class="bg-blue-50 rounded-lg p-4 border border-blue-200">
                            <h4 class="text-sm font-semibold text-blue-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Información Básica
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Código</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $materia->codigo }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Nombre</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $materia->nombre }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Semestre</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-purple-100 text-purple-800">
                                        {{ $materia->semestre }}º Semestre
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Carga Horaria -->
                        <div class="bg-green-50 rounded-lg p-4 border border-green-200">
                            <h4 class="text-sm font-semibold text-green-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Carga Horaria
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Horas Teóricas</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $materia->horas_teoricas }} horas/semana</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Horas Prácticas</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $materia->horas_practicas }} horas/semana</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Total Horas</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $materia->horas_teoricas + $materia->horas_practicas }} horas/semana</p>
                                </div>
                            </div>
                        </div>

                        <!-- Créditos y Estado -->
                        <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                            <h4 class="text-sm font-semibold text-orange-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                                </svg>
                                Créditos y Estado
                            </h4>
                            <div class="space-y-3">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Créditos</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $materia->creditos }} créditos
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Estado</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $materia->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $materia->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Contenido -->
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200 md:col-span-2">
                            <h4 class="text-sm font-semibold text-purple-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7"/>
                                </svg>
                                Contenido de la Materia
                            </h4>
                            <p class="text-sm text-gray-700">
                                {{ $materia->contenido ?? 'Sin contenido especificado' }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Footer con botón volver -->
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('materias.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver a Materias
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>