<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Adquisición</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('adquisiciones.update', $adquisicion) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Carrera</label>
                <select name="carrera_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $adquisicion->carrera_id) == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Título</label>
                <input type="text" name="titulo" value="{{ old('titulo', $adquisicion->titulo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('titulo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Autor</label>
                <input type="text" name="autor" value="{{ old('autor', $adquisicion->autor) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('autor') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Editorial</label>
                <input type="text" name="editorial" value="{{ old('editorial', $adquisicion->editorial) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('editorial') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cantidad</label>
                <input type="number" name="cantidad" value="{{ old('cantidad', $adquisicion->cantidad) }}" min="1"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cantidad') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Localización</label>
                <input type="text" name="localizacion" value="{{ old('localizacion', $adquisicion->localizacion) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Código de barras</label>
                <input type="text" name="codigo_barras" value="{{ old('codigo_barras', $adquisicion->codigo_barras) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Proveedor</label>
                <input type="text" name="proveedor" value="{{ old('proveedor', $adquisicion->proveedor) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('proveedor') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Número de factura</label>
                <input type="text" name="factura" value="{{ old('factura', $adquisicion->factura) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('factura') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Fecha de factura</label>
                <input type="date" name="fecha_factura" value="{{ old('fecha_factura', $adquisicion->fecha_factura->format('Y-m-d')) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('fecha_factura') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Costo</label>
                <input type="number" step="0.01" name="costo" value="{{ old('costo', $adquisicion->costo) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('costo') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Observaciones</label>
                <textarea name="observacion" rows="3"
                          class="mt-1 block w-full border-gray-300 rounded shadow-sm">{{ old('observacion', $adquisicion->observacion) }}</textarea>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('adquisiciones.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Actualizar</button>
            </div>
        </form>

        <div class="mt-4">
            <form action="{{ route('adquisiciones.destroy', $adquisicion) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta adquisición?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Eliminar</button>
            </form>
        </div>
    </div>
</x-app-layout>