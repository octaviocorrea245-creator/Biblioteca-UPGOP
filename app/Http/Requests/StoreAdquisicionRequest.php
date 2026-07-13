<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdquisicionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'carrera_id'    => 'required|exists:carreras,id',
            'cantidad'      => 'required|integer|min:1',
            'titulo'        => 'required|string|max:255',
            'autor'         => 'required|string|max:255',
            'editorial'     => 'required|string|max:255',
            'localizacion'  => 'nullable|string|max:100',
            'observacion'   => 'nullable|string|max:500',
            'codigo_barras' => 'nullable|string|max:100',
            'proveedor'     => 'required|string|max:255',
            'factura'       => 'required|string|max:50',
            'fecha_factura' => 'required|date',
            'costo'         => 'required|numeric|min:0',
        ];
    }
}