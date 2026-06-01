<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Libro</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('libros.store') }}">
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
                <label class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('codigo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="Regular">Regular</option>
                    <option value="Donado">Donado</option>
                    <option value="Adquirido">Adquirido</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Título</label>
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
                <label class="block text-sm font-medium text-gray-700">Localización</label>
                <input type="text" name="localizacion" value="{{ old('localizacion') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad total</label>
                <input type="number" name="cantidad_total" value="{{ old('cantidad_total', 1) }}" min="1"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cantidad_total') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad disponible</label>
                <input type="number" name="cantidad_disponible" value="{{ old('cantidad_disponible', 1) }}" min="0"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cantidad_disponible') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('libros.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>