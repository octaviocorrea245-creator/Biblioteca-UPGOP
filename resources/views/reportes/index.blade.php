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
            <form method="GET" class="flex gap-3 flex-wrap">
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
                <button type="submit" formaction="{{ route('reportes.prestamensuales') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
                <button type="submit" formaction="{{ route('reportes.prestamensuales.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded">Descargar Excel</button>
            </form>
        </div>

        {{-- Reporte cuatrimestral --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte Cuatrimestral de Préstamos</h3>
            <form method="GET" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" formaction="{{ route('reportes.prestamoscuatrimestrales') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
            </form>
        </div>

        {{-- Deudores y Rezagados --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Listas de Deudores y Rezagados</h3>
            <div class="flex gap-3 flex-wrap">
                <a href="{{ route('reportes.deudores') }}" class="bg-yellow-500 text-white px-4 py-2 rounded">Deudores PDF</a>
                <a href="{{ route('reportes.deudores.excel') }}" style="background-color:#16a34a;" class="text-white px-4 py-2 rounded">Deudores Excel</a>                
                <a href="{{ route('reportes.rezagados') }}" class="bg-red-600 text-white px-4 py-2 rounded">Rezagados PDF</a>
                <a href="{{ route('reportes.rezagados.excel') }}" style="background-color:#16a34a;" class="text-white px-4 py-2 rounded">Rezagados Excel</a>
            </div>
        </div>

        {{-- Donaciones --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte de Donaciones</h3>
            <form method="GET" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" formaction="{{ route('reportes.donaciones') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
                <button type="submit" formaction="{{ route('reportes.donaciones.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded">Descargar Excel</button>
            </form>
        </div>

        {{-- Adquisiciones --}}
        <div class="bg-white shadow rounded p-6">
            <h3 class="font-semibold text-lg mb-4">Reporte de Adquisiciones</h3>
            <form method="GET" class="flex gap-3 flex-wrap">
                <select name="carrera_id" class="border-gray-300 rounded shadow-sm">
                    <option value="">Todas las carreras</option>
                    @foreach($carreras as $carrera)
                        <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                    @endforeach
                </select>
                <input type="text" name="proveedor" placeholder="Filtrar por proveedor"
                       class="border-gray-300 rounded shadow-sm">
                <button type="submit" formaction="{{ route('reportes.adquisiciones') }}" class="bg-blue-600 text-white px-4 py-2 rounded">Descargar PDF</button>
                <button type="submit" formaction="{{ route('reportes.adquisiciones.excel') }}" class="bg-green-600 text-white px-4 py-2 rounded">Descargar Excel</button>
            </form>
        </div>

    </div>
</x-app-layout>