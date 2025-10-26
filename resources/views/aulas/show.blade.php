<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Aula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $aula->nombre }}</h3>
                            <p class="text-sm text-gray-600 mt-1">Información detallada del aula</p>
                        </div>
                        <a href="{{ route('aulas.edit', $aula->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Aula
                        </a>
                    </div>
                </div>

                <!-- Contenido -->
                <div class="p-6 space-y-6">
                    <!-- Información Principal -->
                    <div class="bg-blue-50 rounded-lg p-5 border border-blue-200">
                        <h4 class="text-sm font-semibold text-blue-800 uppercase tracking-wider mb-4 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Información del Aula
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Nombre</p>
                                <p class="text-lg font-bold text-gray-900">{{ $aula->nombre }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Tipo de Aula</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium 
                                    @if($aula->tipo == 'Laboratorio') bg-purple-100 text-purple-800
                                    @elseif($aula->tipo == 'Auditorio') bg-amber-100 text-amber-800
                                    @else bg-blue-100 text-blue-800 @endif">
                                    {{ $aula->tipo }}
                                </span>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Piso</p>
                                <p class="text-sm font-semibold text-gray-800">{{ $aula->piso ?? 'No especificado' }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-medium text-gray-600 mb-1">Estado</p>
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{ $aula->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    <span class="w-2 h-2 rounded-full mr-2 {{ $aula->activo ? 'bg-green-600' : 'bg-red-600' }}"></span>
                                    {{ $aula->activo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- Capacidad -->
                    <div class="bg-green-50 rounded-lg p-5 border border-green-200">
                        <h4 class="text-sm font-semibold text-green-800 uppercase tracking-wider mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                            </svg>
                            Capacidad
                        </h4>
                        <div class="flex items-center">
                            <div class="flex-1">
                                <p class="text-3xl font-bold text-green-900">{{ $aula->capacidad }}</p>
                                <p class="text-sm text-gray-600 mt-1">personas</p>
                            </div>
                            <div class="ml-4">
                                <svg class="w-16 h-16 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Equipamiento -->
                    <div class="bg-purple-50 rounded-lg p-5 border border-purple-200">
                        <h4 class="text-sm font-semibold text-purple-800 uppercase tracking-wider mb-3 flex items-center">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            Equipamiento
                        </h4>
                        <p class="text-sm text-gray-800 leading-relaxed">
                            {{ $aula->equipamiento ?? 'Sin equipamiento especificado' }}
                        </p>
                    </div>
                </div>

                <!-- Footer con botón volver -->
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('aulas.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver a Aulas
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>