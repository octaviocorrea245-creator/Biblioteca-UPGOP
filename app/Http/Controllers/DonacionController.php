<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Models\Carrera;
use Illuminate\Http\Request;

class DonacionController extends Controller
{
    public function index()
    {
        $donaciones = Donacion::with('carrera')->paginate(10);
        return view('donaciones.index', compact('donaciones'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('donaciones.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrera_id'        => 'required|exists:carreras,id',
            'titulo'            => 'required|string|max:255',
            'autor'             => 'required|string|max:255',
            'editorial'         => 'required|string|max:255',
            'codigo_barras'     => 'nullable|string|max:100',
            'costo'             => 'nullable|numeric|min:0',
            'fecha'             => 'required|date',
            'alumno_donante'    => 'required|string|max:255',
            'matricula_donante' => 'required|string|max:20',
            'cuatrimestre'      => 'required|string|max:20',
            'generacion'        => 'required|digits:4',
        ]);

        // Generar código automático D-[generacion]-[###]
        $codigo = Donacion::generarCodigo($validated['generacion']);

        Donacion::create(array_merge($validated, ['codigo_donacion' => $codigo]));

        return redirect()->route('donaciones.index')->with('success', "Donación registrada con código $codigo.");
    }

    public function edit(Donacion $donacion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('donaciones.edit', compact('donacion', 'carreras'));
    }

    public function update(Request $request, Donacion $donacion)
    {
        $validated = $request->validate([
            'carrera_id'        => 'required|exists:carreras,id',
            'titulo'            => 'required|string|max:255',
            'autor'             => 'required|string|max:255',
            'editorial'         => 'required|string|max:255',
            'codigo_barras'     => 'nullable|string|max:100',
            'costo'             => 'nullable|numeric|min:0',
            'fecha'             => 'required|date',
            'alumno_donante'    => 'required|string|max:255',
            'matricula_donante' => 'required|string|max:20',
            'cuatrimestre'      => 'required|string|max:20',
            'generacion'        => 'required|digits:4',
        ]);

        $donacion->update($validated);
        return redirect()->route('donaciones.index')->with('success', 'Donación actualizada correctamente.');
    }

    public function destroy(Donacion $donacion)
    {
        $donacion->delete();
        return redirect()->route('donaciones.index')->with('success', 'Donación eliminada.');
    }
}