<x-app-layout>
    <x-slot name="header">Carreras</x-slot>

    <style>
        .page-bar { display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.6rem; margin-bottom:1.1rem; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.42rem .9rem; border-radius:8px; font-size:.78rem; font-weight:600; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-primary { background:#1A56B0; color:#fff; }
        .btn-sm { padding:.28rem .65rem; font-size:.72rem; border-radius:6px; }
        .btn-edit { background:#F0F4FF; color:#1A56B0; border:1px solid #C7D9F5; }
        .btn-edit:hover { background:#1A56B0; color:#fff; }
        .btn-del { background:#FDF0EF; color:#C0392B; border:1px solid #F5C6C2; }
        .btn-del:hover { background:#C0392B; color:#fff; }
        .alert { padding:.6rem 1rem; border-radius:8px; font-size:.8rem; font-weight:500; margin-bottom:.9rem; }
        .alert-success { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; }
        .alert-error   { background:#FDECEA; color:#922B21; border:1px solid #F1948A; }
        .tbl-wrap { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; }
        .tbl-wrap table { width:100%; border-collapse:collapse; font-size:.8rem; }
        .tbl-wrap thead tr { background:#0D1B35; }
        .tbl-wrap thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; }
        .tbl-wrap tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        .tbl-wrap tbody tr:hover { background:#F7F9FD; }
        .tbl-wrap td { padding:.55rem .85rem; color:#2D3E58; vertical-align:middle; }
        .tbl-wrap td.muted { color:#8496B0; font-size:.75rem; }
        .badge { display:inline-block; padding:.18rem .55rem; border-radius:20px; font-size:.68rem; font-weight:600; }
        .badge-green { background:#EAFAF1; color:#1E8449; }
        .badge-gray  { background:#F2F3F4; color:#626567; }
        .actions { display:flex; gap:.35rem; align-items:center; }
    </style>

    @if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
    @if(session('error'))<div class="alert alert-error">{{ session('error') }}</div>@endif

    <div class="page-bar">
        <a href="{{ route('carreras.create') }}" class="btn btn-primary">
            <svg width="13" height="13" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nueva Carrera
        </a>
        <span style="font-size:.75rem; color:#8496B0;">{{ count($carreras) }} carreras</span>
    </div>

    <div class="tbl-wrap">
        <table>
            <thead>
                <tr>
                    <th>Clave</th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($carreras as $c)
                <tr>
                    <td class="muted" style="font-family:monospace; font-weight:600;">{{ $c->clave }}</td>
                    <td style="font-weight:500;">{{ $c->nombre }}</td>
                    <td>
                        @if($c->activa)
                            <span class="badge badge-green">Activa</span>
                        @else
                            <span class="badge badge-gray">Inactiva</span>
                        @endif
                    </td>
                    <td>
                        <div class="actions">
                            <a href="{{ route('carreras.edit', $c) }}" class="btn btn-sm btn-edit">Editar</a>
                            <form action="{{ route('carreras.destroy', $c) }}" method="POST"
                                  onsubmit="return confirm('¿Eliminar esta carrera?')">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-del">Eliminar</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" style="padding:1.5rem; text-align:center; color:#8496B0;">Sin carreras registradas.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>
