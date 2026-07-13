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
}