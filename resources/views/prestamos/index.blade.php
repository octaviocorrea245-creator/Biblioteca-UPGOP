<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Préstamos</h2>
    </x-slot>

    <div class="py-6 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <a href="{{ route('prestamos.create') }}"
           class="mb-4 inline-block bg-blue-600 text-white px-4 py-2 rounded">
            + Nuevo Préstamo
        </a>

        @if(session('success'))
            <div class="mb-4 text-green-600">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="mb-4 text-red-600">{{ session('error') }}</div>
        @endif

        {{-- Alertas de préstamos próximos a vencer o vencidos --}}
        @php
            $proximos = $prestamos->filter(fn($p) =>
                $p->estado === 'Activo' &&
                now()->diffInDays($p->fecha_devolucion_esperada, false) <= 3 &&
                now()->diffInDays($p->fecha_devolucion_esperada, false) >= 0
            );
            $vencidos = $prestamos->filter(fn($p) => strtolower(trim($p->estado)) === 'vencido');
        @endphp

        @if($vencidos->count() > 0)
            <div class="mb-4 bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded">
                🚨 <strong>{{ $vencidos->count() }} préstamo(s) vencido(s)</strong> — El alumno ha sido marcado como Deudor. Corre el comando de clasificación si aún no lo has hecho.
            </div>
        @endif

        @if($proximos->count() > 0)
            <div class="mb-4 bg-yellow-50 border border-yellow-300 text-yellow-700 px-4 py-3 rounded">
                ⚠️ <strong>{{ $proximos->count() }} préstamo(s) vencen en los próximos 3 días</strong> — Revisa los préstamos resaltados en amarillo.
            </div>
        @endif

        <div class="mb-4">
            <input type="text" id="buscador" placeholder="Buscar por alumno, libro, folio o carrera..."
                class="w-full border-gray-300 rounded shadow-sm p-2"
                onkeyup="buscarEnTabla()">
        </div>
        <table class="w-full bg-white shadow rounded">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 text-left">Folio</th>
                    <th class="p-3 text-left">Alumno</th>
                    <th class="p-3 text-left">Libro</th>
                    <th class="p-3 text-left">Carrera</th>
                    <th class="p-3 text-left">Cuatrimestre</th>
                    <th class="p-3 text-left">F. Préstamo</th>
                    <th class="p-3 text-left">F. Esperada</th>
                    <th class="p-3 text-left">Estado</th>
                    <th class="p-3 text-left">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($prestamos as $prestamo)
                @php
                    $diasRestantes = now()->startOfDay()->diffInDays($prestamo->fecha_devolucion_esperada->startOfDay(), false);
                    $esProximo = strtolower(trim($prestamo->estado)) === 'activo' && $diasRestantes <= 3 && $diasRestantes >= 0;
                    $esVencido = strtolower(trim($prestamo->estado)) === 'vencido';
                @endphp
                <tr class="border-t {{ $esVencido ? 'bg-red-50' : ($esProximo ? 'bg-yellow-50' : '') }}">
                    <td class="p-3">#{{ $prestamo->folio }}</td>
                    <td class="p-3">{{ $prestamo->alumno->nombre }}</td>
                    <td class="p-3">{{ $prestamo->libro->titulo }}</td>
                    <td class="p-3">{{ $prestamo->carrera->nombre }}</td>
                    <td class="p-3">{{ $prestamo->cuatrimestre }}</td>
                    <td class="p-3">{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
                    <td class="p-3">
                        <div>{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</div>
                        @if($esVencido)
                            <div class="text-xs text-red-600 font-semibold mt-1">VENCIDO</div>
                        @elseif($esProximo)
                            <div class="text-xs text-yellow-600 font-semibold mt-1">
                                @if($diasRestantes == 0)
                                    Vence hoy
                                @elseif($diasRestantes == 1)
                                    Vence mañana
                                @else
                                    Vence en {{ $diasRestantes }} días
                                @endif
                            </div>
                        @endif
                    </td>
                    <td class="p-3">
                        @php
                            $estadoLower = strtolower(trim($prestamo->estado));
                        @endphp
                        <span class="px-2 py-1 rounded text-sm
                            {{ $estadoLower === 'activo' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $estadoLower === 'devuelto' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $estadoLower === 'vencido' ? 'bg-red-100 text-red-700' : '' }}">
                            {{ ucfirst(strtolower($prestamo->estado)) }}
                        </span>
                    </td>
                    <td class="p-3 flex gap-2">
                        <a href="{{ route('prestamos.show', $prestamo) }}"
                           class="bg-blue-400 text-white px-3 py-1 rounded text-sm">Ver</a>
                        <a href="{{ route('prestamos.vale', $prestamo) }}"
                           class="bg-gray-500 text-white px-3 py-1 rounded text-sm" target="_blank">Vale PDF</a>
                        @if(strtolower(trim($prestamo->estado)) === 'activo')
                        <form action="{{ route('prestamos.devolver', $prestamo) }}" method="POST"
                              onsubmit="return confirm('¿Registrar devolución?')">
                            @csrf @method('PATCH')
                            <button class="bg-green-500 text-white px-3 py-1 rounded text-sm">Devolver</button>
                        </form>
                        @endif
                        <form action="{{ route('prestamos.destroy', $prestamo) }}" method="POST"
                              onsubmit="return confirm('¿Eliminar este préstamo?')">
                            @csrf @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <div class="mt-4">
            {{ $prestamos->links() }}
        </div>
    </div>
    <script>
        function buscarEnTabla() {
            const input = document.getElementById('buscador').value.toLowerCase();
            const filas = document.querySelectorAll('tbody tr');
            filas.forEach(fila => {
                const texto = fila.innerText.toLowerCase();
                fila.style.display = texto.includes(input) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>