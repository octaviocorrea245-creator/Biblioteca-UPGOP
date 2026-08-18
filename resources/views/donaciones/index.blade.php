<x-app-layout>
    <x-slot name="header">Donaciones</x-slot>

    <style>
        .page-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; margin-bottom:1.1rem; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.42rem .9rem; border-radius:8px; font-size:.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-primary { background:#1A56B0; color:#fff; }
        .btn-purple  { background:#7D3C98; color:#fff; }
        .btn-tpl     { background:#F4F6FB; color:#2D3E58; border:1px solid #D8E2EF; }
        .btn-tpl:hover{ background:#0D1B35; color:#fff; border-color:#0D1B35; }
        .btn-sm { padding:.28rem .65rem; font-size:.72rem; border-radius:6px; }
        .btn-edit { background:#F0F4FF; color:#1A56B0; border:1px solid #C7D9F5; }
        .btn-edit:hover { background:#1A56B0; color:#fff; }
        .btn-del { background:#FDF0EF; color:#C0392B; border:1px solid #F5C6C2; }
        .btn-del:hover { background:#C0392B; color:#fff; }
        .search-wrap { margin-bottom:.9rem; }
        .search-wrap input { width:100%; border:1.5px solid #E0E8F4; border-radius:8px; padding:.5rem .85rem; font-size:.82rem; color:#2D3E58; outline:none; transition:border .2s; background:#fff; }
        .search-wrap input:focus { border-color:#1A56B0; }
        .alert { padding:.6rem 1rem; border-radius:8px; font-size:.8rem; font-weight:500; margin-bottom:.9rem; }
        .alert-success { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .tbl-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; }
        .tbl-wrap table { width:100%; border-collapse:collapse; font-size:.8rem; }
        .tbl-wrap thead tr { background:#0D1B35; }
        .tbl-wrap thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }
        .tbl-wrap tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        .tbl-wrap tbody tr:hover { background:#F7F9FD; }
        .tbl-wrap td { padding:.55rem .85rem; color:#2D3E58; vertical-align:middle; }
        .tbl-wrap td.muted { color:#8496B0; font-size:.75rem; }
        .actions { display:flex; gap:.35rem; align-items:center; }
        .pagination-wrap { padding:.65rem 1rem; border-top:1px solid #F0F4FA; }
    </style>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif

    <div class="page-bar">
        <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
            <a href="{{ route('donaciones.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nueva Donación
            </a>
            <a href="{{ route('libros.importar.donaciones.form') }}" class="btn btn-purple">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Importar Excel
            </a>
            <a href="{{ route('libros.plantilla.donaciones') }}" class="btn btn-tpl">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Plantilla Excel
            </a>
        </div>
        <span style="font-size:.75rem; color:#8496B0;">{{ $donaciones->total() }} donaciones</span>
    </div>

    <div class="search-wrap">
        <input type="text" id="buscador" placeholder="Buscar por título, autor o donante..." onkeyup="filtrar()">
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Donante</th>
                    <th>Carrera</th>
                    <th>Fecha</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($donaciones as $d)
                <tr>
                    <td class="muted" style="font-family:monospace;">{{ $d->codigo_donacion }}</td>
                    <td style="font-weight:500;">{{ $d->titulo }}</td>
                    <td class="muted">{{ $d->autor ?: '—' }}</td>
                    <td class="muted">{{ $d->alumno_donante ?: '—' }}</td>
                    <td class="muted">{{ $d->carrera?->nombre ?? '—' }}</td>
                    <td class="muted">{{ $d->fecha?->format('d/m/Y') ?? '—' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('donaciones.edit', $d) }}" class="btn btn-sm btn-edit">Editar</a>
                            <form action="{{ route('donaciones.destroy', $d) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta donación?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-del">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" style="padding:1.5rem; text-align:center; color:#8496B0;">Sin donaciones registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $donaciones->links() }}</div>
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
