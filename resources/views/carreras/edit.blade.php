<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Carrera</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('carreras.update', $carrera) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Clave</label>
                <input type="text" name="clave" value="{{ old('clave', $carrera->clave) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('clave') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre', $carrera->nombre) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Activa</label>
                <select name="activa" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="1" {{ old('activa', $carrera->activa) == 1 ? 'selected' : '' }}>Sí</option>
                    <option value="0" {{ old('activa', $carrera->activa) == 0 ? 'selected' : '' }}>No</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('carreras.index') }}" 
                   class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">Cancelar</a>
                <button type="submit" 
                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Actualizar</button>
            </div>
        </form>

        {{-- Formulario de eliminar FUERA del formulario de actualizar --}}
        <div class="mt-4">
            <form action="{{ route('carreras.destroy', $carrera) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar esta carrera?')">
                @csrf @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Eliminar</button>
            </form>
        </div>
    </div>
</x-app-layout>