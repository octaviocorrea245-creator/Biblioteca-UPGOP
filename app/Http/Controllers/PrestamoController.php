<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Alumno;
use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function index()
    {
        $prestamos = Prestamo::with(['alumno', 'libro', 'carrera'])->paginate(10);
        return view('prestamos.index', compact('prestamos'));
    }

    public function create()
    {
        $alumnos  = Alumno::where('estado', 'Activo')->get();
        $libros   = Libro::where('cantidad_disponible', '>', 0)->get();
        $carreras = Carrera::where('activa', true)->get();
        return view('prestamos.create', compact('alumnos', 'libros', 'carreras'));
    }

   public function store(Request $request)
    {
        $validated = $request->validate([
            'alumno_id'                 => 'required|exists:alumnos,id',
            'libro_id'                  => 'required|exists:libros,id',
            'carrera_id'                => 'required|exists:carreras,id',
            'cuatrimestre'              => 'required|string|max:20',
            'anio'                      => 'required|digits:4',
            'fecha_prestamo'            => 'required|date',
            'fecha_devolucion_esperada' => 'required|date|after:fecha_prestamo',
            'observaciones'             => 'nullable|string|max:500',
        ]);

        // Verificar que el alumno no sea rezagado
        $alumno = Alumno::find($validated['alumno_id']);
        if (strtolower(trim($alumno->estado)) === 'rezagado') {
            return back()->withErrors(['alumno_id' => 'Este alumno está rezagado y no puede realizar préstamos.'])->withInput();
        }

        // Generar folio automático por carrera
        $folio = Prestamo::siguienteFolio($validated['carrera_id']);

        // Crear el préstamo
        Prestamo::create(array_merge($validated, ['folio' => $folio]));

        // Descontar disponibilidad del libro
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