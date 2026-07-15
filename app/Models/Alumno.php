<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Alumno extends Model
{
    public const ACTIVO = 'Activo';
    public const DEUDOR = 'Deudor';
    public const REZAGADO = 'Rezagado';
    
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

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function prestamos(): HasMany
    {
        return $this->hasMany(Prestamo::class);
    }
    public function scopeActivos($query)
    {
        return $query->where('estado', 'Activo');
    }

    public function scopeDeudores($query)
    {
        return $query->where('estado', 'Deudor');
    }

    public function scopeRezagados($query)
    {
        return $query->where('estado', 'Rezagado');
    }

    public function scopeBuscar($query, string $texto)
    {
        return $query->where(function ($q) use ($texto) {
            $q->where('nombre', 'like', "%{$texto}%")
            ->orWhere('matricula', 'like', "%{$texto}%");
        });
    }
}