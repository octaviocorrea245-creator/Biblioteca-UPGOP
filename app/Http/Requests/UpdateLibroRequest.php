<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateLibroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|max:255|unique:libros,codigo,' . $this->libro->id,
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string|max:255',
            'autor'               => 'required|string|max:255',
            'editorial'           => 'required|string|max:255',
            'codigo_barras'       => 'nullable|string|max:100',
            'localizacion'        => 'nullable|string|max:100',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'costo'               => 'nullable|numeric|min:0',
        ];
    }
    public function attributes(): array
    {
        return [
            'carrera_id'          => 'carrera',
            'codigo'              => 'código',
            'tipo'                => 'tipo',
            'titulo'              => 'título',
            'autor'               => 'autor',
            'editorial'           => 'editorial',
            'codigo_barras'       => 'código de barras',
            'localizacion'        => 'localización',
            'cantidad_total'      => 'cantidad total',
            'cantidad_disponible' => 'cantidad disponible',
            'costo'               => 'costo',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'              => 'El título del libro es obligatorio.',
            'autor.required'               => 'El autor es obligatorio.',
            'editorial.required'           => 'La editorial es obligatoria.',
            'codigo.required'              => 'El código interno es obligatorio.',
            'codigo.unique'                => 'Ya existe un libro con ese código.',
            'cantidad_total.min'           => 'La cantidad total debe ser al menos 1.',
            'cantidad_disponible.min'      => 'La cantidad disponible no puede ser negativa.',
            'cantidad_disponible.lte'      => 'La cantidad disponible no puede ser mayor a la cantidad total.',
            'tipo.in'                      => 'El tipo debe ser Regular, Donado o Adquirido.',
        ];
    }
}