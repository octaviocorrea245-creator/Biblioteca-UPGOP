<?php

namespace App\Http\Controllers;

use App\Models\Donacion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreDonacionRequest;
use App\Http\Requests\UpdateDonacionRequest;

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

    public function store(StoreDonacionRequest $request)
    {
        $validated = $request->validated();
        $codigo = Donacion::generarCodigo($validated['generacion']);
        Donacion::create(array_merge($validated, ['codigo_donacion' => $codigo]));
        return redirect()->route('donaciones.index')->with('success', "Donación registrada con código $codigo.");
    }

    public function edit(Donacion $donacion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('donaciones.edit', compact('donacion', 'carreras'));
    }

    public function update(UpdateDonacionRequest $request, Donacion $donacion)
    {
        $donacion->update($request->validated());
        return redirect()->route('donaciones.index')->with('success', 'Donación actualizada correctamente.');
    }

    public function destroy(Donacion $donacion)
    {
        $donacion->delete();
        return redirect()->route('donaciones.index')->with('success', 'Donación eliminada.');
    }
}