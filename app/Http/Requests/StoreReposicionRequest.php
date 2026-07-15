<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreReposicionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'prestamo_id'   => 'required|exists:prestamos,id',
            'tipo'          => 'required|in:Perdida,Daño',
            'monto'         => 'required|numeric|min:0',
            'fecha_reporte' => 'required|date',
            'observaciones' => 'nullable|string|max:500',
        ];
    }
    public function attributes(): array
    {
        return [
            'prestamo_id'   => 'préstamo',
            'tipo'          => 'tipo de reposición',
            'monto'         => 'monto',
            'fecha_reporte' => 'fecha de reporte',
            'observaciones' => 'observaciones',
        ];
    }

    public function messages(): array
    {
        return [
            'prestamo_id.required'   => 'Debes seleccionar un préstamo.',
            'prestamo_id.exists'     => 'El préstamo seleccionado no existe.',
            'tipo.required'          => 'El tipo de reposición es obligatorio.',
            'tipo.in'                => 'El tipo debe ser Pérdida o Daño.',
            'monto.required'         => 'El monto es obligatorio.',
            'monto.min'              => 'El monto no puede ser negativo.',
            'fecha_reporte.required' => 'La fecha de reporte es obligatoria.',
        ];
    }
}