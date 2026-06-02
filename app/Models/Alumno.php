<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Alumno extends Model
{
    protected $fillable = [
        'carrera_id',
        'nombre',
        'matricula',
        'genero',
        'cuatrimestre',
        'turno',
        'generacion',
        'estado',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
        
    }
    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }
}