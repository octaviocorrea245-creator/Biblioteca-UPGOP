<?php

namespace App\Http\Controllers;

use App\Models\Prestamo;
use App\Models\Usuario;
use App\Models\Libro;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PrestamoController extends Controller
{
    public function index()
    {
        try {
            $prestamos = Prestamo::with(['usuario', 'libro'])->get();
            return response()->json($prestamos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener préstamos'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'usuario_id' => 'required|exists:usuarios,id',
            'libro_id' => 'required|exists:libros,id',
            'fecha_prestamo' => 'required|date',
            'dias_prestamo' => 'required|integer|min:1|max:30',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $usuario = Usuario::findOrFail($request->usuario_id);
            $libro = Libro::findOrFail($request->libro_id);

            // Validaciones de negocio
            if (!$usuario->puedePrestar()) {
                return response()->json([
                    'error' => 'El usuario no puede pedir más préstamos (máximo 3 activos o usuario inactivo)'
                ], 400);
            }

            if ($usuario->tienePrestamosVencidos()) {
                return response()->json([
                    'error' => 'El usuario tiene préstamos vencidos y no puede pedir más libros'
                ], 400);
            }

            if (!$libro->estaDisponible()) {
                return response()->json([
                    'error' => 'El libro no está disponible'
                ], 400);
            }

            // Calcular fecha de devolución
            $fechaDevolucion = Carbon::parse($request->fecha_prestamo)
                ->addDays($request->dias_prestamo);

            $prestamo = Prestamo::create([
                'usuario_id' => $request->usuario_id,
                'libro_id' => $request->libro_id,
                'fecha_prestamo' => $request->fecha_prestamo,
                'fecha_devolucion_esperada' => $fechaDevolucion,
                'estado' => 'activo',
                'observaciones' => $request->observaciones
            ]);

            // Actualizar disponibilidad del libro
            $libro->actualizarDisponibilidad();

            return response()->json($prestamo->load(['usuario', 'libro']), 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear préstamo'], 500);
        }
    }

    public function show($id)
    {
        try {
            $prestamo = Prestamo::with(['usuario', 'libro'])->findOrFail($id);
            return response()->json($prestamo);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Préstamo no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'fecha_devolucion_esperada' => 'nullable|date',
            'observaciones' => 'nullable|string'
        ]);

        try {
            $prestamo = Prestamo::findOrFail($id);

            if ($prestamo->estado !== 'activo') {
                return response()->json([
                    'error' => 'Solo se pueden modificar préstamos activos'
                ], 400);
            }

            $prestamo->update($request->only([
                'fecha_devolucion_esperada', 'observaciones'
            ]));

            return response()->json($prestamo->load(['usuario', 'libro']));
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar préstamo'], 500);
        }
    }

    public function devolver(Request $request, $id)
    {
        $request->validate([
            'observaciones' => 'nullable|string'
        ]);

        try {
            $prestamo = Prestamo::findOrFail($id);

            if ($prestamo->estado !== 'activo') {
                return response()->json([
                    'error' => 'El préstamo ya fue devuelto'
                ], 400);
            }

            $prestamo->devolver($request->observaciones);

            return response()->json([
                'message' => 'Libro devuelto correctamente',
                'prestamo' => $prestamo->load(['usuario', 'libro'])
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al devolver libro'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $prestamo = Prestamo::findOrFail($id);

            // Solo permitir eliminar préstamos devueltos
            if ($prestamo->estado === 'activo') {
                return response()->json([
                    'error' => 'No se puede eliminar un préstamo activo. Debe devolverlo primero.'
                ], 400);
            }

            $prestamo->delete();
            return response()->json(['message' => 'Préstamo eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar préstamo'], 500);
        }
    }
}
