<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Detalle del Docente
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 class="text-lg font-bold">Información del Docente</h3>
                    <a href="{{ route('docentes.edit', $docente->registro) }}" 
                       style="background-color: #10b981; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        Editar
                    </a>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div>
                        <strong style="color: #6b7280;">Registro:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->registro }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">CI:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->ci }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Nombre Completo:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Sexo:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->sexo == 'M' ? 'Masculino' : 'Femenino' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Correo:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->correo }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Teléfono:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->telefono ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Carrera:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->carrera ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Especialidad:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->especialidad ?? 'N/A' }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Fecha de Ingreso:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->fecha_ingreso->format('d/m/Y') }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Carga Horaria:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->carga_horaria_actual }}/{{ $docente->carga_horaria_maxima }} horas</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Usuario:</strong>
                        <p style="margin-top: 0.25rem;">{{ $docente->usuario->username }}</p>
                    </div>

                    <div>
                        <strong style="color: #6b7280;">Estado:</strong>
                        <p style="margin-top: 0.25rem;">
                            <span style="padding: 0.25rem 0.75rem; border-radius: 9999px; font-size: 0.875rem; 
                                  {{ $docente->activo ? 'background-color: #d1fae5; color: #065f46;' : 'background-color: #fee2e2; color: #991b1b;' }}">
                                {{ $docente->activo ? 'Activo' : 'Inactivo' }}
                            </span>
                        </p>
                    </div>
                </div>

                <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid #e5e7eb;">
                    <a href="{{ route('docentes.index') }}" 
                       style="background-color: #6b7280; color: white; padding: 0.5rem 1.5rem; border-radius: 0.375rem; text-decoration: none; display: inline-block;">
                        Volver
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>