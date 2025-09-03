<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usuario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'direccion',
        'activo'
    ];

    protected $casts = [
        'activo' => 'boolean'
    ];

    public function prestamos()
    {
        return $this->hasMany(Prestamo::class);
    }

    public function prestamosActivos()
    {
        return $this->hasMany(Prestamo::class)->where('estado', 'activo');
    }

    public function puedePrestar()
    {
        return $this->prestamosActivos()->count() < 3 && $this->activo;
    }

    public function tienePrestamosVencidos()
    {
        return $this->prestamosActivos()
            ->where('fecha_devolucion_esperada', '<', now()->toDateString())
            ->exists();
    }
}
