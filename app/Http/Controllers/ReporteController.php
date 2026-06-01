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

        $pdf = Pdf::loadView('reportes.prestamos_mensual', compact('prestamos', 'carrera', 'request'));
        return $pdf->download("reporte_prestamos_{$request->anio}_{$request->mes}.pdf");
    }

    // Reporte cuatrimestral
    public function prestamoscuatrimestrales(Request $request)
    {
        $request->validate([
            'cuatrimestre' => 'required|string',
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

        $pdf = Pdf::loadView('reportes.prestamos_cuatrimestral', compact('prestamos', 'deudores', 'carrera', 'request'));
        return $pdf->download("reporte_cuatrimestral_{$request->cuatrimestre}.pdf");
    }

    // Reporte de deudores
    public function deudores()
    {
        $deudores = Alumno::where('estado', 'Deudor')->with(['carrera', 'prestamos'])->get();
        $pdf = Pdf::loadView('reportes.deudores', compact('deudores'));
        return $pdf->download('reporte_deudores.pdf');
    }

    // Reporte de rezagados
    public function rezagados()
    {
        $rezagados = Alumno::where('estado', 'Rezagado')->with(['carrera', 'prestamos'])->get();
        $pdf = Pdf::loadView('reportes.rezagados', compact('rezagados'));
        return $pdf->download('reporte_rezagados.pdf');
    }

    // Reporte de donaciones
    public function donaciones(Request $request)
    {
        $request->validate([
            'carrera_id'   => 'nullable|exists:carreras,id',
            'cuatrimestre' => 'nullable|string',
        ]);

        $query = Donacion::with('carrera');

        if ($request->carrera_id) {
            $query->where('carrera_id', $request->carrera_id);
        }
        if ($request->cuatrimestre) {
            $query->where('cuatrimestre', $request->cuatrimestre);
        }

        $donaciones = $query->get();
        $carrera    = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        $pdf = Pdf::loadView('reportes.donaciones', compact('donaciones', 'carrera', 'request'));
        return $pdf->download('reporte_donaciones.pdf');
    }

    // Reporte de adquisiciones
    public function adquisiciones(Request $request)
    {
        $request->validate([
            'carrera_id' => 'nullable|exists:carreras,id',
            'proveedor'  => 'nullable|string',
        ]);

        $query = Adquisicion::with('carrera');

        if ($request->carrera_id) {
            $query->where('carrera_id', $request->carrera_id);
        }
        if ($request->proveedor) {
            $query->where('proveedor', 'like', "%{$request->proveedor}%");
        }

        $adquisiciones = $query->get();
        $carrera       = $request->carrera_id ? Carrera::find($request->carrera_id) : null;

        $pdf = Pdf::loadView('reportes.adquisiciones', compact('adquisiciones', 'carrera', 'request'));
        return $pdf->download('reporte_adquisiciones.pdf');
    }
}