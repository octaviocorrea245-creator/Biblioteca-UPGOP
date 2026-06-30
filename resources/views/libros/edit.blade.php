<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Libro</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('libros.update', $libro) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Carrera</label>
                <select name="carrera_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Sin carrera específica --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $libro->carrera_id) == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Código</label>
                <input type="text" name="codigo" value="{{ old('codigo', $libro->codigo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('codigo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Tipo</label>
                <select name="tipo" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="Regular" {{ old('tipo', $libro->tipo) === 'Regular' ? 'selected' : '' }}>Regular</option>
                    <option value="Donado" {{ old('tipo', $libro->tipo) === 'Donado' ? 'selected' : '' }}>Donado</option>
                    <option value="Adquirido" {{ old('tipo', $libro->tipo) === 'Adquirido' ? 'selected' : '' }}>Adquirido</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $libro->titulo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Autor</label>
                <input type="text" name="autor" value="{{ old('autor', $libro->autor) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('autor') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Editorial</label>
                <input type="text" name="editorial" value="{{ old('editorial', $libro->editorial) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('editorial') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Código de barras</label>
                <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $libro->codigo_barras) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Localización</label>
                <input type="text" name="localizacion" value="{{ old('localizacion', $libro->localizacion) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad total</label>
                <input type="number" name="cantidad_total" value="{{ old('cantidad_total', $libro->cantidad_total) }}" min="1"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cantidad_total') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad disponible</label>
                <input type="number" name="cantidad_disponible" value="{{ old('cantidad_disponible', $libro->cantidad_disponible) }}" min="0"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cantidad_disponible') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Costo</label>
                <input type="number" step="0.01" name="costo" value="{{ old('costo', $libro->costo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('libros.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Actualizar</button>
            </div>
        </form>

        <div class="mt-4">
            <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este libro?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Eliminar</button>
            </form>
        </div>
    </div>
</x-app-layout>