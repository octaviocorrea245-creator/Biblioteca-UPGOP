<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Nuevo Alumno</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('alumnos.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('matricula') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                <input type="text" name="nombre" value="{{ old('nombre') }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
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
                <label class="block text-sm font-medium text-gray-700">Género</label>
                <select name="genero" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                    <option value="Otro">Otro</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                <input type="number" name="cuatrimestre" value="{{ old('cuatrimestre') }}" min="1" max="12"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cuatrimestre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Turno</label>
                <select name="turno" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="M">Matutino</option>
                    <option value="V">Vespertino</option>
                    <option value="N">Nocturno</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Generación (año de ingreso)</label>
                <input type="number" name="generacion" value="{{ old('generacion') }}" min="2000" max="2099"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('generacion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">Guardar</button>
            <a href="{{ route('alumnos.index') }}" class="ml-3 text-gray-600">Cancelar</a>
        </form>
    </div>
</x-app-layout>