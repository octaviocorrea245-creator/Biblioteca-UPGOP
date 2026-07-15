<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:carreras,nombre,' . $this->carrera->id,
            'clave'  => 'required|string|max:20|unique:carreras,clave,' . $this->carrera->id,
            'activa' => 'required|boolean',
        ];
    }
    public function attributes(): array
    {
        return [
            'nombre' => 'nombre de la carrera',
            'clave'  => 'clave de la carrera',
            'activa' => 'estado activo',
        ];
    }

    public function messages(): array
    {
        return [
            'nombre.required' => 'El nombre de la carrera es obligatorio.',
            'nombre.unique'   => 'Ya existe una carrera con ese nombre.',
            'clave.required'  => 'La clave de la carrera es obligatoria.',
            'clave.unique'    => 'Ya existe una carrera con esa clave.',
        ];
    }
}