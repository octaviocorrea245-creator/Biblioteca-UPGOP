<?php

namespace App\Http\Controllers;

use App\Models\Adquisicion;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdquisicionRequest;
use App\Http\Requests\UpdateAdquisicionRequest;

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

    public function store(StoreAdquisicionRequest $request)
    {
        Adquisicion::create($request->validated());
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición registrada correctamente.');
    }

    public function edit(Adquisicion $adquisicion)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('adquisiciones.edit', compact('adquisicion', 'carreras'));
    }

   public function update(UpdateAdquisicionRequest $request, Adquisicion $adquisicion)
    {
        $adquisicion->update($request->validated());
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición actualizada correctamente.');
    }

    public function destroy(Adquisicion $adquisicion)
    {
        $adquisicion->delete();
        return redirect()->route('adquisiciones.index')->with('success', 'Adquisición eliminada.');
    }
}