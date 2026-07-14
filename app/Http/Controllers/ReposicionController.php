<?php

namespace App\Http\Controllers;

use App\Models\Reposicion;
use App\Models\Prestamo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\StoreReposicionRequest;


class ReposicionController extends Controller
{
    public function index()
    {
        $reposiciones = Reposicion::with(['alumno', 'libro', 'carrera'])->paginate(10);
        return view('reposiciones.index', compact('reposiciones'));
    }

    public function create()
    {
        // Solo préstamos activos o vencidos
        $prestamos = Prestamo::with(['alumno', 'libro', 'carrera'])
            ->whereIn('estado', ['Activo', 'Vencido'])
            ->get();
        return view('reposiciones.create', compact('prestamos'));
    }

   public function store(StoreReposicionRequest $request)
    {
        $validated = $request->validated();
        $prestamo = Prestamo::with(['alumno', 'libro', 'carrera'])->find($validated['prestamo_id']);

        Reposicion::create([
            'prestamo_id'   => $prestamo->id,
            'alumno_id'     => $prestamo->alumno_id,
            'libro_id'      => $prestamo->libro_id,
            'carrera_id'    => $prestamo->carrera_id,
            'tipo'          => $validated['tipo'],
            'monto'         => $validated['monto'],
            'estado_pago'   => 'Pendiente',
            'fecha_reporte' => $validated['fecha_reporte'],
            'observaciones' => $validated['observaciones'] ?? null,
        ]);

        if (strtolower(trim($prestamo->estado)) === 'activo') {
            $prestamo->update(['estado' => 'Vencido']);
        }

        return redirect()->route('reposiciones.index')->with('success', 'Reposición registrada correctamente.');
    }

    public function registrarPago(Reposicion $reposicion)
    {
        $reposicion->update([
            'estado_pago' => 'Pagado',
            'fecha_pago'  => now(),
        ]);

        // Si el alumno era Deudor o Rezagado, vuelve a Activo
        $estadoAlumno = strtolower(trim($reposicion->alumno->estado));
        if (in_array($estadoAlumno, ['deudor', 'rezagado'])) {
            $reposicion->alumno->update(['estado' => 'Activo']);
        }

        return redirect()->route('reposiciones.index')->with('success', 'Pago registrado correctamente.');
    }

    public function comprobante(Reposicion $reposicion)
    {
        $pdf = Pdf::loadView('reposiciones.comprobante', compact('reposicion'));
        return $pdf->stream("comprobante_reposicion_{$reposicion->id}.pdf");
    }

    public function importar(Request $request)
    {
        $request->validate([
            'xml_file' => 'required|file|mimes:xml,txt|max:2048',
        ]);

        $content = file_get_contents($request->file('xml_file')->getRealPath());

        // Protección XXE: deshabilitar la carga de entidades externas antes de parsear
        $previousSetting = libxml_disable_entity_loader(true);
        libxml_use_internal_errors(true);

        // LIBXML_NONET evita que el parser intente hacer peticiones de red
        // No se usa LIBXML_NOENT para no expandir entidades manualmente
        $xml = simplexml_load_string($content, 'SimpleXMLElement', LIBXML_NONET);

        libxml_disable_entity_loader($previousSetting);
        libxml_clear_errors();

        if (!$xml) {
            return redirect()->route('reposiciones.index')
                ->with('error', 'El archivo XML no es válido.');
        }

        $items = [];
        if (isset($xml->reposicion)) {
            $items = $xml->reposicion;
        } elseif ($xml->getName() === 'reposicion') {
            $items = [$xml];
        } elseif ($xml->children()) {
            $items = $xml->children();
        }

        $created = 0;
        $errors = [];

        foreach ($items as $index => $item) {
            $data = [
                'prestamo_id'   => trim((string) ($item->prestamo_id ?? '')),
                'tipo'          => trim((string) ($item->tipo ?? '')),
                'monto'         => trim((string) ($item->monto ?? '')),
                'fecha_reporte' => trim((string) ($item->fecha_reporte ?? '')),
                'observaciones' => \Illuminate\Support\Str::limit(strip_tags(trim((string) ($item->observaciones ?? ''))), 500, ''),
            ];

            $validator = Validator::make($data, [
                'prestamo_id'   => 'required|integer|exists:prestamos,id',
                'tipo'          => 'required|in:Perdida,Daño',
                'monto'         => 'required|numeric|min:0',
                'fecha_reporte' => 'required|date',
                'observaciones' => 'nullable|string|max:500',
            ]);

            if ($validator->fails()) {
                $errors[] = 'Fila ' . ($index + 1) . ': ' . implode('; ', $validator->errors()->all());
                continue;
            }

            $validated = $validator->validated();

            $prestamo = Prestamo::with(['alumno', 'libro', 'carrera'])->find($validated['prestamo_id']);
            if (!$prestamo) {
                $errors[] = "Fila " . ($index + 1) . ": El préstamo {$validated['prestamo_id']} no existe.";
                continue;
            }

            $duplicate = Reposicion::where('prestamo_id', $prestamo->id)->exists();
            if ($duplicate) {
                $errors[] = "Fila " . ($index + 1) . ": Ya existe una reposición para el préstamo {$prestamo->id}.";
                continue;
            }

            Reposicion::create([
                'prestamo_id'   => $prestamo->id,
                'alumno_id'     => $prestamo->alumno_id,
                'libro_id'      => $prestamo->libro_id,
                'carrera_id'    => $prestamo->carrera_id,
                'tipo'          => $validated['tipo'],
                'monto'         => $validated['monto'],
                'estado_pago'   => 'Pendiente',
                'fecha_reporte' => $validated['fecha_reporte'],
                'observaciones' => $validated['observaciones'] ?: null,
            ]);

            if (strtolower(trim($prestamo->estado)) === 'activo') {
                $prestamo->update(['estado' => 'Vencido']);
            }

            $created++;
        }

        $message = "Se importaron {$created} reposiciones.";
        if (count($errors)) {
            $message .= ' Algunos registros no se guardaron: ' . implode(' | ', $errors);
        }

        return redirect()->route('reposiciones.index')->with('success', $message);
    }

    public function destroy(Reposicion $reposicion)
    {
        try {
            $reposicion->delete();
            return redirect()->route('reposiciones.index')->with('success', 'Reposición eliminada.');
        } catch (\Exception $e) {
            return redirect()->route('reposiciones.index')->with('error', 'No se pudo eliminar: ' . $e->getMessage());
        }
    }
}