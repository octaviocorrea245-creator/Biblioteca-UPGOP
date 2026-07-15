<x-app-layout>
<<<<<<< HEAD
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
=======
    <x-slot name="header">Dashboard</x-slot>

    <style>
        .dash-welcome {
            background: linear-gradient(135deg, #0D1B35 0%, #1A56B0 100%);
            border-radius: 16px;
            padding: 1.75rem 2rem;
            margin-bottom: 1.75rem;
            position: relative;
            overflow: hidden;
        }
        .dash-welcome::before {
            content: '';
            position: absolute;
            top: -30px; right: -30px;
            width: 180px; height: 180px;
            border-radius: 50%;
            background: rgba(255,255,255,.04);
        }
        .dash-welcome::after {
            content: '';
            position: absolute;
            bottom: -50px; right: 80px;
            width: 120px; height: 120px;
            border-radius: 50%;
            background: rgba(192,57,43,.15);
        }
        .dash-welcome h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: 1.55rem;
            font-weight: 700;
            line-height: 1.3;
        }
        .dash-welcome p { color: rgba(255,255,255,.65); font-size: .82rem; margin-top: .35rem; }
        .dash-welcome .red-bar { height: 3px; width: 38px; background: linear-gradient(90deg,#C0392B,#E74C3C); border-radius:2px; margin: .6rem 0; }
        .welcome-badge {
            display: inline-flex; align-items: center; gap: .35rem;
            background: rgba(255,255,255,.1); border-radius: 20px;
            padding: .25rem .75rem; color: rgba(255,255,255,.75);
            font-size: .65rem; font-weight: 600; letter-spacing: .08em; text-transform: uppercase;
            margin-bottom: .6rem;
        }

        /* Stat cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(210px, 1fr));
            gap: 1rem;
            margin-bottom: 1.75rem;
        }
        .stat-card {
            background: #fff;
            border-radius: 14px;
            padding: 1.3rem;
            box-shadow: 0 1px 3px rgba(13,27,53,.05), 0 4px 14px rgba(13,27,53,.04);
            border-top: 3px solid transparent;
            transition: transform .2s, box-shadow .2s;
            text-decoration: none; color: inherit; display: block;
        }
        .stat-card:hover { transform: translateY(-3px); box-shadow: 0 6px 24px rgba(13,27,53,.10); }
        .stat-icon {
            width: 42px; height: 42px; border-radius: 11px;
            display: flex; align-items: center; justify-content: center;
            margin-bottom: .9rem;
        }
        .stat-icon svg { width: 20px; height: 20px; }
        .stat-value { font-size: 1.9rem; font-weight: 700; color: #0D1B35; line-height: 1; }
        .stat-label { font-size: .75rem; color: #8496B0; margin-top: 3px; font-weight: 500; }
        .stat-sub { font-size: .7rem; margin-top: .5rem; font-weight: 600; }

        /* color variants */
        .c-blue  { border-top-color: #1A56B0; }
        .c-navy  { border-top-color: #0D1B35; }
        .c-red   { border-top-color: #C0392B; }
        .c-green { border-top-color: #27AE60; }
        .c-orange{ border-top-color: #E67E22; }
        .c-teal  { border-top-color: #16A085; }
        .c-purple{ border-top-color: #8E44AD; }

        .ic-blue   { background: rgba(26,86,176,.1);  color: #1A56B0; }
        .ic-navy   { background: rgba(13,27,53,.08);  color: #0D1B35; }
        .ic-red    { background: rgba(192,57,43,.1);  color: #C0392B; }
        .ic-green  { background: rgba(39,174,96,.1);  color: #27AE60; }
        .ic-orange { background: rgba(230,126,34,.1); color: #E67E22; }
        .ic-teal   { background: rgba(22,160,133,.1); color: #16A085; }
        .ic-purple { background: rgba(142,68,173,.1); color: #8E44AD; }

        .sub-blue   { color: #1A56B0; }
        .sub-red    { color: #C0392B; }
        .sub-green  { color: #27AE60; }
        .sub-orange { color: #E67E22; }

        /* Modules section */
        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.1rem; font-weight: 700; color: #0D1B35;
            margin-bottom: .35rem;
        }
        .modules-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(170px, 1fr));
            gap: .85rem;
        }
        .mod-card {
            background: #fff;
            border-radius: 12px;
            padding: 1.2rem 1rem;
            text-align: center;
            text-decoration: none;
            color: inherit;
            box-shadow: 0 1px 3px rgba(13,27,53,.05);
            transition: all .2s;
            border: 1.5px solid #E8EDF5;
        }
        .mod-card:hover {
            border-color: #1A56B0;
            box-shadow: 0 4px 18px rgba(26,86,176,.1);
            transform: translateY(-2px);
        }
        .mod-icon {
            width: 46px; height: 46px; border-radius: 12px;
            display: flex; align-items: center; justify-content: center;
            margin: 0 auto .75rem;
        }
        .mod-icon svg { width: 22px; height: 22px; }
        .mod-name { font-size: .82rem; font-weight: 600; color: #2D3E58; }
        .mod-desc { font-size: .68rem; color: #8496B0; margin-top: 2px; }

        /* Divider */
        .section-divider { height: 1px; background: #E8EDF5; margin: 1.5rem 0; }
    </style>

    {{-- Welcome banner --}}
    <div class="dash-welcome">
        <div class="welcome-badge">
            <svg width="10" height="10" fill="currentColor" viewBox="0 0 8 8"><circle cx="4" cy="4" r="4"/></svg>
            Sistema activo
        </div>
        <h1>Bienvenido, {{ explode(' ', Auth::user()->name)[0] }}</h1>
        <div class="red-bar"></div>
        <p>Plataforma de gestión bibliográfica · Universidad Politécnica Gómez Palacio</p>
    </div>

    {{-- Stats --}}
    <div class="stats-grid">
        <a href="{{ route('libros.index') }}" class="stat-card c-blue">
            <div class="stat-icon ic-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="stat-value">{{ $totalLibros }}</div>
            <div class="stat-label">Libros en acervo</div>
            <div class="stat-sub sub-green">{{ $librosDisponibles }} disponibles</div>
        </a>

        <a href="{{ route('alumnos.index') }}" class="stat-card c-navy">
            <div class="stat-icon ic-navy">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            </div>
            <div class="stat-value">{{ $totalAlumnos }}</div>
            <div class="stat-label">Alumnos registrados</div>
            <div class="stat-sub sub-green">{{ $alumnosActivos }} activos</div>
        </a>

        <a href="{{ route('prestamos.index') }}" class="stat-card c-teal">
            <div class="stat-icon ic-teal">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            </div>
            <div class="stat-value">{{ $prestamosActivos }}</div>
            <div class="stat-label">Préstamos activos</div>
            @if($prestamosVencidos > 0)
            <div class="stat-sub sub-red">{{ $prestamosVencidos }} vencidos</div>
            @else
            <div class="stat-sub sub-green">Sin vencidos</div>
            @endif
        </a>

        <a href="{{ route('deudores.index') }}" class="stat-card c-red">
            <div class="stat-icon ic-red">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="stat-value">{{ $deudores }}</div>
            <div class="stat-label">Deudores</div>
            <div class="stat-sub sub-red">{{ $rezagados }} rezagados</div>
        </a>

        <a href="{{ route('donaciones.index') }}" class="stat-card c-purple">
            <div class="stat-icon ic-purple">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="stat-value">{{ $donaciones }}</div>
            <div class="stat-label">Donaciones</div>
            <div class="stat-sub sub-blue">registradas</div>
        </a>

        <a href="{{ route('adquisiciones.index') }}" class="stat-card c-green">
            <div class="stat-icon ic-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            </div>
            <div class="stat-value">{{ $adquisiciones }}</div>
            <div class="stat-label">Adquisiciones</div>
            <div class="stat-sub sub-green">por compra</div>
        </a>

        <a href="{{ route('reposiciones.index') }}" class="stat-card c-orange">
            <div class="stat-icon ic-orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            </div>
            <div class="stat-value">{{ $reposicionesPend }}</div>
            <div class="stat-label">Reposiciones</div>
            <div class="stat-sub sub-orange">pago pendiente</div>
        </a>

        <a href="{{ route('carreras.index') }}" class="stat-card c-blue">
            <div class="stat-icon ic-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
            </div>
            <div class="stat-value">{{ $carreras }}</div>
            <div class="stat-label">Carreras activas</div>
            <div class="stat-sub sub-blue">registradas</div>
        </a>
    </div>

    <div class="section-divider"></div>

    {{-- Quick access modules --}}
    <div class="section-title">Acceso rápido</div>
    <div class="red-bar" style="margin-bottom:1.1rem;"></div>

    <div class="modules-grid">
        <a href="{{ route('libros.create') }}" class="mod-card">
            <div class="mod-icon ic-blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
            </div>
            <div class="mod-name">Nuevo Libro</div>
            <div class="mod-desc">Registrar al acervo</div>
        </a>
        <a href="{{ route('alumnos.create') }}" class="mod-card">
            <div class="mod-icon ic-navy">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="8.5" cy="7" r="4"/><line x1="20" y1="8" x2="20" y2="14"/><line x1="23" y1="11" x2="17" y2="11"/></svg>
            </div>
            <div class="mod-name">Nuevo Alumno</div>
            <div class="mod-desc">Registrar alumno</div>
        </a>
        <a href="{{ route('prestamos.create') }}" class="mod-card">
            <div class="mod-icon ic-teal">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
            </div>
            <div class="mod-name">Nuevo Préstamo</div>
            <div class="mod-desc">Registrar préstamo</div>
        </a>
        <a href="{{ route('donaciones.create') }}" class="mod-card">
            <div class="mod-icon ic-purple">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
            </div>
            <div class="mod-name">Nueva Donación</div>
            <div class="mod-desc">Registrar donación</div>
        </a>
        <a href="{{ route('adquisiciones.create') }}" class="mod-card">
            <div class="mod-icon ic-green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
            </div>
            <div class="mod-name">Nueva Adquisición</div>
            <div class="mod-desc">Registrar compra</div>
        </a>
        <a href="{{ route('reposiciones.create') }}" class="mod-card">
            <div class="mod-icon ic-orange">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
            </div>
            <div class="mod-name">Nueva Reposición</div>
            <div class="mod-desc">Pérdida o daño</div>
        </a>
        <a href="{{ route('reportes.index') }}" class="mod-card">
            <div class="mod-icon" style="background:rgba(13,27,53,.08);color:#0D1B35;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            </div>
            <div class="mod-name">Reportes PDF</div>
            <div class="mod-desc">Generar reportes</div>
        </a>
        <a href="{{ route('deudores.index') }}" class="mod-card">
            <div class="mod-icon ic-red">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            </div>
            <div class="mod-name">Deudores</div>
            <div class="mod-desc">Ver deudores</div>
        </a>
>>>>>>> e457021ea82fbed4256465eab0b8d4a95f667977
    </div>
</x-app-layout>
