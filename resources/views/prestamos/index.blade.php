<x-app-layout>
    <x-slot name="header">Préstamos</x-slot>

    <style>
        .page-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; margin-bottom:1.1rem; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.42rem .9rem; border-radius:8px; font-size:.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-primary { background:#1A56B0; color:#fff; }
        .btn-sm { padding:.28rem .65rem; font-size:.7rem; border-radius:6px; }
        .btn-view   { background:#F0F4FF; color:#1A56B0; border:1px solid #C7D9F5; }
        .btn-view:hover { background:#1A56B0; color:#fff; }
        .btn-pdf    { background:#F4F4F4; color:#555; border:1px solid #DDD; }
        .btn-pdf:hover { background:#555; color:#fff; }
        .btn-return { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .btn-return:hover { background:#27AE60; color:#fff; }
        .btn-del    { background:#FDF0EF; color:#C0392B; border:1px solid #F5C6C2; }
        .btn-del:hover { background:#C0392B; color:#fff; }
        .search-wrap { margin-bottom:.9rem; }
        .search-wrap input { width:100%; border:1.5px solid #E0E8F4; border-radius:8px; padding:.5rem .85rem; font-size:.82rem; color:#2D3E58; outline:none; transition:border .2s; background:#fff; }
        .search-wrap input:focus { border-color:#1A56B0; }
        .alert { padding:.6rem 1rem; border-radius:8px; font-size:.8rem; font-weight:500; margin-bottom:.9rem; }
        .alert-success { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .alert-error   { background:#FDECEA; color:#922B21; border:1px solid #F1948A; }
        .alert-warn    { background:#FEF9E7; color:#B7770D; border:1px solid #F9E79F; }
        .tbl-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; }
        .tbl-wrap table { width:100%; border-collapse:collapse; font-size:.78rem; }
        .tbl-wrap thead tr { background:#0D1B35; }
        .tbl-wrap thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.68rem; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }
        .tbl-wrap tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        .tbl-wrap tbody tr:hover { background:#F7F9FD; }
        .tbl-wrap tbody tr.row-vencido { background:#FDF3F2; }
        .tbl-wrap tbody tr.row-proximo { background:#FEFDF0; }
        .tbl-wrap td { padding:.5rem .85rem; color:#2D3E58; vertical-align:middle; }
        .tbl-wrap td.muted { color:#8496B0; font-size:.73rem; }
        .badge { display:inline-block; padding:.18rem .55rem; border-radius:20px; font-size:.67rem; font-weight:600; }
        .badge-green  { background:#EAFAF1; color:#1E8449; }
        .badge-blue   { background:#EBF3FD; color:#1A56B0; }
        .badge-red    { background:#FDECEA; color:#922B21; }
        .badge-orange { background:#FEF5E7; color:#B7770D; }
        .actions { display:flex; gap:.3rem; align-items:center; flex-wrap:nowrap; }
        .pagination-wrap { padding:.65rem 1rem; border-top:1px solid #F0F4FA; }
        .folio { font-family:monospace; font-weight:700; color:#1A56B0; }
    </style>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

    @php
        $vencidos = $prestamos->filter(fn($p) => strtolower(trim($p->estado)) === 'vencido');
        $proximos = $prestamos->filter(fn($p) =>
            strtolower(trim($p->estado)) === 'activo' &&
            now()->diffInDays($p->fecha_devolucion_esperada, false) <= 3 &&
            now()->diffInDays($p->fecha_devolucion_esperada, false) >= 0
        );
    @endphp

    @if($vencidos->count() > 0)
        <div class="alert alert-error">
            <strong>{{ $vencidos->count() }} préstamo(s) vencido(s)</strong> — El alumno ha sido marcado como Deudor.
        </div>
    @endif
    @if($proximos->count() > 0)
        <div class="alert alert-warn">
            <strong>{{ $proximos->count() }} préstamo(s) vencen en los próximos 3 días</strong> — Revisa las filas resaltadas.
        </div>
    @endif

    <div class="page-bar">
        <a href="{{ route('prestamos.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nuevo Préstamo
        </a>
        <span style="font-size:.75rem; color:#8496B0;">{{ $prestamos->total() }} préstamos</span>
    </div>

    <div class="search-wrap">
        <input type="text" id="buscador" placeholder="Buscar por alumno, libro, folio o carrera..." onkeyup="filtrar()">
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Alumno</th>
                    <th>Libro</th>
                    <th>Carrera</th>
                    <th>Cuat.</th>
                    <th>F. Préstamo</th>
                    <th>F. Esperada</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $p)
                @php
                    $dias = now()->startOfDay()->diffInDays($p->fecha_devolucion_esperada->startOfDay(), false);
                    $esVencido = strtolower(trim($p->estado)) === 'vencido';
                    $esProximo = strtolower(trim($p->estado)) === 'activo' && $dias <= 3 && $dias >= 0;
                    $estadoLower = strtolower(trim($p->estado));
                @endphp
                <tr class="{{ $esVencido ? 'row-vencido' : ($esProximo ? 'row-proximo' : '') }}">
                    <td><span class="folio">#{{ $p->folio }}</span></td>
                    <td style="font-weight:500;">{{ $p->alumno->nombre }}</td>
                    <td class="muted" style="max-width:160px;">{{ \Illuminate\Support\Str::limit($p->libro->titulo, 30) }}</td>
                    <td class="muted">{{ $p->carrera->nombre }}</td>
                    <td class="muted" style="text-align:center;">{{ $p->cuatrimestre }}°</td>
                    <td class="muted">{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                    <td>
                        <div style="font-size:.75rem; color:#2D3E58;">{{ $p->fecha_devolucion_esperada->format('d/m/Y') }}</div>
                        @if($esVencido)
                            <span class="badge badge-red" style="margin-top:2px;">VENCIDO</span>
                        @elseif($esProximo)
                            <span class="badge badge-orange" style="margin-top:2px;">
                                {{ $dias == 0 ? 'Hoy' : ($dias == 1 ? 'Mañana' : $dias.' días') }}
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($estadoLower === 'activo')
                            <span class="badge badge-green">Activo</span>
                        @elseif($estadoLower === 'devuelto')
                            <span class="badge badge-blue">Devuelto</span>
                        @else
                            <span class="badge badge-red">Vencido</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('prestamos.show', $p) }}" class="btn btn-sm btn-view">Ver</a>
                            <a href="{{ route('prestamos.vale', $p) }}" class="btn btn-sm btn-pdf" target="_blank">PDF</a>
                            @if($estadoLower === 'activo')
                            <form action="{{ route('prestamos.devolver', $p) }}" method="POST"
                                  onsubmit="return confirm('¿Registrar devolución?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-return">Devolver</button>
                            </form>
                            @endif
                            <form action="{{ route('prestamos.destroy', $p) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este préstamo?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-del">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="9" style="padding:1.5rem; text-align:center; color:#8496B0;">Sin préstamos registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $prestamos->links() }}</div>
    </div>

    <script>
        function filtrar() {
            const q = document.getElementById('buscador').value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(r => {
                r.style.display = r.innerText.toLowerCase().includes(q) ? '' : 'none';
            });
        }
    </script>
</x-app-layout>
