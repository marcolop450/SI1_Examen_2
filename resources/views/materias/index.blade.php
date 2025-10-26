<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Gestión de Materias
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
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
            <h3 class="text-lg font-bold mb-4">Lista de Materias</h3>

            <div style="display: flex; justify-content: flex-end; gap: 8px; margin-bottom: 1.5rem;">
                
                <a href="{{ route('materias.create') }}" 
                style="background-color: #3b82f6; color: white; padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                    + Nueva Materia
                </a>
                <a href="{{ route('materias.inactivos') }}" 
                style="background-color: #f59e0b; color: white; padding: 0.5rem 1rem; 
                        border-radius: 0.375rem; text-decoration: none; font-size: 0.875rem;">
                    📚 Ver Inactivas
                </a>
            </div>


                <table style="width: 100%; border-collapse: collapse;">
                    <thead>
                        <tr style="background-color: #f3f4f6;">
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Código</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Nombre</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Semestre</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Horas T/P</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Créditos</th>
                            <th style="padding: 0.75rem; text-align: left; border-bottom: 2px solid #e5e7eb;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($materias as $materia)
                            <tr style="border-bottom: 1px solid #e5e7eb;">
                                <td style="padding: 0.75rem;">{{ $materia->codigo }}</td>
                                <td style="padding: 0.75rem;">{{ $materia->nombre }}</td>
                                <td style="padding: 0.75rem;">{{ $materia->semestre }}º</td>
                                <td style="padding: 0.75rem;">{{ $materia->horas_teoricas }}/{{ $materia->horas_practicas }}</td>
                                <td style="padding: 0.75rem;">{{ $materia->creditos }}</td>
                                <td style="padding: 0.75rem;">
                                    <a href="{{ route('materias.show', $materia->id) }}" 
                                       style="color: #3b82f6; margin-right: 0.5rem;">Ver</a>
                                    <a href="{{ route('materias.edit', $materia->id) }}" 
                                       style="color: #10b981; margin-right: 0.5rem;">Editar</a>
                                    <form action="{{ route('materias.destroy', $materia->id) }}" 
                                          method="POST" 
                                          style="display: inline;"
                                          onsubmit="return confirm('¿Estás seguro de eliminar esta materia?');">
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
                                <td colspan="6" style="padding: 2rem; text-align: center; color: #6b7280;">
                                    No hay materias registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>