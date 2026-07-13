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
}