<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Aula
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-lg font-bold">Información del Aula</h3>
                    <a href="{{ route('aulas.edit', $aula->id) }}" 
                       style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        Editar
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <strong style="color: #6b7280;">Nombre:</strong>
                        <p style="margin-top: 0.25rem; font-size: 1.25rem; font-weight: bold;">{{ $aula->nombre }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Tipo:</strong>
                        <p style="margin-top: 0.25rem;">{{ $aula->tipo }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Capacidad:</strong>
                        <p style="margin-top: 0.25rem;">{{ $aula->capacidad }} personas</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Piso:</strong>
                        <p style="margin-top: 0.25rem;">{{ $aula->piso ?? 'No especificado' }}</p>
                    </div>

                    <div style="grid-column: span 2;">
                        <strong style="color: #6b7280;">Equipamiento:</strong>
                        <p style="margin-top: 0.25rem;">{{ $aula->equipamiento ?? 'Sin equipamiento especificado' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Estado:</strong>
                        <p style="margin-top: 0.25rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; 
                                  {{ $aula->activo ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                {{ $aula->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('aulas.index') }}" 
                       style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>