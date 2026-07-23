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
        $hoy = Carbon::today();

        // Marcar como Vencido todos los préstamos Activos cuya fecha esperada ya pasó
        $prestamosVencidos = Prestamo::activos()
                ->where('fecha_devolucion_esperada', '<', now())
                ->with('alumno')
                ->get();
        $deudores  = 0;
        $rezagados = 0;

            foreach ($prestamosVencidos as $prestamo) {
            // Marcar préstamo como Vencido
            $prestamo->update(['estado' => Prestamo::VENCIDO]);
            
            $alumno = $prestamo->alumno;

            if (!$alumno) continue;

            if ($alumno->estado === Alumno::ACTIVO) {
                $alumno->update(['estado' => Alumno::DEUDOR]);
                $deudores++;
            } elseif ($alumno->estado === Alumno::DEUDOR) {
                $alumno->update(['estado' => Alumno::REZAGADO]);
                $rezagados++;
            }
        }

        $this->info("Clasificación completada: {$deudores} deudores nuevos, {$rezagados} rezagados nuevos. Total préstamos vencidos: {$prestamosVencidos->count()}");
    }
}