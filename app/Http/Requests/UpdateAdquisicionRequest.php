<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdquisicionRequest extends FormRequest
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
    public function attributes(): array
    {
        return [
            'carrera_id'    => 'carrera',
            'cantidad'      => 'cantidad',
            'titulo'        => 'título',
            'autor'         => 'autor',
            'editorial'     => 'editorial',
            'localizacion'  => 'localización',
            'observacion'   => 'observación',
            'codigo_barras' => 'código de barras',
            'proveedor'     => 'proveedor',
            'factura'       => 'número de factura',
            'fecha_factura' => 'fecha de factura',
            'costo'         => 'costo',
        ];
    }

    public function messages(): array
    {
        return [
            'titulo.required'        => 'El título es obligatorio.',
            'autor.required'         => 'El autor es obligatorio.',
            'editorial.required'     => 'La editorial es obligatoria.',
            'proveedor.required'     => 'El proveedor es obligatorio.',
            'factura.required'       => 'El número de factura es obligatorio.',
            'fecha_factura.required' => 'La fecha de factura es obligatoria.',
            'costo.required'         => 'El costo es obligatorio.',
            'costo.min'              => 'El costo no puede ser negativo.',
            'cantidad.min'           => 'La cantidad debe ser al menos 1.',
            'carrera_id.required'    => 'Debes seleccionar una carrera.',
        ];
    }
}