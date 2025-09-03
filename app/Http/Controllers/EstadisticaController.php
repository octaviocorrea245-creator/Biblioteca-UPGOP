<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Usuario;
use App\Models\Prestamo;

class EstadisticaController extends Controller
{
    public function resumen()
    {
        try {
            $totalLibros = Libro::count();
            $totalUsuarios = Usuario::count();
            $prestamosActivos = Prestamo::where('estado', 'activo')->count();
            $prestamosVencidos = Prestamo::where('estado', 'activo')
                ->where('fecha_devolucion_esperada', '<', now()->toDateString())
                ->count();

            return response()->json([
                'total_libros' => $totalLibros,
                'total_usuarios' => $totalUsuarios,
                'prestamos_activos' => $prestamosActivos,
                'prestamos_vencidos' => $prestamosVencidos,
                'libros_disponibles' => Libro::sum('cantidad_disponible'),
                'usuarios_activos' => Usuario::where('activo', true)->count()
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener estadísticas'], 500);
        }
    }

    public function librosMasPrestados()
    {
        try {
            $libros = Libro::withCount('prestamos')
                ->orderBy('prestamos_count', 'desc')
                ->take(10)
                ->get();

            return response()->json($libros);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener libros más prestados'], 500);
        }
    }

    public function usuariosMasActivos()
    {
        try {
            $usuarios = Usuario::withCount('prestamos')
                ->orderBy('prestamos_count', 'desc')
                ->take(10)
                ->get();

            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios más activos'], 500);
        }
    }

    public function prestamosPorMes()
    {
        try {
            $prestamos = Prestamo::selectRaw('YEAR(fecha_prestamo) as año, MONTH(fecha_prestamo) as mes, COUNT(*) as total')
                ->groupBy('año', 'mes')
                ->orderBy('año', 'desc')
                ->orderBy('mes', 'desc')
                ->take(12)
                ->get();

            return response()->json($prestamos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener préstamos por mes'], 500);
        }
    }

    public function generosMasPopulares()
    {
        try {
            $generos = Prestamo::join('libros', 'prestamos.libro_id', '=', 'libros.id')
                ->selectRaw('libros.genero, COUNT(*) as total_prestamos')
                ->groupBy('libros.genero')
                ->orderBy('total_prestamos', 'desc')
                ->get();

            return response()->json($generos);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener géneros más populares'], 500);
        }
    }
}
