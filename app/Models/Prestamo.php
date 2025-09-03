<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Prestamo extends Model
{
    use HasFactory;

    protected $fillable = [
        'usuario_id',
        'libro_id',
        'fecha_prestamo',
        'fecha_devolucion_esperada',
        'fecha_devolucion_real',
        'estado',
        'observaciones'
    ];

    protected $casts = [
        'fecha_prestamo' => 'date',
        'fecha_devolucion_esperada' => 'date',
        'fecha_devolucion_real' => 'date'
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class);
    }

    public function libro()
    {
        return $this->belongsTo(Libro::class);
    }

    public function estaVencido()
    {
        return $this->estado === 'activo' &&
               Carbon::parse($this->fecha_devolucion_esperada)->isPast();
    }

    public function diasRetraso()
    {
        if ($this->estado !== 'activo') {
            return 0;
        }

        $fechaLimite = Carbon::parse($this->fecha_devolucion_esperada);
        $fechaActual = Carbon::now();

        return $fechaLimite->isPast() ? $fechaLimite->diffInDays($fechaActual) : 0;
    }

    public function devolver($observaciones = null)
    {
        $this->fecha_devolucion_real = now()->toDateString();
        $this->estado = 'devuelto';
        if ($observaciones) {
            $this->observaciones = $observaciones;
        }
        $this->save();

        // Actualizar disponibilidad del libro
        $this->libro->actualizarDisponibilidad();
    }
}
