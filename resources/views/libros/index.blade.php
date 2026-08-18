<x-app-layout>
    <x-slot name="header">Catálogo de Libros</x-slot>

    <style>
        .page-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; margin-bottom:1.1rem; }
        .page-bar-left { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.42rem .9rem; border-radius:8px; font-size:.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-primary { background:#1A56B0; color:#fff; }
        .btn-success { background:#27AE60; color:#fff; }
        .btn-warning  { background:#E67E22; color:#fff; }
        .btn-tpl      { background:#F4F6FB; color:#2D3E58; border:1px solid #D8E2EF; }
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
        .alert-error   { background:#FDECEA; color:#922B21; border:1px solid #F1948A; }

        .tbl-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; }
        .tbl-wrap table { width:100%; border-collapse:collapse; font-size:.8rem; }
        .tbl-wrap thead tr { background:#0D1B35; }
        .tbl-wrap thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }
        .tbl-wrap tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        .tbl-wrap tbody tr:hover { background:#F7F9FD; }
        .tbl-wrap td { padding:.55rem .85rem; color:#2D3E58; vertical-align:middle; }
        .tbl-wrap td.muted { color:#8496B0; font-size:.75rem; }

        .badge { display:inline-block; padding:.18rem .55rem; border-radius:20px; font-size:.68rem; font-weight:600; }
        .badge-blue   { background:#EBF3FD; color:#1A56B0; }
        .badge-green  { background:#EAFAF1; color:#1E8449; }
        .badge-purple { background:#F4ECF7; color:#7D3C98; }
        .badge-orange { background:#FEF5E7; color:#B7770D; }
        .badge-red    { background:#FDECEA; color:#922B21; }
        .badge-gray   { background:#F2F3F4; color:#626567; }

        .disp { font-weight:600; color:#0D1B35; }
        .disp-low { color:#C0392B; }

        .actions { display:flex; gap:.35rem; align-items:center; flex-wrap:nowrap; }
        .pagination-wrap { padding:.65rem 1rem; border-top:1px solid #F0F4FA; }
    </style>

    {{-- Alertas --}}
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    {{-- Barra superior --}}
    <div class="page-bar">
        <div class="page-bar-left">
            <a href="{{ route('libros.create') }}" class="btn btn-primary">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Nuevo Libro
            </a>
            <a href="{{ route('libros.importar.form') }}" class="btn btn-success">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                Carga Masiva Excel
            </a>
            <a href="{{ route('libros.pendientes') }}" class="btn btn-warning">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Pendientes Código
            </a>
            <a href="{{ route('libros.plantilla') }}" class="btn btn-tpl">
                <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="7 10 12 15 17 10"/><line x1="12" y1="15" x2="12" y2="3"/></svg>
                Plantilla Excel
            </a>
        </div>
        <span style="font-size:.75rem; color:#8496B0;">{{ $libros->total() }} libros</span>
    </div>

    {{-- Buscador --}}
    <div class="search-wrap">
        <form method="GET" action="{{ route('libros.index') }}">
            <input type="text" name="buscar" value="{{ request('buscar') }}"
                   placeholder="Buscar por título, autor, código o código de barras... (Enter para buscar)">
        </form>
    </div>

    {{-- Tabla --}}
    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Código</th>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Tipo</th>
                    <th>Carrera</th>
                    <th>Disp.</th>
                    <th>Loc.</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($libros as $libro)
                <tr>
                    <td class="muted" style="font-family:monospace;">{{ $libro->codigo }}</td>
                    <td style="max-width:220px; font-weight:500;">{{ $libro->titulo }}</td>
                    <td class="muted">{{ $libro->autor ?: '—' }}</td>
                    <td>
                        @if($libro->tipo === 'Regular')
                            <span class="badge badge-blue">Regular</span>
                        @elseif($libro->tipo === 'Donado')
                            <span class="badge badge-green">Donado</span>
                        @elseif($libro->tipo === 'Adquirido')
                            <span class="badge badge-purple">Adquirido</span>
                        @else
                            <span class="badge badge-gray">{{ $libro->tipo }}</span>
                        @endif
                    </td>
                    <td class="muted">{{ $libro->carrera?->nombre ?? '—' }}</td>
                    <td>
                        <span class="disp {{ $libro->cantidad_disponible == 0 ? 'disp-low' : '' }}">
                            {{ $libro->cantidad_disponible }}
                        </span>
                        <span class="muted">/ {{ $libro->cantidad_total }}</span>
                    </td>
                    <td class="muted">{{ $libro->localizacion ?: '—' }}</td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('libros.edit', $libro) }}" class="btn btn-sm btn-edit">Editar</a>
                            <form action="{{ route('libros.destroy', $libro) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar este libro?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-del">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" style="padding:1.5rem; text-align:center; color:#8496B0;">Sin libros registrados.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="pagination-wrap">{{ $libros->links() }}</div>
    </div>
</x-app-layout>
