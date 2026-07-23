<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Prestamo extends Model
{
    use HasFactory;

    // Estados del préstamo
    public const ACTIVO = 'Activo';
    public const DEVUELTO = 'Devuelto';
    public const VENCIDO = 'Vencido';

    protected $fillable = [
        'folio',
        'carrera_id',
        'alumno_id',
        'libro_id',
        'cuatrimestre',
        'anio',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado',
        'observaciones',
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_esperada' => 'date',
        'fecha_devolucion_real' => 'date',
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }

    // Scope para préstamos activos
    public function scopeActivos($query)
    {
        return $query->whereRaw('LOWER(estado) = ?', ['activo']);
    }

    // Genera el siguiente folio para una carrera
    public static function siguienteFolio($carrera_id): int
    {
        $ultimo = self::where('carrera_id', $carrera_id)->max('folio');

        return $ultimo ? $ultimo + 1 : 1;
    }

    // Métodos auxiliares
    public function estaActivo(): bool
    {
        return strtolower(trim($this->estado)) === 'activo';
    }

    public function estaDevuelto(): bool
    {
        return strtolower(trim($this->estado)) === 'devuelto';
    }

    public function estaVencido(): bool
    {
        return strtolower(trim($this->estado)) === 'vencido';
    }
    

    public function scopeVencidos($query)
    {
        return $query->whereRaw('LOWER(estado) = ?', ['vencido']);
    }

    public function scopeDevueltos($query)
    {
        return $query->whereRaw('LOWER(estado) = ?', ['devuelto']);
    }

    public function scopeProximosAVencer($query, int $dias = 3)
    {
        return $query->activos()
            ->whereDate('fecha_devolucion_esperada', '<=', now()->addDays($dias));
    }
    
}