<?php

namespace App\Http\Controllers;

use App\Models\Adquisicion;
use App\Models\Carrera;
use Illuminate\Http\Request;

class AdquisicionController extends Controller
{
    public function index()
    {
        $adquisiciones = Adquisicion::with('carrera')->paginate(10);
        return view('adquisiciones.index', compact('adquisiciones'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('adquisiciones.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrera_id'    => 'required|exists:carreras,id',
            'cantidad'      => 'required|integer|min:1',
            'titulo'        => 'required|string|max:255',
            'autor'         => 'required|string|max:255',
            'editorial'     => 'required|string|max:255',
            'localizacion'  => 'nullable|string|max:100',
            'observacion'   => 'nullable|string|max:500',
            'codigo_barras' => 'nullable|string|max:100',
            'proveedor'     => 'required|string|max:255',
            'factura'       => 'required|string|max:50',
            'fecha_factura' => 'required|date',
            'costo'         => 'required|numeric|min:0',
        ]);

        Adquisicion::create($validated);
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición registrada correctamente.');
    }

    public function edit(Adquisicion $adquisicion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('adquisiciones.edit', compact('adquisicion', 'carreras'));
    }

    public function update(Request $request, Adquisicion $adquisicion)
    {
        $validated = $request->validate([
            'carrera_id'    => 'required|exists:carreras,id',
            'cantidad'      => 'required|integer|min:1',
            'titulo'        => 'required|string|max:255',
            'autor'         => 'required|string|max:255',
            'editorial'     => 'required|string|max:255',
            'localizacion'  => 'nullable|string|max:100',
            'observacion'   => 'nullable|string|max:500',
            'codigo_barras' => 'nullable|string|max:100',
            'proveedor'     => 'required|string|max:255',
            'factura'       => 'required|string|max:50',
            'fecha_factura' => 'required|date',
            'costo'         => 'required|numeric|min:0',
        ]);

        $adquisicion->update($validated);
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición actualizada correctamente.');
    }

    public function destroy(Adquisicion $adquisicion)
    {
        $adquisicion->delete();
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición eliminada.');
    }
}