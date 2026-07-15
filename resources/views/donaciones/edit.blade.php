<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Donación</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('donaciones.update', $donacion) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Carrera</label>
                <select name="carrera_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $donacion->carrera_id) == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Título del libro</label>
                <input type="text" name="titulo" value="{{ old('titulo', $donacion->titulo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Autor</label>
                <input type="text" name="autor" value="{{ old('autor', $donacion->autor) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('autor') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Editorial</label>
                <input type="text" name="editorial" value="{{ old('editorial', $donacion->editorial) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('editorial') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Código de barras</label>
                <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $donacion->codigo_barras) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Costo estimado</label>
                <input type="number" step="0.01" name="costo" value="{{ old('costo', $donacion->costo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha de donación</label>
                <input type="date" name="fecha" value="{{ old('fecha', $donacion->fecha->format('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre del alumno donante</label>
                <input type="text" name="alumno_donante" value="{{ old('alumno_donante', $donacion->alumno_donante) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('alumno_donante') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Matrícula del alumno donante</label>
                <input type="text" name="matricula_donante" value="{{ old('matricula_donante', $donacion->matricula_donante) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('matricula_donante') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                <input type="text" name="cuatrimestre" value="{{ old('cuatrimestre', $donacion->cuatrimestre) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cuatrimestre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Generación (año de ingreso del donante)</label>
                <input type="number" name="generacion" value="{{ old('generacion', $donacion->generacion) }}" min="2000" max="2099"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('generacion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('donaciones.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Actualizar</button>
            </div>
        </form>

        <div class="mt-4">
            <form action="{{ route('donaciones.destroy', $donacion) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta donación?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Eliminar</button>
            </form>
        </div>
    </div>
</x-app-layout>