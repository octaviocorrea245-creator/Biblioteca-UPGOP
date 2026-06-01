<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 40px; }
        .header { text-align: center; margin-bottom: 20px; }
        h1 { font-size: 16px; margin: 0; }
        h2 { font-size: 13px; color: #555; margin: 4px 0; }
        .folio { font-size: 22px; font-weight: bold; text-align: center; margin: 16px 0; border: 2px solid #000; padding: 8px; }
        .grid { width: 100%; margin-top: 16px; }
        .grid td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
        .label { font-weight: bold; width: 40%; }
        .firmas { margin-top: 60px; display: flex; justify-content: space-between; }
        .firma { text-align: center; width: 40%; border-top: 1px solid #000; padding-top: 6px; }
        .footer { margin-top: 30px; font-size: 10px; color: #999; text-align: center; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Universidad Politécnica de Gómez Palacio</h1>
        <h2>Departamento de Biblioteca</h2>
        <h2>Vale de Préstamo</h2>
    </div>

    <div class="folio">Folio #{{ $prestamo->folio }} — {{ $prestamo->carrera->nombre }}</div>

    <table class="grid">
        <tr>
            <td class="label">Alumno:</td>
            <td>{{ $prestamo->alumno->nombre }}</td>
        </tr>
        <tr>
            <td class="label">Matrícula:</td>
            <td>{{ $prestamo->alumno->matricula }}</td>
        </tr>
        <tr>
            <td class="label">Carrera:</td>
            <td>{{ $prestamo->carrera->nombre }}</td>
        </tr>
        <tr>
            <td class="label">Cuatrimestre:</td>
            <td>{{ $prestamo->cuatrimestre }}</td>
        </tr>
        <tr>
            <td class="label">Libro prestado:</td>
            <td>{{ $prestamo->libro->titulo }}</td>
        </tr>
        <tr>
            <td class="label">Código del libro:</td>
            <td>{{ $prestamo->libro->codigo }}</td>
        </tr>
        <tr>
            <td class="label">Fecha de préstamo:</td>
            <td>{{ $prestamo->fecha_prestamo->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Fecha límite de devolución:</td>
            <td>{{ $prestamo->fecha_devolucion_esperada->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Estado:</td>
            <td>{{ $prestamo->estado }}</td>
        </tr>
        @if($prestamo->observaciones)
        <tr>
            <td class="label">Observaciones:</td>
            <td>{{ $prestamo->observaciones }}</td>
        </tr>
        @endif
    </table>

    <div class="firmas">
        <div class="firma">Firma del Alumno</div>
        <div class="firma">Encargado de Biblioteca</div>
    </div>

    <p class="footer">Generado el {{ now()->format('d/m/Y H:i') }} · UPGP Biblioteca</p>
</body>
</html>