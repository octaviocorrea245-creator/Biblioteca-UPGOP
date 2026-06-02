<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; text-align: center; }
        h2 { font-size: 13px; color: #555; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #b45309; color: white; padding: 6px; text-align: left; }
        td { padding: 5px; border-bottom: 1px solid #ddd; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>Universidad Politécnica de Gómez Palacio</h1>
    <h2>Lista de Deudores Activos</h2>

    <table>
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Nombre</th>
                <th>Carrera</th>
                <th>Préstamos vencidos</th>
            </tr>
        </thead>
        <tbody>
            @forelse($deudores as $alumno)
            <tr>
                <td>{{ $alumno->matricula }}</td>
                <td>{{ $alumno->nombre }}</td>
                <td>{{ $alumno->carrera->nombre }}</td>
                <td>{{ $alumno->prestamos->count() }}</td>
            </tr>
            @empty
            <tr><td colspan="4" style="text-align:center">Sin deudores activos.</td></tr>
            @endforelse
        </tbody>
    </table>
    <p class="footer">Total: {{ $deudores->count() }} deudores · Generado el {{ now()->format('d/m/Y H:i') }}</p>
</body>
</html>