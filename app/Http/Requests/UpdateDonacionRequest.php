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
}