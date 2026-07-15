<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;


class Carrera extends Model
{
    protected $fillable = [
        'nombre',
        'clave',
        'activa',
    ];

    public function libros(): HasMany
    {
        return $this->hasMany(Libro::class);
    }

    public function alumnos(): HasMany
    {
        return $this->hasMany(Alumno::class);
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }

    public function donaciones(): HasMany
    {
        return $this->hasMany(Donacion::class);
    }

    public function adquisiciones(): HasMany
    {
        return $this->hasMany(Adquisicion::class);
    }
}