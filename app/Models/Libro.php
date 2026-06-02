<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Libro extends Model
{
    use HasFactory;

    protected $fillable = [
        'carrera_id',
        'codigo',
        'tipo',
        'titulo',
        'autor',
        'editorial',
        'codigo_barras',
        'localizacion',
        'cantidad_total',
        'cantidad_disponible',
    ];

    protected $casts = [
        'cantidad_total'      => 'integer',
        'cantidad_disponible' => 'integer',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function prestamosActivos()
    {
        return $this->hasMany(Prestamo::class)->where('estado', 'Activo');
    }

    public function estaDisponible()
    {
        return $this->cantidad_disponible > 0;
    }

    public function actualizarDisponibilidad()
    {
        $prestamosActivos = $this->prestamosActivos()->count();
        $this->cantidad_disponible = $this->cantidad_total - $prestamosActivos;
        $this->save();
    }
}