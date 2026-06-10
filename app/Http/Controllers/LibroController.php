<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with('carrera')->paginate(10);
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carrera_id'          => 'required|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros',
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string',
            'autor'               => 'required|string',
            'editorial'           => 'required|string',
            'codigo_barras'       => 'nullable|string',
            'localizacion'        => 'nullable|string',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
        ]);

        Libro::create($request->all());
        return redirect()->route('libros.index')->with('success', 'Libro registrado correctamente.');
    }

    public function edit(Libro $libro)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.edit', compact('libro', 'carreras'));
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'carrera_id'          => 'required|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros,codigo,' . $libro->id,
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string',
            'autor'               => 'required|string',
            'editorial'           => 'required|string',
            'codigo_barras'       => 'nullable|string',
            'localizacion'        => 'nullable|string',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
        ]);

        $libro->update($request->all());
        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('success', 'Libro eliminado.');
    }
}