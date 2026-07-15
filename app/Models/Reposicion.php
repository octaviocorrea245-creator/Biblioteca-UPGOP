<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Reposicion extends Model
{
    use HasFactory;

    protected $table = 'reposiciones';

    protected $fillable = [
        'prestamo_id',
        'alumno_id',
        'libro_id',
        'carrera_id',
        'tipo',
        'monto',
        'estado_pago',
        'fecha_reporte',
        'fecha_pago',
        'observaciones',
    ];

    protected $casts = [
        'fecha_reporte' => 'date',
        'fecha_pago'    => 'date',
        'monto'         => 'decimal:2',
    ];

    public function prestamo(): BelongsTo
    {
        return $this->belongsTo(Prestamo::class);
    }

    public function alumno(): BelongsTo
    {
        return $this->belongsTo(Alumno::class);
    }

    public function libro(): BelongsTo
    {
        return $this->belongsTo(Libro::class);
    }

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }
}