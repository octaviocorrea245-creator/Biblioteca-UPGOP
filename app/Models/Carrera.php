<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $fillable = [
        'nombre',
        'clave',
        'activa',
    ];

    public function libros()
    {
        return $this->hasMany(Libro::class);
    }

    public function alumnos()
    {
        return $this->hasMany(Alumno::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function donaciones()
    {
        return $this->hasMany(Donacion::class);
    }

    public function adquisiciones()
    {
        return $this->hasMany(Adquisicion::class);
    }
}