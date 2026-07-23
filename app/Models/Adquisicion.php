<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Adquisicion extends Model
{
    use HasFactory;

    protected $table = 'adquisiciones';

    protected $fillable = [
        'codigo_adquisicion',
        'carrera_id',
        'cantidad',
        'titulo',
        'autor',
        'editorial',
        'localizacion',
        'observacion',
        'codigo_barras',
        'proveedor',
        'factura',
        'fecha_factura',
        'costo',
    ];

    protected $casts = [
        'fecha_factura' => 'date',
        'costo'         => 'decimal:2',
    ];

    public function carrera(): BelongsTo
    {
        return $this->belongsTo(Carrera::class);
    }
    public static function generarCodigo(int $anio): string
    {
        $ultimo = self::where('codigo_adquisicion', 'like', "A-{$anio}-%")->max('id');
        $consecutivo = str_pad(($ultimo ? $ultimo + 1 : 1), 3, '0', STR_PAD_LEFT);
        return "A-{$anio}-{$consecutivo}";
    }
}