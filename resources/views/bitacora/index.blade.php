<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Bitácora del Sistema
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if(session('success'))
                <div class="bg-green-50 border-l-4 border-green-500 text-green-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" 
                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" 
                                  clip-rule="evenodd"/>
                        </svg>
                        {{ session('success') }}
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <!-- Encabezado y filtros -->
                <div class="p-6 border-b border-gray-200">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 mb-4">
                        <h3 class="text-lg font-bold text-gray-800">Registros de la Bitácora</h3>
                    </div>

                    <!-- Filtros -->
                    <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-6 gap-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Usuario</label>
                            <select name="usuario" class="w-full border-gray-300 rounded-lg text-sm">
                                <option value="">Todos</option>
                                @foreach($usuarios as $u)
                                    <option value="{{ $u->id }}" {{ request('usuario') == $u->id ? 'selected' : '' }}>
                                        {{ $u->nombre }} {{ $u->apellido }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Acción</label>
                            <input type="text" name="accion" value="{{ request('accion') }}" placeholder="Ej: Crear, Actualizar"
                                   class="w-full border-gray-300 rounded-lg text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Tabla</label>
                            <select name="tabla" class="w-full border-gray-300 rounded-lg text-sm">
                                <option value="">Todas</option>
                                @foreach($tablas as $tabla)
                                    <option value="{{ $tabla }}" {{ request('tabla') == $tabla ? 'selected' : '' }}>
                                        {{ ucfirst($tabla) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Desde</label>
                            <input type="date" name="fecha_desde" value="{{ request('fecha_desde') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm">
                        </div>

                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1">Hasta</label>
                            <input type="date" name="fecha_hasta" value="{{ request('fecha_hasta') }}"
                                   class="w-full border-gray-300 rounded-lg text-sm">
                        </div>

                        <div class="flex items-end gap-2">
                            <button type="submit" 
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                                Filtrar
                            </button>
                            <a href="{{ route('bitacora.index') }}" 
                               class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm">
                                Limpiar
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Tabla -->
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">ID</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Fecha/Hora</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Usuario</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Acción</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Tabla</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Registro</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Descripción</th>
                                <th class="px-4 py-3 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">IP</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @forelse($bitacoras as $bitacora)
                                <tr class="hover:bg-gray-50 transition duration-150">
                                    <td class="px-4 py-3 text-gray-500 text-sm">#{{ $bitacora->id }}</td>
                                    <td class="px-4 py-3 text-sm whitespace-nowrap">{{ $bitacora->fecha->format('d/m/Y H:i:s') }}</td>
                                    <td class="px-4 py-3">
                                        <div class="font-semibold text-gray-800">{{ $bitacora->usuario->nombre ?? 'Sistema' }}</div>
                                        <div class="text-xs text-gray-500">{{ $bitacora->usuario->username ?? 'N/A' }}</div>
                                    </td>
                                    <td class="px-4 py-3">
                                        @php
                                            $color = 'bg-gray-100 text-gray-700';
                                            if(str_contains($bitacora->accion, 'Crear')) $color = 'bg-green-100 text-green-800';
                                            elseif(str_contains($bitacora->accion, 'Actualizar')) $color = 'bg-blue-100 text-blue-800';
                                            elseif(str_contains($bitacora->accion, 'Eliminar')) $color = 'bg-red-100 text-red-800';
                                        @endphp
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $color }}">
                                            {{ $bitacora->accion }}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-sm font-medium text-gray-700">{{ ucfirst($bitacora->tabla_afectada ?? 'N/A') }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-500">{{ $bitacora->registro_afectado ?? 'N/A' }}</td>
                                    <td class="px-4 py-3 text-sm text-gray-600 truncate max-w-xs" title="{{ $bitacora->descripcion }}">
                                        {{ $bitacora->descripcion ?? 'Sin descripción' }}
                                    </td>
                                    <td class="px-4 py-3 text-xs font-mono text-gray-500">{{ $bitacora->ip_direccion ?? 'N/A' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="px-6 py-12 text-center">
                                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                                                  d="M9 17v-6a2 2 0 114 0v6m-6 4h8a2 2 0 002-2V7a2 2 0 00-2-2h-8a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                        <p class="mt-2 text-gray-500">No hay registros en la bitácora</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Paginación -->
                <div class="p-6 border-t border-gray-200">
                    {{ $bitacoras->links() }}
                </div>

                <!-- Estadísticas -->
                <div class="p-6 grid grid-cols-1 sm:grid-cols-3 gap-4 border-t border-gray-200 bg-gray-50">
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Total de registros</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $bitacoras->total() }}</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Página actual</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $bitacoras->currentPage() }} / {{ $bitacoras->lastPage() }}</div>
                    </div>
                    <div class="bg-white p-4 rounded-lg shadow-sm">
                        <div class="text-sm text-gray-500">Registros por página</div>
                        <div class="text-2xl font-bold text-gray-800">{{ $bitacoras->perPage() }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
