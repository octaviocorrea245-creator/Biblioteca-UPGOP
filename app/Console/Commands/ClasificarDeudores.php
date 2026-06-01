<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use App\Models\Prestamo;
use Illuminate\Console\Command;

class ClasificarDeudores extends Command
{
    protected $signature   = 'biblioteca:clasificar-deudores';
    protected $description = 'Clasifica alumnos como Deudores o Rezagados según sus préstamos vencidos';

    public function handle()
    {
        // Préstamos activos cuya fecha esperada ya pasó
        $prestamosVencidos = Prestamo::where('estado', 'Activo')
            ->where('fecha_devolucion_esperada', '<', now())
            ->with('alumno')
            ->get();

        $deudores  = 0;
        $rezagados = 0;

        foreach ($prestamosVencidos as $prestamo) {
            $alumno = $prestamo->alumno;

            // Marcar préstamo como Vencido
            $prestamo->update(['estado' => 'Vencido']);

            if ($alumno->estado === 'Activo') {
                $alumno->update(['estado' => 'Deudor']);
                $deudores++;
            } elseif ($alumno->estado === 'Deudor') {
                $alumno->update(['estado' => 'Rezagado']);
                $rezagados++;
            }
        }

        $this->info("Clasificación completada: $deudores deudores nuevos, $rezagados rezagados nuevos.");
    }
}