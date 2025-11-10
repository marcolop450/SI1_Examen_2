<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Crear Nuevo Horario
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            @if(session('error'))
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        {{ session('error') }}
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-red-50 border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 shadow-sm">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                        </svg>
                        <div>
                            <p class="font-semibold">Hay algunos errores:</p>
                            <ul class="list-disc list-inside mt-1">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-lg sm:rounded-lg">
                <div class="p-6 border-b border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-800">Información del Horario</h3>
                    <p class="text-sm text-gray-600 mt-1">Complete los datos para crear horarios (1-3 días por semana)</p>
                </div>

                <form action="{{ route('horarios.store') }}" method="POST" class="p-6" id="horarioForm">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Docente -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Docente <span class="text-red-500">*</span>
                            </label>
                            <select name="id_docente" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione un docente...</option>
                                @foreach($docentes as $docente)
                                    <option value="{{ $docente->registro }}" {{ old('id_docente') == $docente->registro ? 'selected' : '' }}>
                                        {{ $docente->usuario->nombre }} {{ $docente->usuario->apellido }} ({{ $docente->carga_horaria_simple }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_docente')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Materia -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Materia <span class="text-red-500">*</span>
                            </label>
                            <select name="id_materia" id="materia_select" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione una materia...</option>
                                @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" 
                                            data-horas="{{ $materia->horas_semanales ?? 4.5 }}"
                                            {{ old('id_materia') == $materia->id ? 'selected' : '' }}>
                                        {{ $materia->codigo }} - {{ $materia->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_materia')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500" id="horas_info">Seleccione una materia para ver las horas semanales</p>
                        </div>

                        <!-- Grupo -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Grupo <span class="text-red-500">*</span>
                            </label>
                            <select name="id_grupo" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione un grupo...</option>
                                @foreach($grupos as $grupo)
                                    <option value="{{ $grupo->id }}" {{ old('id_grupo') == $grupo->id ? 'selected' : '' }}>
                                        {{ $grupo->nombre }} (Cap: {{ $grupo->capacidad_maxima }})
                                    </option>
                                @endforeach
                            </select>
                            @error('id_grupo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Aula -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Aula <span class="text-gray-500 text-xs">(Opcional si es virtual)</span>
                            </label>
                            <select name="id_aula" id="aula_select"
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Sin aula (Virtual)</option>
                                @foreach($aulas as $aula)
                                    <option value="{{ $aula->id }}" {{ old('id_aula') == $aula->id ? 'selected' : '' }}>
                                        {{ $aula->nombre }} - Cap: {{ $aula->capacidad }}
                                    </option>
                                @endforeach
                            </select>
                            @error('id_aula')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- DÍAS (MÚLTIPLES) -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Días de Clase <span class="text-red-500">*</span>
                                <span class="text-xs font-normal text-gray-500">(Seleccione entre 1 y 3 días)</span>
                            </label>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3" id="dias_container">
                                @php
                                    $diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
                                    $oldDias = old('dias', []);
                                @endphp
                                @foreach($diasSemana as $dia)
                                    <label class="flex items-center p-3 border rounded-lg hover:bg-blue-50 cursor-pointer transition {{ in_array($dia, $oldDias) ? 'bg-blue-50 border-blue-400' : 'border-gray-300' }}">
                                        <input type="checkbox" 
                                               name="dias[]" 
                                               value="{{ $dia }}"
                                               {{ in_array($dia, $oldDias) ? 'checked' : '' }}
                                               class="dias-checkbox w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                        <span class="ml-2 text-sm font-medium text-gray-700">{{ $dia }}</span>
                                    </label>
                                @endforeach
                            </div>
                            @error('dias')
                                <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <div class="mt-3 p-3 bg-gray-50 rounded-lg" id="distribucion_info">
                                <p class="text-xs text-gray-700 font-semibold">Seleccione los días para ver la distribución</p>
                            </div>
                        </div>

                        <!-- Hora Inicio -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Hora Inicio <span class="text-red-500">*</span>
                            </label>
                            <select name="hora_inicio" required
                                    class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                                <option value="">Seleccione hora...</option>
                                @foreach($horariosDisponibles as $hora)
                                    <option value="{{ $hora }}" {{ old('hora_inicio') == $hora ? 'selected' : '' }}>{{ $hora }}</option>
                                @endforeach
                            </select>
                            @error('hora_inicio')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-gray-500">La hora final se calculará automáticamente</p>
                        </div>

                        <!-- Gestión -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Gestión <span class="text-red-500">*</span>
                            </label>
                            <input type="text" 
                                   name="gestion" 
                                   value="{{ old('gestion', '2-2025') }}" 
                                   required
                                   placeholder="Ej: 2-2025"
                                   class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">
                            @error('gestion')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Es Virtual -->
                        <div class="md:col-span-2">
                            <label class="flex items-center p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                <input type="checkbox" 
                                       name="es_virtual" 
                                       id="es_virtual"
                                       value="1"
                                       {{ old('es_virtual') ? 'checked' : '' }}
                                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                <span class="ml-2 text-sm font-medium text-gray-700">
                                    Clase Virtual (no requiere aula física)
                                </span>
                            </label>
                        </div>

                        <!-- Observaciones -->
                        <div class="md:col-span-2">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">Observaciones</label>
                            <textarea name="observaciones" 
                                      rows="3"
                                      placeholder="Observaciones adicionales..."
                                      class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent transition">{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Botones -->
                    <div class="mt-8 pt-6 border-t border-gray-200">
                        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                            <div class="flex items-start">
                                <svg class="w-5 h-5 mr-2 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                                </svg>
                                <div class="text-sm text-blue-800">
                                    <p class="font-semibold mb-1">Información importante:</p>
                                    <ul class="space-y-1">
                                        <li>• Se validará automáticamente que no haya conflictos de horarios</li>
                                        <li>• 1 hora académica = 45 minutos</li>
                                        <li>• Los horarios inician cada 45 minutos desde las 7:00 AM</li>
                                        <li>• La hora final se calcula: (horas semanales × 60) ÷ días seleccionados</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            <button type="submit" 
                                    class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Guardar Horarios
                            </button>
                            <a href="{{ route('horarios.index') }}" 
                               class="inline-flex items-center px-6 py-2.5 bg-gray-500 hover:bg-gray-600 text-white font-medium rounded-lg transition shadow-sm">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                                Cancelar
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const materiaSelect = document.getElementById('materia_select');
            const horasInfo = document.getElementById('horas_info');
            const diasCheckboxes = document.querySelectorAll('.dias-checkbox');
            const distribucionInfo = document.getElementById('distribucion_info');
            const esVirtualCheckbox = document.getElementById('es_virtual');
            const aulaSelect = document.getElementById('aula_select');

            // Actualizar info de horas semanales
            function actualizarInfoHoras() {
                const selectedOption = materiaSelect.options[materiaSelect.selectedIndex];
                if (selectedOption.value) {
                    const horas = selectedOption.dataset.horas;
                    horasInfo.textContent = `${horas} horas semanales (${horas * 60} minutos totales)`;
                } else {
                    horasInfo.textContent = 'Seleccione una materia para ver las horas semanales';
                }
                actualizarDistribucion();
            }

            // Actualizar distribución por días
            function actualizarDistribucion() {
                const selectedOption = materiaSelect.options[materiaSelect.selectedIndex];
                const diasSeleccionados = Array.from(diasCheckboxes).filter(cb => cb.checked).length;
                
                if (!selectedOption.value || diasSeleccionados === 0) {
                    distribucionInfo.innerHTML = '<p class="text-xs text-gray-700 font-semibold">Seleccione materia y días para ver la distribución</p>';
                    return;
                }

                const horasSemanales = parseFloat(selectedOption.dataset.horas);
                const minutosSemanales = horasSemanales * 60;
                const minutosPorDia = Math.round(minutosSemanales / diasSeleccionados);
                const horasAcademicas = (minutosPorDia * diasSeleccionados) / 45;

                const horas = Math.floor(minutosPorDia / 60);
                const minutos = minutosPorDia % 60;

                distribucionInfo.innerHTML = `
                    <p class="text-xs text-gray-700">
                        <strong>Distribución para ${diasSeleccionados} día(s):</strong>
                    </p>
                    <ul class="text-xs text-gray-600 mt-1 space-y-1">
                        <li>• <strong>Por clase:</strong> ${minutosPorDia} minutos (${horas}h ${minutos}min)</li>
                        <li>• <strong>Total semanal:</strong> ${horasAcademicas.toFixed(1)} horas académicas</li>
                        <li>• <strong>Intervalos:</strong> Cada 45 minutos</li>
                    </ul>
                `;
            }

            // Controlar aula según checkbox virtual
            function controlarAula() {
                if (esVirtualCheckbox.checked) {
                    aulaSelect.value = '';
                    aulaSelect.disabled = true;
                    aulaSelect.classList.add('bg-gray-100');
                } else {
                    aulaSelect.disabled = false;
                    aulaSelect.classList.remove('bg-gray-100');
                }
            }

            // Event listeners
            materiaSelect.addEventListener('change', actualizarInfoHoras);
            diasCheckboxes.forEach(cb => cb.addEventListener('change', actualizarDistribucion));
            esVirtualCheckbox.addEventListener('change', controlarAula);

            // Inicializar
            actualizarInfoHoras();
            controlarAula();
        });
    </script>
    @endpush
</x-app-layout>