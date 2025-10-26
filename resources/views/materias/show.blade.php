<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle de Materia
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-lg font-bold">Información de la Materia</h3>
                    <a href="{{ route('materias.edit', $materia->id) }}" 
                       style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        Editar
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <strong style="color: #6b7280;">Código:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->codigo }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Semestre:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->semestre }}º Semestre</p>
                    </div>

                    <div style="grid-column: span 2;">
                        <strong style="color: #6b7280;">Nombre:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->nombre }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Horas Teóricas:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->horas_teoricas }} horas</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Horas Prácticas:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->horas_practicas }} horas</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Total Horas:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->horas_teoricas + $materia->horas_practicas }} horas/semana</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Créditos:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->creditos }} créditos</p>
                    </div>

                    <div style="grid-column: span 2;">
                        <strong style="color: #6b7280;">Contenido:</strong>
                        <p style="margin-top: 0.25rem;">{{ $materia->contenido ?? 'Sin contenido especificado' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Estado:</strong>
                        <p style="margin-top: 0.25rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; 
                                  {{ $materia->activo ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                {{ $materia->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('materias.index') }}" 
                       style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>