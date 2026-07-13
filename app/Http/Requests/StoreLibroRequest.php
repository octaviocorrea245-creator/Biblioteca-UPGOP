<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreLibroRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|max:255|unique:libros',
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
}