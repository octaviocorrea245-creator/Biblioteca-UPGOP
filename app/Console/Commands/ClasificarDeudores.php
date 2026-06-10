<?php

namespace App\Console\Commands;

use App\Models\Alumno;
use App\Models\Prestamo;
use Illuminate\Console\Command;
use Carbon\Carbon;

class ClasificarDeudores extends Command
{
    protected $signature   = 'biblioteca:clasificar-deudores';
    protected $description = 'Clasifica alumnos como Deudores o Rezagados según sus préstamos vencidos';

    public function handle()
    {
        $hoy = Carbon::today();

        // Marcar como Vencido todos los préstamos Activos cuya fecha esperada ya pasó
        $vencidos = Prestamo::where('estado', 'Activo')
            ->where('fecha_devolucion_esperada', '<', $hoy)
            ->with('alumno')
            ->get();

        $deudores  = 0;
        $rezagados = 0;

        foreach ($vencidos as $prestamo) {
            // Marcar préstamo como Vencido
            $prestamo->update(['estado' => 'Vencido']);

            $alumno = $prestamo->alumno;

            if (!$alumno) continue;

            if ($alumno->estado === 'Activo') {
                $alumno->update(['estado' => 'Deudor']);
                $deudores++;
            } elseif ($alumno->estado === 'Deudor') {
                $alumno->update(['estado' => 'Rezagado']);
                $rezagados++;
            }
        }

        $this->info("Clasificación completada: {$deudores} deudores nuevos, {$rezagados} rezagados nuevos. Total préstamos vencidos: {$vencidos->count()}");
    }
}