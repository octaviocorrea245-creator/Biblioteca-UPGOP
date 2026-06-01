<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        h1 { font-size: 16px; text-align: center; }
        h2 { font-size: 13px; color: #555; text-align: center; }
        table { width: 100%; border-collapse: collapse; margin-top: 16px; }
        th { background: #1e40af; color: white; padding: 6px; text-align: left; }
        td { padding: 5px; border-bottom: 1px solid #ddd; }
        .seccion { margin-top: 24px; }
        .footer { margin-top: 20px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <h1>Universidad Politécnica de Gómez Palacio</h1>
    <h2>Reporte Cuatrimestral — {{ $request->cuatrimestre }}</h2>
    @if($carrera) <h2>Carrera: {{ $carrera->nombre }}</h2> @endif

    <div class="seccion">
        <h3>Préstamos del cuatrimestre</h3>
        <table>
            <thead>
                <tr>
                    <th>Folio</th>
                    <th>Alumno</th>
                    <th>Libro</th>
                    <th>Carrera</th>
                    <th>F. Préstamo</th>
                    <th>F. Devolución</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($prestamos as $p)
                <tr>
                    <td>#{{ $p->folio }}</td>
                    <td>{{ $p->alumno->nombre }}</td>
                    <td>{{ $p->libro->titulo }}</td>
                    <td>{{ $p->carrera->nombre }}</td>
                    <td>{{ $p->fecha_prestamo->format('d/m/Y') }}</td>
                    <td>{{ $p->fecha_devolucion_real ? $p->fecha_devolucion_real->format('d/m/Y') : 'Pendiente' }}</td>
                    <td>{{ $p->estado }}</td>
                </tr>
                @empty
                <tr><td colspan="7" style="text-align:center">Sin préstamos en este cuatrimestre.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="seccion">
        <h3>Deudores del cuatrimestre</h3>
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
                <tr><td colspan="4" style="text-align:center">Sin deudores.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <p class="footer">
        Total préstamos: {{ $prestamos->count() }} · 
        Total deudores: {{ $deudores->count() }} · 
        Generado el {{ now()->format('d/m/Y H:i') }}
    </p>
</body>
</html>