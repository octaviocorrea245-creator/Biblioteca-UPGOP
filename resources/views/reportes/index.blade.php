<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Reportes</h2>
    </x-slot>

    <div class="py-6 max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

        @if(session('success'))
            <div class="text-green-600">{{ session('success') }}</div>
        @endif

        {{-- Reporte mensual --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte Mensual de Préstamos</h3>
            <form method="GET" action="{{ route('reportes.prestamensuales') }}" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <select name="mes" class="border-gray-300 rounded shadow-sm">
                    @foreach(range(1,12) as $m)
                        <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                            {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                        </option>
                    @endforeach
                </select>
                <input type="number" name="anio" value="{{ date('Y') }}" min="2000" max="2099"
                       class="border-gray-300 rounded shadow-sm w-24">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
            </form>
        </div>

        {{-- Reporte cuatrimestral --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte Cuatrimestral de Préstamos</h3>
            <form method="GET" action="{{ route('reportes.prestamoscuatrimestrales') }}" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
            </form>
        </div>

        {{-- Deudores y Rezagados --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Listas de Deudores y Rezagados</h3>
            <div class="flex gap-3">
                <a href="{{ route('reportes.deudores') }}"
                   class="bg-yellow-500 text-white px-4 py-2 rounded">Descargar Deudores PDF</a>
                <a href="{{ route('reportes.rezagados') }}"
                   class="bg-red-600 text-white px-4 py-2 rounded">Descargar Rezagados PDF</a>
            </div>
        </div>

        {{-- Donaciones --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte de Donaciones</h3>
            <form method="GET" action="{{ route('reportes.donaciones') }}" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
            </form>
        </div>

        {{-- Adquisiciones --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte de Adquisiciones</h3>
            <form method="GET" action="{{ route('reportes.adquisiciones') }}" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="proveedor" placeholder="Filtrar por proveedor"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
            </form>
        </div>

    </div>
</x-app-layout>