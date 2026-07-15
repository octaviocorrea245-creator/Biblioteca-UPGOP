<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDonacionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
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
        ];
    }
    public function attributes(): array
    {
        return [
            'carrera_id'        => 'carrera',
            'titulo'            => 'título',
            'autor'             => 'autor',
            'editorial'         => 'editorial',
            'codigo_barras'     => 'código de barras',
            'costo'             => 'costo',
            'fecha'             => 'fecha de donación',
            'alumno_donante'    => 'nombre del donante',
            'matricula_donante' => 'matrícula del donante',
            'cuatrimestre'      => 'cuatrimestre',
            'generacion'        => 'generación',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'            => 'El título del libro es obligatorio.',
            'autor.required'             => 'El autor es obligatorio.',
            'editorial.required'         => 'La editorial es obligatoria.',
            'fecha.required'             => 'La fecha de donación es obligatoria.',
            'alumno_donante.required'    => 'El nombre del donante es obligatorio.',
            'matricula_donante.required' => 'La matrícula del donante es obligatoria.',
            'generacion.digits'          => 'La generación debe ser un año de 4 dígitos.',
            'carrera_id.required'        => 'Debes seleccionar una carrera.',
        ];
    }
}