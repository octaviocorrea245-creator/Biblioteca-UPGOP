<?php

namespace App\Http\Controllers;

use App\Models\Alumno;
use App\Models\Carrera;
use Illuminate\Http\Request;

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

    public function store(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string',
            'matricula'   => 'required|string|unique:alumnos',
            'carrera_id'  => 'required|exists:carreras,id',
            'genero'      => 'required|in:M,F,Otro',
            'cuatrimestre'=> 'required|integer|min:1|max:12',
            'turno'       => 'required|in:M,V,N',
            'generacion'  => 'required|digits:4',
        ]);

        Alumno::create($request->all());
        return redirect()->route('alumnos.index')->with('success', 'Alumno registrado correctamente.');
    }

    public function edit(Alumno $alumno)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('alumnos.edit', compact('alumno', 'carreras'));
    }

    public function update(Request $request, Alumno $alumno)
    {
        $request->validate([
            'nombre'      => 'required|string',
            'matricula'   => 'required|string|unique:alumnos,matricula,' . $alumno->id,
            'carrera_id'  => 'required|exists:carreras,id',
            'genero'      => 'required|in:M,F,Otro',
            'cuatrimestre'=> 'required|integer|min:1|max:12',
            'turno'       => 'required|in:M,V,N',
            'generacion'  => 'required|digits:4',
        ]);

        $alumno->update($request->all());
        return redirect()->route('alumnos.index')->with('success', 'Alumno actualizado correctamente.');
    }

    public function destroy(Alumno $alumno)
    {
        $alumno->delete();
        return redirect()->route('alumnos.index')->with('success', 'Alumno eliminado.');
    }
}