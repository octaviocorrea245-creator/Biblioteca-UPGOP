<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Préstamo</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('prestamos.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Alumno</label>
                <select name="alumno_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($alumnos as $alumno)
                        <option value="{{ $alumno->id }}" {{ old('alumno_id') == $alumno->id ? 'selected' : '' }}>
                            {{ $alumno->nombre }} — {{ $alumno->matricula }}
                        </option>
                    @endforeach
                </select>
                @error('alumno_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">📷 Escanear código de barras (opcional)</label>
                <input type="text" id="escanerCodigoBarras" placeholder="Da clic aquí y escanea el libro..."
                    class="mt-1 block w-full border-blue-300 rounded shadow-sm p-2 bg-blue-50">
                <p id="mensajeEscaneo" class="text-sm mt-1"></p>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Libro</label>
                <select name="libro_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($libros as $libro)
                        <option value="{{ $libro->id }}" {{ old('libro_id') == $libro->id ? 'selected' : '' }}>
                            {{ $libro->titulo }} — {{ $libro->codigo }} ({{ $libro->cantidad_disponible }} disponibles)
                        </option>
                    @endforeach
                </select>
                @error('libro_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Carrera</label>
                <select name="carrera_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id') == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                <input type="text" name="cuatrimestre" value="{{ old('cuatrimestre') }}"
                       placeholder="Ej: 2026-1"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cuatrimestre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Año</label>
                <input type="number" name="anio" value="{{ old('anio', date('Y')) }}" min="2000" max="2099"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('anio') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha de préstamo</label>
                <input type="date" name="fecha_prestamo" value="{{ old('fecha_prestamo', date('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha_prestamo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha esperada de devolución</label>
                <input type="date" name="fecha_devolucion_esperada" value="{{ old('fecha_devolucion_esperada') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha_devolucion_esperada') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observaciones" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('observaciones') }}</textarea>
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Registrar Préstamo</button>
            <a href="{{ route('prestamos.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
    <script>
    document.getElementById('escanerCodigoBarras').addEventListener('keypress', function (e) {
        if (e.key === 'Enter') {
            e.preventDefault();
            const codigo = this.value.trim();
            if (!codigo) return;

            fetch(`{{ route('libros.buscarPorCodigoBarras') }}?codigo_barras=${encodeURIComponent(codigo)}`)
                .then(res => res.json())
                .then(data => {
                    const mensaje = document.getElementById('mensajeEscaneo');
                    const select = document.querySelector('select[name="libro_id"]');

                    if (data.encontrado) {
                        select.value = data.id;
                        mensaje.className = 'text-sm mt-1 text-green-600';
                        mensaje.textContent = `✅ Libro encontrado: ${data.titulo} (${data.disponible} disponibles)`;
                    } else {
                        mensaje.className = 'text-sm mt-1 text-red-600';
                        mensaje.textContent = '❌ No se encontró un libro disponible con ese código de barras.';
                    }

                    this.value = '';
                })
                .catch(() => {
                    document.getElementById('mensajeEscaneo').textContent = '⚠️ Error al buscar el libro.';
                });
        }
    });
    </script>
</x-app-layout>