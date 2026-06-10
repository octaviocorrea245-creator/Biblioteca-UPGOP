<?php

namespace App\Http\Controllers;

use App\Models\Reposicion;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReposicionController extends Controller
{
    public function index()
    {
        $reposiciones = Reposicion::with(['alumno', 'libro', 'carrera'])->paginate(10);
        return view('reposiciones.index', compact('reposiciones'));
    }

    public function create()
    {
        // Solo préstamos activos o vencidos
        $prestamos = Prestamo::with(['alumno', 'libro', 'carrera'])
            ->whereIn('estado', ['Activo', 'Vencido'])
            ->get();
        return view('reposiciones.create', compact('prestamos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'prestamo_id'   => 'required|exists:prestamos,id',
            'tipo'          => 'required|in:Perdida,Daño',
            'monto'         => 'required|numeric|min:0',
            'fecha_reporte' => 'required|date',
            'observaciones' => 'nullable|string',
        ]);

        $prestamo = Prestamo::with(['alumno', 'libro', 'carrera'])->find($request->prestamo_id);

        Reposicion::create([
            'prestamo_id'   => $prestamo->id,
            'alumno_id'     => $prestamo->alumno_id,
            'libro_id'      => $prestamo->libro_id,
            'carrera_id'    => $prestamo->carrera_id,
            'tipo'          => $request->tipo,
            'monto'         => $request->monto,
            'estado_pago'   => 'Pendiente',
            'fecha_reporte' => $request->fecha_reporte,
            'observaciones' => $request->observaciones,
        ]);

        // Marcar préstamo como Vencido si estaba Activo
        if ($prestamo->estado === 'Activo') {
            $prestamo->update(['estado' => 'Vencido']);
        }

        return redirect()->route('reposiciones.index')->with('success', 'Reposición registrada correctamente.');
    }

    public function registrarPago(Reposicion $reposicion)
    {
        $reposicion->update([
            'estado_pago' => 'Pagado',
            'fecha_pago'  => now(),
        ]);

        // Si el alumno era Deudor o Rezagado, vuelve a Activo
        if (in_array($reposicion->alumno->estado, ['Deudor', 'Rezagado'])) {
            $reposicion->alumno->update(['estado' => 'Activo']);
        }

        return redirect()->route('reposiciones.index')->with('success', 'Pago registrado correctamente.');
    }

    public function comprobante(Reposicion $reposicion)
    {
        $pdf = Pdf::loadView('reposiciones.comprobante', compact('reposicion'));
        return $pdf->stream("comprobante_reposicion_{$reposicion->id}.pdf");
    }

    public function destroy(Reposicion $reposicion)
    {
        try {
            $reposicion->delete();
            return redirect()->route('reposiciones.index')->with('success', 'Reposición eliminada.');
        } catch (\Exception $e) {
            return redirect()->route('reposiciones.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}