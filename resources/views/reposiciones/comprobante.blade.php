<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 40px; }
        .header { text-align: center; margin-bottom: 20px; }
        h1 { font-size: 16px; margin: 0; }
        h2 { font-size: 13px; color: #555; margin: 4px 0; }
        .folio { font-size: 18px; font-weight: bold; text-align: center; margin: 16px 0; border: 2px solid #000; padding: 8px; }
        .grid { width: 100%; margin-top: 16px; }
        .grid td { padding: 6px 8px; border-bottom: 1px solid #ddd; }
        .label { font-weight: bold; width: 45%; }
        .badge { padding: 3px 8px; border-radius: 4px; font-size: 11px; }
        .badge-pendiente { background: #fed7aa; color: #c2410c; }
        .badge-pagado { background: #bbf7d0; color: #15803d; }
        .firmas { margin-top: 60px; width: 100%; }
        .firma-izq { width: 40%; border-top: 1px solid #000; padding-top: 6px; text-align: center; float: left; }
        .firma-der { width: 40%; border-top: 1px solid #000; padding-top: 6px; text-align: center; float: right; }
        .firma { text-align: center; width: 40%; border-top: 1px solid #000; padding-top: 6px; }
        .footer { margin-top: 30px; font-size: 10px; color: #999; text-align: center; }
        .monto { font-size: 20px; font-weight: bold; text-align: center; margin: 16px 0; color: #dc2626; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Universidad Politécnica de Gómez Palacio</h1>
        <h2>Departamento de Biblioteca</h2>
        <h2>Comprobante de Reposición</h2>
    </div>

    <div class="folio">
        {{ $reposicion->tipo === 'Perdida' ? 'PÉRDIDA DE LIBRO' : 'DAÑO DE LIBRO' }}
    </div>

    <div class="monto">
        Monto: ${{ number_format($reposicion->monto, 2) }} MXN
    </div>

    <table class="grid">
        <tr>
            <td class="label">Alumno:</td>
            <td>{{ $reposicion->alumno->nombre }}</td>
        </tr>
        <tr>
            <td class="label">Matrícula:</td>
            <td>{{ $reposicion->alumno->matricula }}</td>
        </tr>
        <tr>
            <td class="label">Carrera:</td>
            <td>{{ $reposicion->carrera->nombre }}</td>
        </tr>
        <tr>
            <td class="label">Libro:</td>
            <td>{{ $reposicion->libro->titulo }}</td>
        </tr>
        <tr>
            <td class="label">Código del libro:</td>
            <td>{{ $reposicion->libro->codigo }}</td>
        </tr>
        <tr>
            <td class="label">Tipo de reposición:</td>
            <td>{{ $reposicion->tipo === 'Perdida' ? 'Pérdida' : 'Daño' }}</td>
        </tr>
        <tr>
            <td class="label">Fecha de reporte:</td>
            <td>{{ $reposicion->fecha_reporte->format('d/m/Y') }}</td>
        </tr>
        <tr>
            <td class="label">Estado de pago:</td>
            <td>
                <span class="badge {{ $reposicion->estado_pago === 'Pendiente' ? 'badge-pendiente' : 'badge-pagado' }}">
                    {{ $reposicion->estado_pago }}
                </span>
            </td>
        </tr>
        @if($reposicion->fecha_pago)
        <tr>
            <td class="label">Fecha de pago:</td>
            <td>{{ $reposicion->fecha_pago->format('d/m/Y') }}</td>
        </tr>
        @endif
        @if($reposicion->observaciones)
        <tr>
            <td class="label">Observaciones:</td>
            <td>{{ $reposicion->observaciones }}</td>
        </tr>
        @endif
        <tr>
            <td class="label">Folio del préstamo original:</td>
            <td>#{{ $reposicion->prestamo->folio }}</td>
        </tr>
    </table>

    <div class="firmas">
        <div class="firma-izq">Firma del Alumno</div>
        <div class="firma-der">Encargado de Biblioteca</div>
    </div>

    <p class="footer">Generado el {{ now()->format('d/m/Y H:i') }} · UPGP Biblioteca</p>
</body>
</html>