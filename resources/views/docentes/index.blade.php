    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Docentes
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Mensajes -->
            @if(session('success'))
                <div style="background-color: #10b981; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div style="background-color: #ef4444; color: white; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold">Lista de Docentes</h3>   
            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 1.5rem;">
                    
                    <a href="{{ route('docentes.create') }}" 
                       style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; border-radius: 0.375rem; text-decoration: none;">
                        + Nuevo Docente
                    </a>
                        <a href="{{ route('docentes.inactivos') }}"
                    style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                        👤 Ver Inactivos
                    </a>
                </div>

                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f3f4f6;">
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Registro</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Nombre</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">CI</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Carrera</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Especialidad</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Carga Horaria</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($docentes as $docente)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem;">{{ $docente->registro }}</td>
                                <td style="padding: 0.75rem;">{{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }}</td>
                                <td style="padding: 0.75rem;">{{ $docente->usuario->ci }}</td>
                                <td style="padding: 0.75rem;">{{ $docente->carrera ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem;">{{ $docente->especialidad ?? 'N/A' }}</td>
                                <td style="padding: 0.75rem;">{{ $docente->carga_horaria_actual }}/{{ $docente->carga_horaria_maxima }}h</td>
                                <td style="padding: 0.75rem;">
                                    <a href="{{ route('docentes.show', $docente->registro) }}" 
                                       style="color: #3b82f6; margin-right: 0.5rem;">Ver</a>
                                    <a href="{{ route('docentes.edit', $docente->registro) }}" 
                                       style="color: #10b981; margin-right: 0.5rem;">Editar</a>
                                    
                                       <form action="{{ route('docentes.destroy', $docente->registro) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar este docente?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" style="color: #ef4444; background: none; border: none; cursor: pointer;">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" style="padding: 2rem; text-align: center; color: #6b7280;">
                                    No hay docentes registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>