<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'       => 'required|string|max:255',
            'matricula'    => 'required|string|max:20|unique:alumnos,matricula,' . $this->alumno->id,
            'carrera_id'   => 'required|exists:carreras,id',
            'genero'       => 'required|in:M,F,Otro',
            'cuatrimestre' => 'required|integer|min:1|max:12',
            'turno'        => 'required|in:M,V,N',
            'generacion'   => 'required|digits:4',
            'estado'       => 'required|in:Activo,Deudor,Rezagado',
        ];
    }
    public function attributes(): array
    {
        return [
            'nombre'       => 'nombre completo',
            'matricula'    => 'matrícula',
            'carrera_id'   => 'carrera',
            'genero'       => 'género',
            'cuatrimestre' => 'cuatrimestre',
            'turno'        => 'turno',
            'generacion'   => 'generación',
            'estado'       => 'estado',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required'       => 'El nombre del alumno es obligatorio.',
            'matricula.required'    => 'La matrícula es obligatoria.',
            'matricula.unique'      => 'Ya existe un alumno con esa matrícula.',
            'carrera_id.required'   => 'Debes seleccionar una carrera.',
            'carrera_id.exists'     => 'La carrera seleccionada no existe.',
            'genero.in'             => 'El género debe ser M, F u Otro.',
            'cuatrimestre.min'      => 'El cuatrimestre debe ser entre 1 y 12.',
            'cuatrimestre.max'      => 'El cuatrimestre debe ser entre 1 y 12.',
            'generacion.digits'     => 'La generación debe ser un año de 4 dígitos.',
        ];
    }
}