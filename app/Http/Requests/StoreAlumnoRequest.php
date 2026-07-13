<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAlumnoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre'       => 'required|string|max:255',
            'matricula'    => 'required|string|max:20|unique:alumnos',
            'carrera_id'   => 'required|exists:carreras,id',
            'genero'       => 'required|in:M,F,Otro',
            'cuatrimestre' => 'required|integer|min:1|max:12',
            'turno'        => 'required|in:M,V,N',
            'generacion'   => 'required|digits:4',
        ];
    }
}