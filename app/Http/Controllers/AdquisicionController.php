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
        $request->validate([
            'carrera_id'    => 'required|exists:carreras,id',
            'cantidad'      => 'required|integer|min:1',
            'titulo'        => 'required|string',
            'autor'         => 'required|string',
            'editorial'     => 'required|string',
            'localizacion'  => 'nullable|string',
            'observacion'   => 'nullable|string',
            'codigo_barras' => 'nullable|string',
            'proveedor'     => 'required|string',
            'factura'       => 'required|string',
            'fecha_factura' => 'required|date',
            'costo'         => 'required|numeric|min:0',
        ]);

        Adquisicion::create($request->all());
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición registrada correctamente.');
    }

    public function edit(Adquisicion $adquisicion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('adquisiciones.edit', compact('adquisicion', 'carreras'));
    }

    public function update(Request $request, Adquisicion $adquisicion)
    {
        $request->validate([
            'carrera_id'    => 'required|exists:carreras,id',
            'cantidad'      => 'required|integer|min:1',
            'titulo'        => 'required|string',
            'autor'         => 'required|string',
            'editorial'     => 'required|string',
            'localizacion'  => 'nullable|string',
            'observacion'   => 'nullable|string',
            'codigo_barras' => 'nullable|string',
            'proveedor'     => 'required|string',
            'factura'       => 'required|string',
            'fecha_factura' => 'required|date',
            'costo'         => 'required|numeric|min:0',
        ]);

        $adquisicion->update($request->all());
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición actualizada correctamente.');
    }

    public function destroy(Adquisicion $adquisicion)
    {
        $adquisicion->delete();
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición eliminada.');
    }
}