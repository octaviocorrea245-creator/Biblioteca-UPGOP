<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prestamo extends Model
{
    use HasFactory;

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
        'fecha_prestamo'            => 'date',
        'fecha_devolucion_esperada' => 'date',
        'fecha_devolucion_real'     => 'date',
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

    // Genera el siguiente folio para una carrera específica
    public static function siguienteFolio($carrera_id): int
    {
        $ultimo = self::where('carrera_id', $carrera_id)->max('folio');
        return $ultimo ? $ultimo + 1 : 1;
    }
}