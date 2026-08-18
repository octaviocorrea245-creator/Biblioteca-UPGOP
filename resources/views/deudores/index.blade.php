<x-app-layout>
    <x-slot name="header">Deudores y Rezagados</x-slot>

    <style>
        .section-block { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.06); overflow:hidden; margin-bottom:1.25rem; }
        .section-head { display:flex; align-items:center; gap:.75rem; padding:.75rem 1rem; border-bottom:1px solid #F0F4FA; }
        .section-head h3 { font-family:'Playfair Display',serif; font-size:1rem; font-weight:700; color:#0D1B35; margin:0; }
        .count-badge { display:inline-block; padding:.15rem .55rem; border-radius:20px; font-size:.72rem; font-weight:700; }
        .count-yellow { background:#FEF9E7; color:#B7770D; }
        .count-red    { background:#FDECEA; color:#922B21; }
        .count-green  { background:#EAFAF1; color:#1E8449; }
        .empty-msg { padding:1.25rem; text-align:center; font-size:.82rem; color:#27AE60; }
        table { width:100%; border-collapse:collapse; font-size:.8rem; }
        thead tr { background:#0D1B35; }
        thead th { padding:.6rem .85rem; text-align:left; color:rgba(255,255,255,.85); font-weight:600; font-size:.7rem; text-transform:uppercase; letter-spacing:.05em; white-space:nowrap; }
        tbody tr { border-top:1px solid #F0F4FA; transition:background .12s; }
        tbody tr:hover { background:#F7F9FD; }
        td { padding:.55rem .85rem; color:#2D3E58; vertical-align:middle; }
        td.muted { color:#8496B0; font-size:.75rem; }
        .badge { display:inline-block; padding:.18rem .55rem; border-radius:20px; font-size:.68rem; font-weight:600; }
        .badge-yellow { background:#FEF9E7; color:#B7770D; }
        .badge-red    { background:#FDECEA; color:#922B21; }
    </style>

    {{-- DEUDORES --}}
    <div class="section-block">
        <div class="section-head">
            <svg width="18" height="18" fill="none" stroke="#B7770D" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <h3>Deudores</h3>
            <span class="count-badge count-yellow">{{ $deudores->count() }}</span>
        </div>
        @if($deudores->isEmpty())
            <div class="empty-msg">No hay deudores activos.</div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Cuatrimestre</th>
                    <th>Préstamos vencidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deudores as $a)
                <tr>
                    <td class="muted" style="font-family:monospace;">{{ $a->matricula }}</td>
                    <td style="font-weight:500;">{{ $a->nombre }}</td>
                    <td class="muted">{{ $a->carrera->nombre }}</td>
                    <td class="muted" style="text-align:center;">{{ $a->cuatrimestre }}°</td>
                    <td><span class="badge badge-yellow">{{ $a->prestamos->count() }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>

    {{-- REZAGADOS --}}
    <div class="section-block">
        <div class="section-head">
            <svg width="18" height="18" fill="none" stroke="#C0392B" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="4.93" y1="4.93" x2="19.07" y2="19.07"/></svg>
            <h3>Rezagados</h3>
            <span class="count-badge count-red">{{ $rezagados->count() }}</span>
        </div>
        @if($rezagados->isEmpty())
            <div class="empty-msg">No hay rezagados activos.</div>
        @else
        <table>
            <thead>
                <tr>
                    <th>Matrícula</th>
                    <th>Nombre</th>
                    <th>Carrera</th>
                    <th>Cuatrimestre</th>
                    <th>Préstamos vencidos</th>
                </tr>
            </thead>
            <tbody>
                @foreach($rezagados as $a)
                <tr>
                    <td class="muted" style="font-family:monospace;">{{ $a->matricula }}</td>
                    <td style="font-weight:500;">{{ $a->nombre }}</td>
                    <td class="muted">{{ $a->carrera->nombre }}</td>
                    <td class="muted" style="text-align:center;">{{ $a->cuatrimestre }}°</td>
                    <td><span class="badge badge-red">{{ $a->prestamos->count() }}</span></td>
                </tr>
                @endforeach
            </tbody>
        </table>
        @endif
    </div>
</x-app-layout>
