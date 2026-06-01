<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Donación</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('donaciones.store') }}">
            @csrf
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
                <label class="block text-sm font-medium text-gray-700">Título del libro</label>
                <input type="text" name="titulo" value="{{ old('titulo') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Autor</label>
                <input type="text" name="autor" value="{{ old('autor') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('autor') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Editorial</label>
                <input type="text" name="editorial" value="{{ old('editorial') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('editorial') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Código de barras</label>
                <input type="text" name="codigo_barras" value="{{ old('codigo_barras') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Costo estimado</label>
                <input type="number" step="0.01" name="costo" value="{{ old('costo') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha de donación</label>
                <input type="date" name="fecha" value="{{ old('fecha', date('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre del alumno donante</label>
                <input type="text" name="alumno_donante" value="{{ old('alumno_donante') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('alumno_donante') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Matrícula del alumno donante</label>
                <input type="text" name="matricula_donante" value="{{ old('matricula_donante') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('matricula_donante') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                <input type="text" name="cuatrimestre" value="{{ old('cuatrimestre') }}"
                       placeholder="Ej: 2026-1"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cuatrimestre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Generación (año de ingreso del donante)</label>
                <input type="number" name="generacion" value="{{ old('generacion') }}" min="2000" max="2099"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('generacion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Guardar Donación</button>
            <a href="{{ route('donaciones.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>