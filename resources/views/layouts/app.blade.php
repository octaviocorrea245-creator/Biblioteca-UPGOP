<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Biblioteca UPGOP</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Playfair+Display:wght@600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Inter', sans-serif; background: #F4F6FB; color: #2D3E58; }

        /* ── Sidebar ─────────────────────────────────── */
        .sidebar {
            position: fixed; top: 0; left: 0; bottom: 0;
            width: 256px;
            background: linear-gradient(160deg, #0D1B35 60%, #12284F 100%);
            border-right: 3px solid transparent;
            border-image: linear-gradient(to bottom, #1A56B0 0%, #C0392B 100%) 1;
            display: flex; flex-direction: column;
            z-index: 50;
            transition: transform .3s ease;
        }
        .sidebar-logo {
            padding: 1.4rem 1.2rem;
            border-bottom: 1px solid rgba(255,255,255,.07);
            display: flex; align-items: center; gap: .75rem;
        }
        .logo-icon {
            width: 38px; height: 38px; flex-shrink: 0;
            background: linear-gradient(135deg, #1A56B0, #C0392B);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .logo-text .name { font-family: 'Playfair Display', serif; color: #fff; font-size: .95rem; font-weight: 700; line-height: 1.2; }
        .logo-text .sub { color: #8496B0; font-size: .6rem; letter-spacing: .1em; text-transform: uppercase; }

        .nav-body { flex: 1; overflow-y: auto; padding: .5rem 0; scrollbar-width: thin; scrollbar-color: rgba(255,255,255,.1) transparent; }
        .nav-section { font-size: .6rem; font-weight: 700; letter-spacing: .12em; text-transform: uppercase; color: #4E6080; padding: 1.1rem 1.2rem .35rem; }
        .nav-item {
            display: flex; align-items: center; gap: .65rem;
            padding: .55rem 1rem; margin: 1px .5rem;
            border-radius: 8px;
            color: rgba(255,255,255,.6); font-size: .82rem; font-weight: 500;
            text-decoration: none; transition: all .18s;
        }
        .nav-item svg { width: 15px; height: 15px; flex-shrink: 0; }
        .nav-item:hover { background: rgba(255,255,255,.07); color: #fff; }
        .nav-item.active {
            background: rgba(26,86,176,.3);
            color: #fff;
            border-left: 3px solid #1A56B0;
            padding-left: calc(1rem - 3px);
        }
        .sidebar-footer {
            padding: .9rem 1.2rem;
            border-top: 1px solid rgba(255,255,255,.07);
            color: rgba(255,255,255,.2); font-size: .6rem; text-align: center;
        }

        /* ── Main wrapper ──────────────────────────────── */
        .main-wrap { margin-left: 256px; min-height: 100vh; display: flex; flex-direction: column; }

        /* ── Topbar ────────────────────────────────────── */
        .topbar {
            position: sticky; top: 0; z-index: 40;
            height: 62px; background: #fff;
            border-bottom: 1px solid #E8EDF5;
            display: flex; align-items: center; justify-content: space-between;
            padding: 0 2rem;
        }
        .topbar-left { display: flex; align-items: center; gap: .75rem; }
        .page-title { font-family: 'Playfair Display', serif; font-size: 1.15rem; font-weight: 700; color: #0D1B35; }

        .user-btn {
            display: flex; align-items: center; gap: .6rem;
            background: none; border: none; cursor: pointer; padding: .3rem .5rem;
            border-radius: 10px; transition: background .15s;
        }
        .user-btn:hover { background: #F4F6FB; }
        .avatar {
            width: 34px; height: 34px;
            background: linear-gradient(135deg, #1A56B0, #0D3D8A);
            border-radius: 50%; display: flex; align-items: center; justify-content: center;
            color: #fff; font-weight: 700; font-size: .8rem; flex-shrink: 0;
        }
        .user-info .uname { font-size: .82rem; font-weight: 600; color: #2D3E58; text-align:left; }
        .user-info .uemail { font-size: .68rem; color: #8496B0; text-align:left; }

        /* Dropdown */
        .u-dropdown-menu {
            position: absolute; right: 1.5rem; top: 62px;
            background: #fff; border-radius: 14px;
            box-shadow: 0 8px 30px rgba(13,27,53,.15);
            border: 1px solid #E8EDF5;
            min-width: 190px; padding: .4rem;
            z-index: 100;
        }
        .u-drop-item {
            display: flex; align-items: center; gap: .5rem;
            padding: .5rem .75rem; border-radius: 8px;
            color: #2D3E58; font-size: .82rem; text-decoration: none;
            transition: background .15s; width: 100%;
            background: none; border: none; cursor: pointer; text-align: left;
        }
        .u-drop-item:hover { background: #F4F6FB; }
        .u-drop-item.danger { color: #C0392B; }
        .u-drop-divider { height: 1px; background: #E8EDF5; margin: .3rem 0; }

        /* ── Page content ──────────────────────────────── */
        .page-content { padding: 1.75rem 2rem; flex: 1; }

        /* Flash messages */
        .flash-ok {
            display: flex; align-items: center; gap: .5rem;
            background: rgba(39,174,96,.1); border: 1px solid rgba(39,174,96,.25);
            border-radius: 10px; padding: .7rem 1rem; margin-bottom: 1.25rem;
            color: #27AE60; font-size: .83rem;
        }
        .flash-err {
            display: flex; align-items: center; gap: .5rem;
            background: rgba(192,57,43,.1); border: 1px solid rgba(192,57,43,.25);
            border-radius: 10px; padding: .7rem 1rem; margin-bottom: 1.25rem;
            color: #C0392B; font-size: .83rem;
        }

        /* Mobile overlay */
        .sidebar-overlay {
            display: none; position: fixed; inset: 0; background: rgba(0,0,0,.4); z-index: 49;
        }
        @media (max-width: 900px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-wrap { margin-left: 0; }
            .sidebar-overlay.show { display: block; }
            .mob-toggle { display: flex !important; }
        }
        .mob-toggle {
            display: none; align-items: center; justify-content: center;
            background: none; border: none; cursor: pointer; color: #8496B0; padding: .25rem;
        }

        /* ── Utility ──────────────────────────────────── */
        .red-bar { height: 3px; width: 38px; background: linear-gradient(90deg,#C0392B,#E74C3C); border-radius:2px; }
    </style>
</head>
<body>
<div x-data="{ sidebar: false, usermenu: false }">

    <!-- Mobile overlay -->
    <div class="sidebar-overlay" :class="{ 'show': sidebar }" @click="sidebar=false"></div>

    <!-- ── SIDEBAR ───────────────────────────────────── -->
    <aside class="sidebar" :class="{ 'open': sidebar }">

        <div class="sidebar-logo">
            <div class="logo-icon">
                <svg width="20" height="20" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                    <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                </svg>
            </div>
            <div class="logo-text">
                <div class="name">Biblioteca UPGOP</div>
                <div class="sub">Sistema de Gestión</div>
            </div>
        </div>

        <nav class="nav-body">

            <div class="nav-section">Principal</div>
            <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                Dashboard
            </a>

            <div class="nav-section">Catálogo</div>
            <a href="{{ route('libros.index') }}" class="nav-item {{ request()->routeIs('libros.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/></svg>
                Libros
            </a>
            <a href="{{ route('carreras.index') }}" class="nav-item {{ request()->routeIs('carreras.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M22 10v6M2 10l10-5 10 5-10 5z"/><path d="M6 12v5c3 3 9 3 12 0v-5"/></svg>
                Carreras
            </a>

            <div class="nav-section">Alumnos</div>
            <a href="{{ route('alumnos.index') }}" class="nav-item {{ request()->routeIs('alumnos.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
                Alumnos
            </a>
            <a href="{{ route('deudores.index') }}" class="nav-item {{ request()->routeIs('deudores.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                Deudores y Rezagados
            </a>

            <div class="nav-section">Movimientos</div>
            <a href="{{ route('prestamos.index') }}" class="nav-item {{ request()->routeIs('prestamos.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="17 1 21 5 17 9"/><path d="M3 11V9a4 4 0 0 1 4-4h14"/><polyline points="7 23 3 19 7 15"/><path d="M21 13v2a4 4 0 0 1-4 4H3"/></svg>
                Préstamos
            </a>
            <a href="{{ route('donaciones.index') }}" class="nav-item {{ request()->routeIs('donaciones.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 0 0-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78z"/></svg>
                Donaciones
            </a>
            <a href="{{ route('adquisiciones.index') }}" class="nav-item {{ request()->routeIs('adquisiciones.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="16"/><line x1="8" y1="12" x2="16" y2="12"/></svg>
                Adquisiciones
            </a>
            <a href="{{ route('reposiciones.index') }}" class="nav-item {{ request()->routeIs('reposiciones.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="23 4 23 10 17 10"/><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"/></svg>
                Reposiciones
            </a>

            <div class="nav-section">Administración</div>
            <a href="{{ route('reportes.index') }}" class="nav-item {{ request()->routeIs('reportes.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
                Reportes PDF
            </a>
            <a href="{{ route('profile.edit') }}" class="nav-item {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                Mi Perfil
            </a>
        </nav>

        <div class="sidebar-footer">© {{ date('Y') }} Universidad Politécnica Gómez Palacio</div>
    </aside>

    <!-- ── MAIN ──────────────────────────────────────── -->
    <div class="main-wrap">

        <!-- Topbar -->
        <header class="topbar">
            <div class="topbar-left">
                <button class="mob-toggle" @click="sidebar=!sidebar">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
                </button>
                @isset($header)
                    <span class="page-title">{{ $header }}</span>
                @endisset
            </div>

            <div style="position:relative;">
                <button class="user-btn" @click="usermenu=!usermenu" @click.away="usermenu=false">
                    <div class="avatar">{{ strtoupper(substr(Auth::user()->name, 0, 2)) }}</div>
                    <div class="user-info">
                        <div class="uname">{{ Auth::user()->name }}</div>
                        <div class="uemail">{{ Auth::user()->email }}</div>
                    </div>
                    <svg width="13" height="13" fill="none" stroke="#8496B0" viewBox="0 0 24 24"><polyline points="6 9 12 15 18 9"/></svg>
                </button>

                <div class="u-dropdown-menu" x-show="usermenu" x-transition style="display:none;">
                    <a href="{{ route('profile.edit') }}" class="u-drop-item">
                        <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
                        Mi perfil
                    </a>
                    <div class="u-drop-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="u-drop-item danger">
                            <svg width="14" height="14" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                            Cerrar sesión
                        </button>
                    </form>
                </div>
            </div>
        </header>

        <!-- Content -->
        <main class="page-content">
            @if(session('success'))
            <div class="flash-ok">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><polyline points="20 6 9 17 4 12"/></svg>
                {{ session('success') }}
            </div>
            @endif
            @if(session('error'))
            <div class="flash-err">
                <svg width="15" height="15" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                {{ session('error') }}
            </div>
            @endif
            {{ $slot }}
        </main>
    </div>
</div>
</body>
</html>
