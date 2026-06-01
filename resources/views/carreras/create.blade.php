<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nueva Carrera</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('carreras.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Clave</label>
                <input type="text" name="clave" value="{{ old('clave') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('clave') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Activa</label>
                <select name="activa" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('carreras.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>