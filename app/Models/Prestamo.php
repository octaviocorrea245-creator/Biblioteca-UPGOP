<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function alumno()
    {
        return $this->belongsTo(Alumno::class);
    }

    public function libro()
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
        return $this->estado === self::ACTIVO;
    }

    public function estaDevuelto(): bool
    {
        return $this->estado === self::DEVUELTO;
    }

    public function estaVencido(): bool
    {
        return $this->estado === self::ACTIVO
            && now()->greaterThan($this->fecha_devolucion_esperada);
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