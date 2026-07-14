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
        'costo',
    ];

    protected $casts = [
        'cantidad_total' => 'integer',
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
        return $this->hasMany(Prestamo::class)
            ->where('estado', Prestamo::ACTIVO);
    }

    public function estaDisponible(): bool
    {
        return $this->cantidad_total > 0
            && $this->cantidad_disponible > 0;
    }

    public function actualizarDisponibilidad(): void
    {
        $prestamosActivos = $this->prestamosActivos()->count();

        $this->cantidad_disponible = max(
            0,
            $this->cantidad_total - $prestamosActivos
        );

        $this->save();
    }
    public function scopeBuscar($query, $texto)
    {
        return $query->where(function ($q) use ($texto) {
            $q->where('titulo', 'like', "%{$texto}%")
            ->orWhere('autor', 'like', "%{$texto}%")
            ->orWhere('codigo', 'like', "%{$texto}%")
            ->orWhere('codigo_barras', 'like', "%{$texto}%")
            ->orWhere('editorial', 'like', "%{$texto}%");
        });
    }
    public function scopeDisponibles($query)
    {
        return $query->where('cantidad_disponible', '>', 0);
    }

    public function scopeTipo($query, string $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    public function scopeDeCarrera($query, int $carreraId)
    {
        return $query->where('carrera_id', $carreraId);
    }
}