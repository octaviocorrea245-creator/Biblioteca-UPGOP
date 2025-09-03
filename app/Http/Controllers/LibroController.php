<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        try {
            $libros = Libro::with('prestamosActivos')->get();
            return response()->json($libros);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener libros'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'isbn' => 'nullable|string|unique:libros,isbn',
            'cantidad_total' => 'required|integer|min:1'
        ]);

        try {
            $libro = Libro::create([
                'titulo' => $request->titulo,
                'autor' => $request->autor,
                'genero' => $request->genero,
                'descripcion' => $request->descripcion,
                'isbn' => $request->isbn,
                'cantidad_total' => $request->cantidad_total,
                'cantidad_disponible' => $request->cantidad_total
            ]);

            return response()->json($libro, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear libro'], 500);
        }
    }

    public function show($id)
    {
        try {
            $libro = Libro::with(['prestamos.usuario'])->findOrFail($id);
            return response()->json($libro);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Libro no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'required|string|max:255',
            'genero' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'isbn' => 'nullable|string|unique:libros,isbn,' . $id,
            'cantidad_total' => 'required|integer|min:1'
        ]);

        try {
            $libro = Libro::findOrFail($id);

            // Verificar que la nueva cantidad no sea menor a los préstamos activos
            $prestamosActivos = $libro->prestamosActivos()->count();
            if ($request->cantidad_total < $prestamosActivos) {
                return response()->json([
                    'error' => 'La cantidad total no puede ser menor a los préstamos activos (' . $prestamosActivos . ')'
                ], 400);
            }

            $libro->update($request->only([
                'titulo', 'autor', 'genero', 'descripcion', 'isbn', 'cantidad_total'
            ]));

            $libro->actualizarDisponibilidad();

            return response()->json($libro);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar libro'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $libro = Libro::findOrFail($id);

            // Verificar que no tenga prestamos activos
            if ($libro->prestamosActivos()->count() > 0) {
                return response()->json([
                    'error' => 'No se puede eliminar un libro con préstamos activos'
                ], 400);
            }

            $libro->delete();
            return response()->json(['message' => 'Libro eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar libro'], 500);
        }
    }
}
