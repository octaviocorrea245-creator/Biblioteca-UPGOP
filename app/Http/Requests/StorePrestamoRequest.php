<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrestamoRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'alumno_id'                 => 'required|exists:alumnos,id',
            'libro_id'                  => 'required|exists:libros,id',
            'carrera_id'                => 'required|exists:carreras,id',
            'cuatrimestre'              => 'required|string|max:20',
            'anio'                      => 'required|digits:4',
            'fecha_prestamo'            => 'required|date',
            'fecha_devolucion_esperada' => 'required|date|after:fecha_prestamo',
            'observaciones'             => 'nullable|string|max:500',
        ];
    }
}