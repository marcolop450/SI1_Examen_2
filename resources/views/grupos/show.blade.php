<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Grupo
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-lg font-bold">Información del Grupo</h3>
                    <a href="{{ route('grupos.edit', $grupo->id) }}" 
                       style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        Editar
                    </a>
                </div>

                <div style="display: grid; gap: 1.5rem;">
                    <div>
                        <strong style="color: #6b7280;">Nombre:</strong>
                        <p style="margin-top: 0.25rem; font-size: 1.5rem; font-weight: bold;">{{ $grupo->nombre }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Turno:</strong>
                        <p style="margin-top: 0.25rem;">{{ $grupo->turno }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Capacidad Máxima:</strong>
                        <p style="margin-top: 0.25rem;">{{ $grupo->capacidad_maxima }} estudiantes</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Estado:</strong>
                        <p style="margin-top: 0.25rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; 
                                  {{ $grupo->activo ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                {{ $grupo->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('grupos.index') }}" 
                       style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
