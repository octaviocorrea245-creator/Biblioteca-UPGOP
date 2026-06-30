<?php

namespace App\Http\Controllers;

use App\Models\Carrera;
use Illuminate\Http\Request;

class CarreraController extends Controller
{
    public function index()
    {
        $carreras = Carrera::all();
        return view('carreras.index', compact('carreras'));
    }

    public function create()
    {
        return view('carreras.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:carreras',
            'clave'  => 'required|string|max:20|unique:carreras',
            'activa' => 'required|boolean',
        ]);

        Carrera::create($validated);
        return redirect()->route('carreras.index')->with('success', 'Carrera registrada correctamente.');
    }

    public function edit(Carrera $carrera)
    {
        return view('carreras.edit', compact('carrera'));
    }

    public function update(Request $request, Carrera $carrera)
    {
        $validated = $request->validate([
            'nombre' => 'required|string|max:255|unique:carreras,nombre,' . $carrera->id,
            'clave'  => 'required|string|max:20|unique:carreras,clave,' . $carrera->id,
            'activa' => 'required|boolean',
        ]);

        $carrera->update($validated);
        return redirect()->route('carreras.index')->with('success', 'Carrera actualizada correctamente.');
    }

    public function destroy(Carrera $carrera)
    {
        $carrera->delete();
        return redirect()->route('carreras.index')->with('success', 'Carrera eliminada.');
    }
}