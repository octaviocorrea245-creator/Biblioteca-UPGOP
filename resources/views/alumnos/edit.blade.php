<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Editar Alumno</h2>
    </x-slot>

    <div class="py-6 max-w-xl mx-auto sm:px-6 lg:px-8">
        <form method="POST" action="{{ route('alumnos.update', $alumno) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Matrícula</label>
                <input type="text" name="matricula" value="{{ old('matricula', $alumno->matricula) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('matricula') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Nombre completo</label>
                <input type="text" name="nombre" value="{{ old('nombre', $alumno->nombre) }}"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('nombre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Carrera</label>
                <select name="carrera_id" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="">-- Selecciona --</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}" {{ old('carrera_id', $alumno->carrera_id) == $carrera->id ? 'selected' : '' }}>
                            {{ $carrera->nombre }}
                        </option>
                    @endforeach
                </select>
                @error('carrera_id') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Género</label>
                <select name="genero" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="M" {{ old('genero', $alumno->genero) === 'M' ? 'selected' : '' }}>Masculino</option>
                    <option value="F" {{ old('genero', $alumno->genero) === 'F' ? 'selected' : '' }}>Femenino</option>
                    <option value="Otro" {{ old('genero', $alumno->genero) === 'Otro' ? 'selected' : '' }}>Otro</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Cuatrimestre</label>
                <input type="number" name="cuatrimestre" value="{{ old('cuatrimestre', $alumno->cuatrimestre) }}" min="1" max="12"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('cuatrimestre') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Turno</label>
                <select name="turno" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="M" {{ old('turno', $alumno->turno) === 'M' ? 'selected' : '' }}>Matutino</option>
                    <option value="V" {{ old('turno', $alumno->turno) === 'V' ? 'selected' : '' }}>Vespertino</option>
                    <option value="N" {{ old('turno', $alumno->turno) === 'N' ? 'selected' : '' }}>Nocturno</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Generación (año de ingreso)</label>
                <input type="number" name="generacion" value="{{ old('generacion', $alumno->generacion) }}" min="2000" max="2099"
                       class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                @error('generacion') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700">Estado</label>
                <select name="estado" class="mt-1 block w-full border-gray-300 rounded shadow-sm">
                    <option value="Activo" {{ old('estado', $alumno->estado) === 'Activo' ? 'selected' : '' }}>Activo</option>
                    <option value="Deudor" {{ old('estado', $alumno->estado) === 'Deudor' ? 'selected' : '' }}>Deudor</option>
                    <option value="Rezagado" {{ old('estado', $alumno->estado) === 'Rezagado' ? 'selected' : '' }}>Rezagado</option>
                </select>
            </div>
            <div class="flex items-center justify-end gap-3 mt-6 pt-6 border-t border-gray-200">
                <a href="{{ route('alumnos.index') }}" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded transition">Cancelar</a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded transition">Actualizar</button>
            </div>
        </form>

        <div class="mt-4">
            <form action="{{ route('alumnos.destroy', $alumno) }}" method="POST"
                  onsubmit="return confirm('¿Eliminar este alumno?')">
                @csrf @method('DELETE')
                <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded transition">Eliminar</button>
            </form>
        </div>
    </div>
</x-app-layout>