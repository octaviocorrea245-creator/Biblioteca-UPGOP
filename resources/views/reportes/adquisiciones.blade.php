<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; text-align: center; }
        h2 { font-size: 13px; color: #555; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #1e3a5f; color: white; padding: 6px; text-align: left; }
        td { padding: 5px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>Universidad Politécnica de Gómez Palacio</h1>
    <h2>Reporte de Adquisiciones</h2>
    @if($carrera) <h2>Carrera: {{ $carrera->nombre }}</h2> @endif

    <table>
        <thead>
            <tr>
                <th>Título</th>
                <th>Autor</th>
                <th>Carrera</th>
                <th>Cantidad</th>
                <th>Proveedor</th>
                <th>Factura</th>
                <th>Fecha</th>
                <th>Costo</th>
            </tr>
        </thead>
        <tbody>
            @forelse($adquisiciones as $a)
            <tr>
                <td>{{ $a->titulo }}</td>
                <td>{{ $a->autor }}</td>
                <td>{{ $a->carrera->nombre }}</td>
                <td>{{ $a->cantidad }}</td>
                <td>{{ $a->proveedor }}</td>
                <td>{{ $a->factura }}</td>
                <td>{{ $a->fecha_factura->format('d/m/Y') }}</td>
                <td>${{ number_format($a->costo, 2) }}</td>
            </tr>
            @empty
            <tr><td colspan="8" style="text-align:center">Sin adquisiciones.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p class="footer">Total: {{ $adquisiciones->count() }} adquisiciones · Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>