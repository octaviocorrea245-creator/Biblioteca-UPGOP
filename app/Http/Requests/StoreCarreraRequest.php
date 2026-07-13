<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCarreraRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nombre' => 'required|string|max:255|unique:carreras',
            'clave'  => 'required|string|max:20|unique:carreras',
            'activa' => 'required|boolean',
        ];
    }
}