<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAlumnoRequest;
use App\Http\Requests\UpdateAlumnoRequest;

class AlumnoController extends Controller
{
    public function index()
    {
        $alumnos = Alumno::with('carrera')->paginate(10);
        return view('alumnos.index', compact('alumnos'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('alumnos.create', compact('carreras'));
    }

    public function store(StoreAlumnoRequest $request)
    {
        Alumno::create($request->validated());
        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    public function edit(Alumno $alumno)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('alumnos.edit', compact('alumno', 'carreras'));
    }

    public function update(UpdateAlumnoRequest $request, Alumno $alumno)
    {
        $alumno->update($request->validated());
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado.');
    }
}