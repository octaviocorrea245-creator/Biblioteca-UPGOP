<x-app-layout>
    <x-slot name="header">Reportes</x-slot>

    <style>
        .rep-grid { display:grid; grid-template-columns:1fr 1fr; gap:1rem; }
        @media(max-width:720px){ .rep-grid { grid-template-columns:1fr; } }

        .rep-card { background:#fff; border-radius:12px; box-shadow:0 1px 4px rgba(13,27,53,.07); overflow:hidden; }
        .rep-card-head { background:#0D1B35; padding:.7rem 1rem; display:flex; align-items:center; gap:.55rem; }
        .rep-card-head svg { opacity:.75; }
        .rep-card-head h3 { font-size:.82rem; font-weight:700; color:#fff; margin:0; text-transform:uppercase; letter-spacing:.06em; }
        .rep-card-body { padding:1rem 1.1rem; }

        .field-row { display:flex; gap:.6rem; flex-wrap:wrap; align-items:flex-end; }
        .field-group { display:flex; flex-direction:column; gap:.28rem; flex:1; min-width:130px; }
        .field-group label { font-size:.68rem; font-weight:600; color:#8496B0; text-transform:uppercase; letter-spacing:.05em; }
        .field-group select,
        .field-group input { border:1.5px solid #E0E8F4; border-radius:8px; padding:.42rem .75rem; font-size:.8rem; color:#2D3E58; background:#fff; outline:none; transition:border .2s; width:100%; }
        .field-group select:focus,
        .field-group input:focus { border-color:#1A56B0; }

        .btn-row { display:flex; gap:.5rem; flex-wrap:wrap; margin-top:.85rem; }
        .btn { display:inline-flex; align-items:center; gap:.35rem; padding:.38rem .85rem; border-radius:8px; font-size:.76rem; font-weight:700; cursor:pointer; border:none; text-decoration:none; transition:opacity .15s,transform .15s; white-space:nowrap; }
        .btn:hover { opacity:.88; transform:translateY(-1px); }
        .btn-pdf   { background:#1A56B0; color:#fff; }
        .btn-excel { background:#1E8449; color:#fff; }
        .btn-deudor  { background:#B7770D; color:#fff; }
        .btn-rezagado{ background:#C0392B; color:#fff; }

        .divider-full { grid-column:1/-1; }

        .quick-links { display:flex; gap:.6rem; flex-wrap:wrap; padding:.15rem 0; }

        .alert-success { background:#EAFAF1; color:#1E8449; border:1px solid #A9DFBF; padding:.55rem .9rem; border-radius:8px; font-size:.8rem; font-weight:500; margin-bottom:.9rem; }
    </style>

    @if(session('success'))
        <div class="alert-success">{{ session('success') }}</div>
    @endif

    <div class="rep-grid">

        {{-- ① Mensual --}}
        <div class="rep-card">
            <div class="rep-card-head">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                <h3>Préstamos Mensual</h3>
            </div>
            <div class="rep-card-body">
                <form method="GET">
                    <div class="field-row">
                        <div class="field-group">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">Todas las carreras</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="max-width:120px;">
                            <label>Mes</label>
                            <select name="mes">
                                @foreach(range(1,12) as $m)
                                    <option value="{{ $m }}" {{ $m == date('n') ? 'selected' : '' }}>
                                        {{ DateTime::createFromFormat('!m', $m)->format('F') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="max-width:90px;">
                            <label>Año</label>
                            <input type="number" name="anio" value="{{ date('Y') }}" min="2000" max="2099">
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" formaction="{{ route('reportes.prestamensuales') }}" class="btn btn-pdf">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                        </button>
                        <button type="submit" formaction="{{ route('reportes.prestamensuales.excel') }}" class="btn btn-excel">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ② Cuatrimestral --}}
        <div class="rep-card">
            <div class="rep-card-head">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/><line x1="8" y1="14" x2="16" y2="14"/></svg>
                <h3>Préstamos Cuatrimestral</h3>
            </div>
            <div class="rep-card-body">
                <form method="GET">
                    <div class="field-row">
                        <div class="field-group">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">Todas las carreras</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="max-width:130px;">
                            <label>Cuatrimestre</label>
                            <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1">
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" formaction="{{ route('reportes.prestamoscuatrimestrales') }}" class="btn btn-pdf">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ③ Donaciones --}}
        <div class="rep-card">
            <div class="rep-card-head">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                <h3>Donaciones</h3>
            </div>
            <div class="rep-card-body">
                <form method="GET">
                    <div class="field-row">
                        <div class="field-group">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">Todas las carreras</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="max-width:130px;">
                            <label>Cuatrimestre</label>
                            <input type="text" name="cuatrimestre" placeholder="Ej: 2026-1">
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" formaction="{{ route('reportes.donaciones') }}" class="btn btn-pdf">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                        </button>
                        <button type="submit" formaction="{{ route('reportes.donaciones.excel') }}" class="btn btn-excel">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ④ Adquisiciones --}}
        <div class="rep-card">
            <div class="rep-card-head">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><circle cx="9" cy="21" r="1"/><circle cx="20" cy="21" r="1"/><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"/></svg>
                <h3>Adquisiciones</h3>
            </div>
            <div class="rep-card-body">
                <form method="GET">
                    <div class="field-row">
                        <div class="field-group">
                            <label>Carrera</label>
                            <select name="carrera_id">
                                <option value="">Todas las carreras</option>
                                @foreach($carreras as $carrera)
                                    <option value="{{ $carrera->id }}">{{ $carrera->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="field-group" style="max-width:150px;">
                            <label>Proveedor</label>
                            <input type="text" name="proveedor" placeholder="Filtrar por proveedor">
                        </div>
                    </div>
                    <div class="btn-row">
                        <button type="submit" formaction="{{ route('reportes.adquisiciones') }}" class="btn btn-pdf">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            PDF
                        </button>
                        <button type="submit" formaction="{{ route('reportes.adquisiciones.excel') }}" class="btn btn-excel">
                            <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                            Excel
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- ⑤ Deudores y Rezagados (full width) --}}
        <div class="rep-card divider-full">
            <div class="rep-card-head">
                <svg width="15" height="15" fill="none" stroke="#fff" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                <h3>Deudores y Rezagados</h3>
            </div>
            <div class="rep-card-body">
                <div class="quick-links">
                    <a href="{{ route('reportes.deudores') }}" class="btn btn-deudor">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Deudores PDF
                    </a>
                    <a href="{{ route('reportes.deudores.excel') }}" class="btn btn-excel">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Deudores Excel
                    </a>
                    <a href="{{ route('reportes.rezagados') }}" class="btn btn-rezagado">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Rezagados PDF
                    </a>
                    <a href="{{ route('reportes.rezagados.excel') }}" class="btn btn-excel">
                        <svg width="12" height="12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                        Rezagados Excel
                    </a>
                </div>
            </div>
        </div>

    </div>
</x-app-layout>
