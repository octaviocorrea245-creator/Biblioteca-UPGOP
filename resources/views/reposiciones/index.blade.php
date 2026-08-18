<x-app-layout>
    <x-slot name="header">Reposiciones</x-slot>

    <style>
        .page-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; margin-bottom:1.1rem; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.42rem .9rem; border-radius:8px; font-size:.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-primary { background:#1A56B0; color:#fff; }
        .btn-sm { padding:.28rem .65rem; font-size:.7rem; border-radius:6px; }
        .btn-pay    { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .btn-pay:hover { background:#27AE60; color:#fff; }
        .btn-comp   { background:#F4F4F4; color:#555; border:1px solid #DDD; }
        .btn-comp:hover { background:#555; color:#fff; }
        .btn-del    { background:#FDF0EF; color:#C0392B; border:1px solid #F5C6C2; }
        .btn-del:hover { background:#C0392B; color:#fff; }
        .search-wrap { margin-bottom:.9rem; }
        .search-wrap input { width:100%; border:1.5px solid #E0E8F4; border-radius:8px; padding:.5rem .85rem; font-size:.82rem; color:#2D3E58; outline:none; transition:border .2s; background:#fff; }
        .search-wrap input:focus { border-color:#1A56B0; }
        .alert { padding:.6rem 1rem; border-radius:8px; font-size:.8rem; font-weight:500; margin-bottom:.9rem; }
        .alert-success { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .alert-error   { background:#FDECEA; color:#922B21; border:1px solid #F1948A; }
        .import-box { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); padding:1rem 1.25rem; margin-bottom:1.1rem; }
        .import-box h4 { font-size:.85rem; font-weight:700; color:#0D1B35; margin:0 0 .75rem; }
        .import-row { display:flex; gap:.75rem; align-items:flex-end; flex-wrap:wrap; }
        .import-row input[type=file] { flex:1; min-width:200px; border:1.5px solid #E0E8F4; border-radius:8px; padding:.4rem .75rem; font-size:.78rem; }
        .tbl-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; }
        .tbl-wrap table { width:100%; border-collapse:collapse; font-size:.78rem; }
        .tbl-wrap thead tr { background:#0D1B35; }
        .tbl-wrap thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.68rem; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }
        .tbl-wrap tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        .tbl-wrap tbody tr:hover { background:#F7F9FD; }
        .tbl-wrap td { padding:.5rem .85rem; color:#2D3E58; vertical-align:middle; }
        .tbl-wrap td.muted { color:#8496B0; font-size:.73rem; }
        .badge { display:inline-block; padding:.18rem .55rem; border-radius:20px; font-size:.68rem; font-weight:600; }
        .badge-red    { background:#FDECEA; color:#922B21; }
        .badge-orange { background:#FEF5E7; color:#B7770D; }
        .badge-green  { background:#EAFAF1; color:#1E8449; }
        .monto { font-weight:600; color:#C0392B; }
        .actions { display:flex; gap:.3rem; align-items:center; flex-wrap:nowrap; }
        .pagination-wrap { padding:.65rem 1rem; border-top:1px solid #F0F4FA; }
    </style>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

    <div class="page-bar">
        <a href="{{ route('reposiciones.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nueva Reposición
        </a>
        <span style="font-size:.75rem; color:#8496B0;">{{ $reposiciones->total() }} reposiciones</span>
    </div>

    {{-- Importar XML --}}
    <div class="import-box">
        <h4>Carga masiva vía XML</h4>
        <form action="{{ route('reposiciones.importar') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="import-row">
                <input type="file" name="xml_file" accept=".xml">
                @error('xml_file')<span style="font-size:.73rem; color:#C0392B;">{{ $message }}</span>@enderror
                <button type="submit" class="btn btn-primary">Importar XML</button>
            </div>
            <p style="font-size:.7rem; color:#8496B0; margin:.5rem 0 0;">Raíz: <code>&lt;reposiciones&gt;</code> — Elementos: <code>&lt;reposicion&gt;</code> con <code>prestamo_id</code>, <code>tipo</code>, <code>monto</code>, <code>fecha_reporte</code>.</p>
        </form>
    </div>

    <div class="search-wrap">
        <input type="text" id="buscador" placeholder="Buscar por alumno o libro..." onkeyup="filtrar()">
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Alumno</th>
                    <th>Libro</th>
                    <th>Tipo</th>
                    <th>Monto</th>
                    <th>Estado pago</th>
                    <th>F. Reporte</th>
                    <th>F. Pago</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($reposiciones as $r)
                <tr>
                    <td style="font-weight:500;">{{ $r->alumno->nombre }}</td>
                    <td class="muted" style="max-width:150px;">{{ \Illuminate\Support\Str::limit($r->libro->titulo, 30) }}</td>
                    <td>
                        @if($r->tipo === 'Perdida')
                            <span class="badge badge-red">Pérdida</span>
                        @else
                            <span class="badge badge-orange">Daño</span>
                        @endif
                    </td>
                    <td><span class="monto">${{ number_format($r->monto, 2) }}</span></td>
                    <td>
                        @if($r->estado_pago === 'Pendiente')
                            <span class="badge badge-orange">Pendiente</span>
                        @else
                            <span class="badge badge-green">Pagado</span>
                        @endif
                    </td>
                    <td class="muted">{{ $r->fecha_reporte->format('d/m/Y') }}</td>
                    <td class="muted">{{ $r->fecha_pago ? $r->fecha_pago->format('d/m/Y') : '—' }}</td>
                    <td>
                        <div class="actions">
                            @if($r->estado_pago === 'Pendiente')
                            <form action="{{ route('reposiciones.pago', $r) }}" method="POST"
                                  onsubmit="return confirm('¿Registrar pago?')">
                                @csrf @method('PATCH')
                                <button class="btn btn-sm btn-pay">Pagar</button>
                            </form>
                            @endif
                            <a href="{{ route('reposiciones.comprobante', $r) }}" class="btn btn-sm btn-comp" target="_blank">PDF</a>
                            <form action="{{ route('reposiciones.destroy', $r) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta reposición?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-del">✕</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="padding:1.5rem; text-align:center; color:#8496B0;">Sin reposiciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $reposiciones->links() }}</div>
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
