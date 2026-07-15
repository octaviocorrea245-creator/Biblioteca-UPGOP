<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Alumno;
use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Http\Requests\StorePrestamoRequest;


class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with(['alumno', 'libro', 'carrera'])->paginate(10);
        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $alumnos  = Alumno::activos()->get();
        $libros   = Libro::disponibles()->get();
        $carreras = Carrera::where('activa', true)->get();
        return view('prestamos.create', compact('alumnos', 'libros', 'carreras'));
    }

   public function store(StorePrestamoRequest $request)
    {
        $validated = $request->validated();

        $alumno = Alumno::find($validated['alumno_id']);
        if (strtolower(trim($alumno->estado)) === 'rezagado') {
            return back()->withErrors(['alumno_id' => 'Este alumno está rezagado y no puede realizar préstamos.'])->withInput();
        }

        $folio = Prestamo::siguienteFolio($validated['carrera_id']);
        Prestamo::create(array_merge($validated, ['folio' => $folio]));

        $libro = Libro::find($validated['libro_id']);
        $libro->decrement('cantidad_disponible');

        return redirect()->route('prestamos.index')->with('success', "Préstamo registrado con folio #$folio.");
    }

    public function show(Prestamo $prestamo)
    {
        return view('prestamos.show', compact('prestamo'));
    }

   public function devolver(Prestamo $prestamo)
    {
        if (strtolower(trim($prestamo->estado)) === 'devuelto') {
            return back()->with('error', 'Este préstamo ya fue devuelto.');
        }

        $prestamo->update([
            'estado'                => 'Devuelto',
            'fecha_devolucion_real' => now(),
        ]);

        // Restaurar disponibilidad del libro
        $prestamo->libro->increment('cantidad_disponible');

        // Si el alumno estaba como Deudor, vuelve a Activo
        if (strtolower(trim($prestamo->alumno->estado)) === 'deudor') {
            $prestamo->alumno->update(['estado' => 'Activo']);
        }

        return redirect()->route('prestamos.index')->with('success', 'Devolución registrada correctamente.');
    }

    public function destroy(Prestamo $prestamo)
    {
        $prestamo->libro->increment('cantidad_disponible');
        $prestamo->delete();
        return redirect()->route('prestamos.index')->with('success', 'Préstamo eliminado.');
    }
    
    public function vale(Prestamo $prestamo)
    {
        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('prestamos.vale', compact('prestamo'));
        return $pdf->stream("vale_prestamo_{$prestamo->folio}.pdf");
    }
}