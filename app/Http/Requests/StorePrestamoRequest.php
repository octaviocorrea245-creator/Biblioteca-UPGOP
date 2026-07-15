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
    public function attributes(): array
    {
        return [
            'alumno_id'                 => 'alumno',
            'libro_id'                  => 'libro',
            'carrera_id'                => 'carrera',
            'cuatrimestre'              => 'cuatrimestre',
            'anio'                      => 'año',
            'fecha_prestamo'            => 'fecha de préstamo',
            'fecha_devolucion_esperada' => 'fecha de devolución esperada',
            'observaciones'             => 'observaciones',
        ];
    }

    public function messages(): array
    {
        return [
            'alumno_id.required'                  => 'Debes seleccionar un alumno.',
            'alumno_id.exists'                    => 'El alumno seleccionado no existe.',
            'libro_id.required'                   => 'Debes seleccionar un libro.',
            'libro_id.exists'                     => 'El libro seleccionado no existe.',
            'carrera_id.required'                 => 'Debes seleccionar una carrera.',
            'fecha_prestamo.required'             => 'La fecha de préstamo es obligatoria.',
            'fecha_devolucion_esperada.required'  => 'La fecha de devolución es obligatoria.',
            'fecha_devolucion_esperada.after'     => 'La fecha de devolución debe ser posterior a la fecha de préstamo.',
            'anio.digits'                         => 'El año debe tener 4 dígitos.',
        ];
    }
}