<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Alumno;
use App\Models\Donacion;
use App\Models\Adquisicion;
use App\Models\Carrera;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReporteController extends Controller
{
    public function index()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('reportes.index', compact('carreras'));
    }

    // Reporte mensual de préstamos
    public function prestamensuales(Request $request)
    {
        $request->validate([
            'mes'       => 'required|integer|min:1|max:12',
            'anio'      => 'required|digits:4',
            'carrera_id'=> 'nullable|exists:carreras,id',
        ]);

        $query = Prestamo::with(['alumno', 'libro', 'carrera'])
            ->whereMonth('fecha_prestamo', $request->mes)
            ->whereYear('fecha_prestamo', $request->anio);

        if ($request->carrera_id) {
            $query->where('carrera_id', $request->carrera_id);
        }

        $prestamos = $query->get();
        $carrera   = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        if ($request->query('format') === 'xml') {
            $items = $prestamos->map(function ($prestamo) {
                return [
                    'id'               => $prestamo->id,
                    'folio'            => $prestamo->folio,
                    'alumno_nombre'    => $prestamo->alumno->nombre,
                    'alumno_matricula' => $prestamo->alumno->matricula,
                    'libro_titulo'     => $prestamo->libro->titulo,
                    'libro_codigo'     => $prestamo->libro->codigo,
                    'carrera'          => $prestamo->carrera->nombre,
                    'fecha_prestamo'   => $prestamo->fecha_prestamo?->toDateString(),
                    'fecha_devolucion' => $prestamo->fecha_devolucion?->toDateString(),
                    'estado'           => $prestamo->estado,
                ];
            })->toArray();

            $xml = new \SimpleXMLElement('<prestamos/>');
            $xml->addChild('anio', $request->anio);
            $xml->addChild('mes', $request->mes);
            foreach ($items as $item) {
                $line = $xml->addChild('prestamo');
                foreach ($item as $key => $value) {
                    $line->addChild($key, htmlspecialchars((string) $value));
                }
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => "attachment; filename=reporte_prestamos_{$request->anio}_{$request->mes}.xml",
            ]);
        }

        $pdf = Pdf::loadView('reportes.prestamos_mensual', compact('prestamos', 'carrera', 'request'));
        return $pdf->download("reporte_prestamos_{$request->anio}_{$request->mes}.pdf");
    }

    // Reporte cuatrimestral
    public function prestamoscuatrimestrales(Request $request)
    {
        $request->validate([
            'cuatrimestre' => 'required|string|max:20|regex:/^[A-Za-z0-9\-]+$/',    
            'carrera_id'   => 'nullable|exists:carreras,id',
        ]);

        $query = Prestamo::with(['alumno', 'libro', 'carrera'])
            ->where('cuatrimestre', $request->cuatrimestre);

        if ($request->carrera_id) {
            $query->where('carrera_id', $request->carrera_id);
        }

        $prestamos = $query->get();
        $deudores  = Alumno::where('estado', 'Deudor')->with('carrera')->get();
        $carrera   = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        if ($request->query('format') === 'xml') {
            $items = $prestamos->map(function ($prestamo) {
                return [
                    'id'               => $prestamo->id,
                    'folio'            => $prestamo->folio,
                    'alumno_nombre'    => $prestamo->alumno->nombre,
                    'alumno_matricula' => $prestamo->alumno->matricula,
                    'libro_titulo'     => $prestamo->libro->titulo,
                    'libro_codigo'     => $prestamo->libro->codigo,
                    'carrera'          => $prestamo->carrera->nombre,
                    'fecha_prestamo'   => $prestamo->fecha_prestamo?->toDateString(),
                    'fecha_devolucion' => $prestamo->fecha_devolucion?->toDateString(),
                    'estado'           => $prestamo->estado,
                ];
            })->toArray();

            $xml = new \SimpleXMLElement('<prestamos_cuatrimestrales/>');
            $xml->addChild('cuatrimestre', $request->cuatrimestre);
            foreach ($items as $item) {
                $line = $xml->addChild('prestamo');
                foreach ($item as $key => $value) {
                    $line->addChild($key, htmlspecialchars((string) $value));
                }
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => "attachment; filename=reporte_cuatrimestral_{$request->cuatrimestre}.xml",
            ]);
        }

        $pdf = Pdf::loadView('reportes.prestamos_cuatrimestral', compact('prestamos', 'deudores', 'carrera', 'request'));
        return $pdf->download("reporte_cuatrimestral_{$request->cuatrimestre}.pdf");
    }

    // Reporte de deudores
    public function deudores(Request $request)
    {
        $deudores = Alumno::where('estado', 'Deudor')->with(['carrera', 'prestamos'])->get();

        if ($request->query('format') === 'xml') {
            $xml = new \SimpleXMLElement('<deudores/>');
            foreach ($deudores as $alumno) {
                $node = $xml->addChild('alumno');
                $node->addChild('id', $alumno->id);
                $node->addChild('nombre', htmlspecialchars($alumno->nombre));
                $node->addChild('matricula', htmlspecialchars($alumno->matricula));
                $node->addChild('carrera', htmlspecialchars($alumno->carrera?->nombre ?? ''));
                $node->addChild('estado', $alumno->estado);
                $node->addChild('total_prestamos', $alumno->prestamos->count());
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename=reporte_deudores.xml',
            ]);
        }

        $pdf = Pdf::loadView('reportes.deudores', compact('deudores'));
        return $pdf->download('reporte_deudores.pdf');
    }

    // Reporte de rezagados
    public function rezagados(Request $request)
    {
        $rezagados = Alumno::where('estado', 'Rezagado')->with(['carrera', 'prestamos'])->get();

        if ($request->query('format') === 'xml') {
            $xml = new \SimpleXMLElement('<rezagados/>');
            foreach ($rezagados as $alumno) {
                $node = $xml->addChild('alumno');
                $node->addChild('id', $alumno->id);
                $node->addChild('nombre', htmlspecialchars($alumno->nombre));
                $node->addChild('matricula', htmlspecialchars($alumno->matricula));
                $node->addChild('carrera', htmlspecialchars($alumno->carrera?->nombre ?? ''));
                $node->addChild('estado', $alumno->estado);
                $node->addChild('total_prestamos', $alumno->prestamos->count());
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename=reporte_rezagados.xml',
            ]);
        }

        $pdf = Pdf::loadView('reportes.rezagados', compact('rezagados'));
        return $pdf->download('reporte_rezagados.pdf');
    }

    // Reporte de donaciones
    public function donaciones(Request $request)
    {
        $validated = $request->validate([
            'carrera_id'   => 'nullable|exists:carreras,id',
            'cuatrimestre' => 'nullable|string|max:20',
        ]);

        $query = Donacion::with('carrera');

        if (!empty($validated['carrera_id'])) {
            $query->where('carrera_id', $validated['carrera_id']);
        }
        if (!empty($validated['cuatrimestre'])) {
            $query->where('cuatrimestre', $validated['cuatrimestre']);
        }

        $donaciones = $query->get();
        $carrera    = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        if ($request->query('format') === 'xml') {
            $xml = new \SimpleXMLElement('<donaciones/>');
            foreach ($donaciones as $donacion) {
                $node = $xml->addChild('donacion');
                $node->addChild('id', $donacion->id);
                $node->addChild('codigo_donacion', htmlspecialchars($donacion->codigo_donacion));
                $node->addChild('titulo', htmlspecialchars($donacion->titulo));
                $node->addChild('autor', htmlspecialchars($donacion->autor));
                $node->addChild('editorial', htmlspecialchars($donacion->editorial));
                $node->addChild('codigo_barras', htmlspecialchars($donacion->codigo_barras));
                $node->addChild('costo', $donacion->costo);
                $node->addChild('fecha', $donacion->fecha?->toDateString());
                $node->addChild('alumno_donante', htmlspecialchars($donacion->alumno_donante));
                $node->addChild('matricula_donante', htmlspecialchars($donacion->matricula_donante));
                $node->addChild('carrera', htmlspecialchars($donacion->carrera?->nombre ?? ''));
                $node->addChild('cuatrimestre', htmlspecialchars($donacion->cuatrimestre));
                $node->addChild('generacion', htmlspecialchars($donacion->generacion));
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename=reporte_donaciones.xml',
            ]);
        }

        $pdf = Pdf::loadView('reportes.donaciones', compact('donaciones', 'carrera', 'request'));
        return $pdf->download('reporte_donaciones.pdf');
    }

    // Reporte de adquisiciones
    public function adquisiciones(Request $request)
    {
        $validated = $request->validate([
            'carrera_id' => 'nullable|exists:carreras,id',
            'proveedor'  => 'nullable|string|max:255',
        ]);

        $query = Adquisicion::with('carrera');

        if (!empty($validated['carrera_id'])) {
            $query->where('carrera_id', $validated['carrera_id']);
        }
        if (!empty($validated['proveedor'])) {
            $query->where('proveedor', 'like', "%{$validated['proveedor']}%");
        }


        $adquisiciones = $query->get();
        $carrera       = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        if ($request->query('format') === 'xml') {
            $xml = new \SimpleXMLElement('<adquisiciones/>');
            foreach ($adquisiciones as $item) {
                $node = $xml->addChild('adquisicion');
                $node->addChild('id', $item->id);
                $node->addChild('codigo', htmlspecialchars($item->codigo));
                $node->addChild('titulo', htmlspecialchars($item->titulo));
                $node->addChild('autor', htmlspecialchars($item->autor));
                $node->addChild('editorial', htmlspecialchars($item->editorial));
                $node->addChild('costo', $item->costo);
                $node->addChild('fecha', $item->fecha?->toDateString());
                $node->addChild('proveedor', htmlspecialchars($item->proveedor));
                $node->addChild('carrera', htmlspecialchars($item->carrera?->nombre ?? ''));
            }

            return response($xml->asXML(), 200, [
                'Content-Type' => 'application/xml',
                'Content-Disposition' => 'attachment; filename=reporte_adquisiciones.xml',
            ]);
        }

        $pdf = Pdf::loadView('reportes.adquisiciones', compact('adquisiciones', 'carrera', 'request'));
        return $pdf->download('reporte_adquisiciones.pdf');
    }
    // Exportar préstamos mensuales a Excel
public function prestamosMensualesExcel(Request $request)
{
    $request->validate([
        'mes'        => 'required|integer|min:1|max:12',
        'anio'       => 'required|digits:4',
        'carrera_id' => 'nullable|exists:carreras,id',
    ]);

    $query = Prestamo::with(['alumno', 'libro', 'carrera'])
        ->whereMonth('fecha_prestamo', $request->mes)
        ->whereYear('fecha_prestamo', $request->anio);

    if ($request->carrera_id) {
        $query->where('carrera_id', $request->carrera_id);
    }

    $prestamos = $query->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $hoja = $spreadsheet->getActiveSheet();
    $hoja->setTitle('Préstamos Mensuales');

    $hoja->fromArray(['Folio', 'Alumno', 'Matrícula', 'Libro', 'Carrera', 'F. Préstamo', 'F. Esperada', 'Estado'], null, 'A1');

    $fila = 2;
    foreach ($prestamos as $p) {
        $hoja->fromArray([
            $p->folio,
            $p->alumno->nombre,
            $p->alumno->matricula,
            $p->libro->titulo,
            $p->carrera->nombre,
            $p->fecha_prestamo->format('d/m/Y'),
            $p->fecha_devolucion_esperada->format('d/m/Y'),
            $p->estado,
        ], null, "A{$fila}");
        $fila++;
    }

    foreach (range('A', 'H') as $col) {
        $hoja->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $nombreArchivo = "prestamos_mensuales_{$request->anio}_{$request->mes}.xlsx";
    $ruta = storage_path("app/{$nombreArchivo}");
    $writer->save($ruta);

    return response()->download($ruta)->deleteFileAfterSend(true);
}

// Exportar deudores a Excel
public function deudoresExcel()
{
    $deudores = Alumno::where('estado', 'Deudor')->with(['carrera', 'prestamos'])->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $hoja = $spreadsheet->getActiveSheet();
    $hoja->setTitle('Deudores');

    $hoja->fromArray(['Matrícula', 'Nombre', 'Carrera', 'Préstamos vencidos'], null, 'A1');

    $fila = 2;
    foreach ($deudores as $alumno) {
        $hoja->fromArray([
            $alumno->matricula,
            $alumno->nombre,
            $alumno->carrera->nombre,
            $alumno->prestamos->count(),
        ], null, "A{$fila}");
        $fila++;
    }

    foreach (range('A', 'D') as $col) {
        $hoja->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $ruta = storage_path("app/deudores.xlsx");
    $writer->save($ruta);

    return response()->download($ruta)->deleteFileAfterSend(true);
}

// Exportar rezagados a Excel
public function rezagadosExcel()
{
    $rezagados = Alumno::where('estado', 'Rezagado')->with(['carrera', 'prestamos'])->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $hoja = $spreadsheet->getActiveSheet();
    $hoja->setTitle('Rezagados');

    $hoja->fromArray(['Matrícula', 'Nombre', 'Carrera', 'Préstamos vencidos'], null, 'A1');

    $fila = 2;
    foreach ($rezagados as $alumno) {
        $hoja->fromArray([
            $alumno->matricula,
            $alumno->nombre,
            $alumno->carrera->nombre,
            $alumno->prestamos->count(),
        ], null, "A{$fila}");
        $fila++;
    }

    foreach (range('A', 'D') as $col) {
        $hoja->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $ruta = storage_path("app/rezagados.xlsx");
    $writer->save($ruta);

    return response()->download($ruta)->deleteFileAfterSend(true);
}

// Exportar donaciones a Excel
public function donacionesExcel(Request $request)
{
    $query = Donacion::with('carrera');

    if ($request->carrera_id) {
        $query->where('carrera_id', $request->carrera_id);
    }
    if ($request->cuatrimestre) {
        $query->where('cuatrimestre', $request->cuatrimestre);
    }

    $donaciones = $query->get();

    $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
    $hoja = $spreadsheet->getActiveSheet();
    $hoja->setTitle('Donaciones');

    $hoja->fromArray(['Código', 'Título', 'Autor', 'Donante', 'Matrícula', 'Carrera', 'Fecha', 'Costo'], null, 'A1');

    $fila = 2;
    foreach ($donaciones as $d) {
        $hoja->fromArray([
            $d->codigo_donacion,
            $d->titulo,
            $d->autor,
            $d->alumno_donante,
            $d->matricula_donante,
            $d->carrera->nombre,
            $d->fecha->format('d/m/Y'),
            $d->costo,
        ], null, "A{$fila}");
        $fila++;
    }

    foreach (range('A', 'H') as $col) {
        $hoja->getColumnDimension($col)->setAutoSize(true);
    }

    $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
    $ruta = storage_path("app/donaciones.xlsx");
    $writer->save($ruta);

    return response()->download($ruta)->deleteFileAfterSend(true);
}

// Exportar adquisiciones a Excel
    public function adquisicionesExcel(Request $request)
    {
            $query = Adquisicion::with('carrera');

            if ($request->carrera_id) {
                $query->where('carrera_id', $request->carrera_id);
            }
            if ($request->proveedor) {
                $query->where('proveedor', 'like', "%{$request->proveedor}%");
            }

            $adquisiciones = $query->get();

            $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $hoja = $spreadsheet->getActiveSheet();
            $hoja->setTitle('Adquisiciones');

            $hoja->fromArray(['Título', 'Autor', 'Carrera', 'Cantidad', 'Proveedor', 'Factura', 'Fecha', 'Costo'], null, 'A1');

            $fila = 2;
            foreach ($adquisiciones as $a) {
                $hoja->fromArray([
                    $a->titulo,
                    $a->autor,
                    $a->carrera->nombre,
                    $a->cantidad,
                    $a->proveedor,
                    $a->factura,
                    $a->fecha_factura->format('d/m/Y'),
                    $a->costo,
                ], null, "A{$fila}");
                $fila++;
            }

            foreach (range('A', 'H') as $col) {
                $hoja->getColumnDimension($col)->setAutoSize(true);
            }

            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
            $ruta = storage_path("app/adquisiciones.xlsx");
            $writer->save($ruta);

            return response()->download($ruta)->deleteFileAfterSend(true);
    }
}