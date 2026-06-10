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
        $request->validate([
            'carrera_id'        => 'required|exists:carreras,id',
            'titulo'            => 'required|string',
            'autor'             => 'required|string',
            'editorial'         => 'required|string',
            'codigo_barras'     => 'nullable|string',
            'costo'             => 'nullable|numeric',
            'fecha'             => 'required|date',
            'alumno_donante'    => 'required|string',
            'matricula_donante' => 'required|string',
            'cuatrimestre'      => 'required|string',
            'generacion'        => 'required|digits:4',
        ]);

        // Generar código automático D-[generacion]-[###]
        $codigo = Donacion::generarCodigo($request->generacion);

        Donacion::create(array_merge($request->all(), ['codigo_donacion' => $codigo]));

        return redirect()->route('donaciones.index')->with('success', "Donación registrada con código $codigo.");
    }

    public function edit(Donacion $donacion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('donaciones.edit', compact('donacion', 'carreras'));
    }

    public function update(Request $request, Donacion $donacion)
    {
        $request->validate([
            'carrera_id'        => 'required|exists:carreras,id',
            'titulo'            => 'required|string',
            'autor'             => 'required|string',
            'editorial'         => 'required|string',
            'codigo_barras'     => 'nullable|string',
            'costo'             => 'nullable|numeric',
            'fecha'             => 'required|date',
            'alumno_donante'    => 'required|string',
            'matricula_donante' => 'required|string',
            'cuatrimestre'      => 'required|string',
            'generacion'        => 'required|digits:4',
        ]);

        $donacion->update($request->all());
        return redirect()->route('donaciones.index')->with('success', 'Donación actualizada correctamente.');
    }

    public function destroy(Donacion $donacion)
    {
        $donacion->delete();
        return redirect()->route('donaciones.index')->with('success', 'Donación eliminada.');
    }
}