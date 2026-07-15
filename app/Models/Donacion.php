<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Donacion extends Model
{
    use HasFactory;
    protected $table = 'donaciones';

    protected $fillable = [
        'carrera_id',
        'codigo_donacion',
        'titulo',
        'autor',
        'editorial',
        'codigo_barras',
        'costo',
        'fecha',
        'alumno_donante',
        'matricula_donante',
        'cuatrimestre',
        'generacion',
    ];

    protected $casts = [
        'fecha' => 'date',
        'costo' => 'decimal:2',
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }

    // Genera código automático D-[generacion]-[###]
    public static function generarCodigo($generacion): string
    {
        $ultimo = self::where('generacion', $generacion)->max('id');
        $consecutivo = str_pad(($ultimo ? $ultimo + 1 : 1), 3, '0', STR_PAD_LEFT);
        return "D-{$generacion}-{$consecutivo}";
    }
}