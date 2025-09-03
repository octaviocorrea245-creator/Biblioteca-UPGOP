<?php

namespace App\Http\Controllers;

use App\Models\Usuario;
use Illuminate\Http\Request;

class UsuarioController extends Controller
{
    public function index()
    {
        try {
            $usuarios = Usuario::with('prestamosActivos')->get();
            return response()->json($usuarios);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al obtener usuarios'], 500);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email',
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        try {
            $usuario = Usuario::create($request->all());
            return response()->json($usuario, 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear usuario'], 500);
        }
    }

    public function show($id)
    {
        try {
            $usuario = Usuario::with(['prestamos.libro'])->findOrFail($id);
            return response()->json($usuario);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Usuario no encontrado'], 404);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:usuarios,email,' . $id,
            'telefono' => 'nullable|string|max:20',
            'direccion' => 'nullable|string',
            'activo' => 'boolean'
        ]);

        try {
            $usuario = Usuario::findOrFail($id);
            $usuario->update($request->all());
            return response()->json($usuario);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar usuario'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $usuario = Usuario::findOrFail($id);

            // Verificar que no tenga prestamos activos
            if ($usuario->prestamosActivos()->count() > 0) {
                return response()->json([
                    'error' => 'No se puede eliminar un usuario con préstamos activos'
                ], 400);
            }

            $usuario->delete();
            return response()->json(['message' => 'Usuario eliminado correctamente']);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar usuario'], 500);
        }
    }
}
