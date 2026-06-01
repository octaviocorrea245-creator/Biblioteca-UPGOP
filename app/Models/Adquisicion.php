<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Adquisicion extends Model
{
    use HasFactory;

    protected $table = 'adquisiciones';

    protected $fillable = [
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

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }
}