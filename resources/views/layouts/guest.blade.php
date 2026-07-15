<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<<<<<<< HEAD
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100">
            <div>
                <a href="/">
                    <x-application-logo class="w-20 h-20 fill-current text-gray-500" />
                </a>
            </div>

            <div class="w-full sm:max-w-md mt-6 px-6 py-4 bg-white shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
=======
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
        body { font-family: 'Inter', sans-serif; height: 100vh; display: flex; overflow: hidden; }

        /* ── Panel izquierdo ─────────────────────────── */
        .panel-left {
            flex: 1.1;
            min-width: 360px;
            background: linear-gradient(160deg, #0D1B35 60%, #12284F 100%);
            border-left: 3px solid transparent;
            border-image: linear-gradient(to bottom, #1A56B0, #C0392B) 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 2.5rem 3rem;
            position: relative;
            overflow: hidden;
        }
        /* Círculos decorativos */
        .panel-left::before {
            content: '';
            position: absolute;
            top: -60px; right: -60px;
            width: 260px; height: 260px;
            border-radius: 50%;
            background: rgba(26,86,176,.08);
        }
        .panel-left::after {
            content: '';
            position: absolute;
            bottom: -80px; left: -40px;
            width: 200px; height: 200px;
            border-radius: 50%;
            background: rgba(192,57,43,.07);
        }
        .panel-top { position: relative; z-index: 1; }
        .brand { display: flex; align-items: center; gap: .75rem; }
        .brand-icon {
            width: 40px; height: 40px;
            background: linear-gradient(135deg, #1A56B0, #C0392B);
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
        }
        .brand-name { color: #fff; font-size: .95rem; font-weight: 700; font-family: 'Playfair Display', serif; line-height: 1.2; }
        .brand-sub { color: #8496B0; font-size: .6rem; letter-spacing: .1em; text-transform: uppercase; }

        .panel-center { position: relative; z-index: 1; }
        .eyebrow {
            display: inline-flex; align-items: center; gap: .4rem;
            color: #8496B0; font-size: .65rem; font-weight: 600;
            letter-spacing: .12em; text-transform: uppercase; margin-bottom: .9rem;
        }
        .eyebrow-line { width: 28px; height: 2px; background: linear-gradient(90deg,#C0392B,#E74C3C); border-radius:2px; }
        .panel-h1 {
            font-family: 'Playfair Display', serif;
            color: #fff;
            font-size: clamp(1.8rem, 3vw, 2.5rem);
            font-weight: 700; line-height: 1.25;
            margin-bottom: .5rem;
        }
        .panel-h1 span { color: #2E86DE; }
        .red-bar { height: 3px; width: 40px; background: linear-gradient(90deg,#C0392B,#E74C3C); border-radius:2px; margin: .8rem 0 1rem; }
        .panel-desc { color: rgba(255,255,255,.55); font-size: .83rem; line-height: 1.6; margin-bottom: 1.4rem; }
        .feature-list { list-style: none; display: flex; flex-direction: column; gap: .5rem; }
        .feature-list li { display: flex; align-items: center; gap: .6rem; color: rgba(255,255,255,.65); font-size: .8rem; }
        .feat-dot { width: 6px; height: 6px; border-radius: 50%; flex-shrink: 0; }
        .dot-blue { background: #1A56B0; }
        .dot-red  { background: #C0392B; }

        .panel-bottom { position: relative; z-index: 1; }
        .slogan { color: rgba(255,255,255,.3); font-size: .68rem; font-style: italic; margin-bottom: .25rem; }
        .domain { color: rgba(255,255,255,.2); font-size: .62rem; letter-spacing: .06em; }

        /* ── Panel derecho ───────────────────────────── */
        .panel-right {
            flex: 1;
            background: #F4F6FB;
            background-image: radial-gradient(#C5D0E0 1px, transparent 1px);
            background-size: 28px 28px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
        }
        .auth-card {
            background: #fff;
            border-radius: 20px;
            padding: 2.75rem;
            width: 100%;
            max-width: 440px;
            border-top: 3px solid transparent;
            border-image: linear-gradient(90deg, #1A56B0, #2E86DE, #C0392B) 1;
            box-shadow: 0 0 0 1px rgba(13,27,53,.04), 0 8px 32px rgba(13,27,53,.10), 0 1px 2px rgba(13,27,53,.05);
        }
        .card-eyebrow {
            color: #1A56B0; font-size: .65rem; font-weight: 700;
            letter-spacing: .12em; text-transform: uppercase; margin-bottom: .5rem;
        }
        .card-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.65rem; font-weight: 700; color: #0D1B35;
            margin-bottom: .25rem;
        }
        .card-sub { color: #8496B0; font-size: .8rem; margin-bottom: 1.75rem; }

        /* Inputs */
        .field { margin-bottom: 1.1rem; }
        .field label { display: block; font-size: .72rem; font-weight: 600; color: #2D3E58; letter-spacing: .04em; text-transform: uppercase; margin-bottom: .4rem; }
        .input-wrap { position: relative; }
        .input-wrap svg { position: absolute; left: .85rem; top: 50%; transform: translateY(-50%); width: 16px; height: 16px; color: #8496B0; pointer-events: none; }
        .input-wrap input {
            width: 100%;
            padding: .72rem 1rem .72rem 2.6rem;
            border: 1.5px solid #DDE3EE;
            border-radius: 10px;
            background: #F8FAFD;
            font-family: 'Inter', sans-serif;
            font-size: .9rem; color: #0D1B35;
            outline: none;
            transition: border-color .2s, background .2s, box-shadow .2s;
        }
        .input-wrap input:focus {
            border-color: #1A56B0;
            background: #fff;
            box-shadow: 0 0 0 3.5px rgba(26,86,176,.10);
        }
        .input-wrap input.error { border-color: #C0392B; }
        .field-error { display: flex; align-items: center; gap: .35rem; color: #C0392B; font-size: .72rem; margin-top: .35rem; }

        /* Checkbox row */
        .check-row { display: flex; align-items: center; justify-content: space-between; margin: .9rem 0 1.4rem; }
        .check-label { display: flex; align-items: center; gap: .45rem; font-size: .78rem; color: #2D3E58; cursor: pointer; }
        .check-label input[type=checkbox] { accent-color: #1A56B0; width: 15px; height: 15px; }
        .forgot-link { font-size: .75rem; color: #1A56B0; text-decoration: none; font-weight: 500; }
        .forgot-link:hover { text-decoration: underline; }

        /* CTA button */
        .btn-cta {
            width: 100%;
            padding: .85rem;
            background: linear-gradient(135deg, #1A56B0, #0D3D8A);
            color: #fff;
            border: none;
            border-radius: 10px;
            font-family: 'Inter', sans-serif;
            font-size: .9rem; font-weight: 600;
            letter-spacing: .04em;
            cursor: pointer;
            display: flex; align-items: center; justify-content: center; gap: .5rem;
            box-shadow: 0 4px 16px rgba(26,86,176,.30);
            transition: opacity .2s, transform .2s, box-shadow .2s;
        }
        .btn-cta:hover { opacity: .92; transform: translateY(-1.5px); box-shadow: 0 6px 24px rgba(26,86,176,.38); }

        .card-footer { text-align: center; margin-top: 1.25rem; color: #8496B0; font-size: .72rem; }
        .card-footer a { color: #1A56B0; font-weight: 600; text-decoration: none; }
        .card-footer a:hover { text-decoration: underline; }
        .card-note { text-align: center; margin-top: 1rem; color: #B0BCCC; font-size: .68rem; }

        @media (max-width: 768px) {
            body { flex-direction: column; height: auto; overflow: auto; }
            .panel-left { display: none; }
            .panel-right { min-height: 100vh; }
        }
    </style>
</head>
<body>

    <!-- Panel izquierdo — Branding -->
    <div class="panel-left">
        <div class="panel-top">
            <div class="brand">
                <div class="brand-icon">
                    <svg width="22" height="22" fill="none" stroke="#fff" stroke-width="2" viewBox="0 0 24 24">
                        <path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"/><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"/>
                    </svg>
                </div>
                <div>
                    <div class="brand-name">Biblioteca UPGOP</div>
                    <div class="brand-sub">Universidad Politécnica Gómez Palacio</div>
                </div>
            </div>
        </div>

        <div class="panel-center">
            <div class="eyebrow">
                <span class="eyebrow-line"></span>
                Acceso institucional
            </div>
            <h1 class="panel-h1">Bienvenido al<br>portal <span>bibliotecario</span></h1>
            <div class="red-bar"></div>
            <p class="panel-desc">Plataforma de gestión del acervo bibliográfico para la comunidad universitaria de la UPGOP.</p>
            <ul class="feature-list">
                <li><span class="feat-dot dot-blue"></span>Consulta y préstamo de libros</li>
                <li><span class="feat-dot dot-red"></span>Control de alumnos y deudores</li>
                <li><span class="feat-dot dot-blue"></span>Donaciones y adquisiciones</li>
                <li><span class="feat-dot dot-red"></span>Reportes PDF institucionales</li>
            </ul>
        </div>

        <div class="panel-bottom">
            <div class="slogan">Liderazgo e Innovación con Espíritu Humano</div>
            <div class="domain">upgop.edu.mx</div>
        </div>
    </div>

    <!-- Panel derecho — Formulario -->
    <div class="panel-right">
        <div class="auth-card">
            {{ $slot }}
        </div>
    </div>

</body>
>>>>>>> e457021ea82fbed4256465eab0b8d4a95f667977
</html>
