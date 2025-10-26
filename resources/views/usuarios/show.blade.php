<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Usuario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Header -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800">{{ $usuario->username }}</h3>
                            <p class="text-sm text-gray-600 mt-1">{{ $usuario->nombre }} {{ $usuario->apellido }}</p>
                        </div>
                        <a href="{{ route('usuarios.edit', $usuario->id) }}" 
                           class="inline-flex items-center px-4 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition shadow-sm">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                            </svg>
                            Editar Usuario
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
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->nombre }} {{ $usuario->apellido }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">CI</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->ci }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Sexo</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
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
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->correo }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Teléfono</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->telefono ?? 'No especificado' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Domicilio</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->domicilio ?? 'No especificado' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Información del Sistema -->
                        <div class="bg-purple-50 rounded-lg p-4 border border-purple-200 md:col-span-2">
                            <h4 class="text-sm font-semibold text-purple-800 uppercase tracking-wider mb-3 flex items-center">
                                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
                                </svg>
                                Información del Sistema
                            </h4>
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Usuario</p>
                                    <p class="text-sm font-semibold text-gray-800">{{ $usuario->username }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Rol</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $usuario->rol->nombre ?? 'Sin rol' }}
                                    </span>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Estado</p>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $usuario->activo ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                        {{ $usuario->activo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </div>
                            </div>
                        </div>

                        <!-- Último Acceso -->
                        <div class="bg-gray-50 rounded-lg p-4 border border-gray-200 md:col-span-2">
                            <div class="flex items-center">
                                <svg class="w-5 h-5 text-gray-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <div>
                                    <p class="text-xs font-medium text-gray-600">Último Acceso</p>
                                    <p class="text-sm font-semibold text-gray-800">
                                        {{ $usuario->ultimo_acceso ? $usuario->ultimo_acceso->format('d/m/Y H:i') : 'Nunca ha ingresado' }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer con botón volver -->
                <div class="p-6 border-t border-gray-200 bg-gray-50">
                    <a href="{{ route('usuarios.index') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-gray-600 hover:bg-gray-700 text-white font-medium rounded-lg transition shadow-sm">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver a Usuarios
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>