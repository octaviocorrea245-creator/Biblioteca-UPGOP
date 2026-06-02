<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; text-align: center; }
        h2 { font-size: 13px; color: #555; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #065f46; color: white; padding: 6px; text-align: left; }
        td { padding: 5px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>Universidad Politécnica de Gómez Palacio</h1>
    <h2>Reporte de Donaciones</h2>
    @if($carrera) <h2>Carrera: {{ $carrera->nombre }}</h2> @endif

    <table>
        <thead>
            <tr>
                <th>Código</th>
                <th>Título</th>
                <th>Autor</th>
                <th>Donante</th>
                <th>Matrícula</th>
                <th>Carrera</th>
                <th>Fecha</th>
            </tr>
        </thead>
        <tbody>
            @forelse($donaciones as $d)
            <tr>
                <td>{{ $d->codigo_donacion }}</td>
                <td>{{ $d->titulo }}</td>
                <td>{{ $d->autor }}</td>
                <td>{{ $d->alumno_donante }}</td>
                <td>{{ $d->matricula_donante }}</td>
                <td>{{ $d->carrera->nombre }}</td>
                <td>{{ $d->fecha->format('d/m/Y') }}</td>
            </tr>
            @empty
            <tr><td colspan="7" style="text-align:center">Sin donaciones.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p class="footer">Total: {{ $donaciones->count() }} donaciones · Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>