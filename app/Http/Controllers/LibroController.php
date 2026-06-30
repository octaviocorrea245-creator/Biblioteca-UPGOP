<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Libro::with('carrera');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                ->orWhere('autor', 'like', "%{$buscar}%")
                ->orWhere('codigo', 'like', "%{$buscar}%")
                ->orWhere('codigo_barras', 'like', "%{$buscar}%")
                ->orWhere('editorial', 'like', "%{$buscar}%");
            });
        }

        $libros = $query->paginate(10)->withQueryString();
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros',
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string|max:255',
            'autor'               => 'required|string|max:255',
            'editorial'           => 'required|string|max:255',
            'codigo_barras'       => 'nullable|string|max:100',
            'localizacion'        => 'nullable|string|max:100',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'costo'               => 'nullable|numeric|min:0',
        ]);

        Libro::create($validated);
        return redirect()->route('libros.index')->with('success', 'Libro registrado correctamente.');
    }

    public function edit(Libro $libro)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.edit', compact('libro', 'carreras'));
    }

    public function update(Request $request, Libro $libro)
    {
        $validated = $request->validate([
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros,codigo,' . $libro->id,
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string|max:255',
            'autor'               => 'required|string|max:255',
            'editorial'           => 'required|string|max:255',
            'codigo_barras'       => 'nullable|string|max:100',
            'localizacion'        => 'nullable|string|max:100',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'costo'               => 'nullable|numeric|min:0',
        ]);

        $libro->update($validated);
        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        $libro->delete();
        return redirect()->route('libros.index')->with('success', 'Libro eliminado.');
    }

    public function importarForm()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.importar', compact('carreras'));
    }

    public function importar(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'archivo' => 'required|mimes:xlsx,xls,csv',
            'hoja'    => 'nullable|string',
        ]);

        $archivo = $request->file('archivo');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo->getPathname());

        if ($request->hoja) {
            $hoja = $spreadsheet->getSheetByName($request->hoja);
            if (!$hoja) {
                return back()->withErrors(['hoja' => "No se encontró la hoja '{$request->hoja}' en el archivo."]);
            }
        } else {
            $hoja = $spreadsheet->getActiveSheet();
        }

        $filas = $hoja->toArray();
        array_shift($filas); // quitar encabezados

        $insertados = 0;
        $omitidos   = 0;
        $errores    = [];
        $carrerasCreadas = [];

        foreach ($filas as $i => $fila) {
            // Columnas reales: CARRERA, CANT, TITULO, LOC, AUTOR, EDITORIAL, OBSERV., CODIGO_BARRAS, PROVEEDOR
            $claveCarrera   = \Illuminate\Support\Str::limit(strip_tags(trim($fila[0] ?? '')), 50, '');
            $cantidad       = $fila[1] ?? 1;
            $titulo         = \Illuminate\Support\Str::limit(strip_tags(trim($fila[2] ?? '')), 255, '');
            $localizacion   = \Illuminate\Support\Str::limit(strip_tags(trim($fila[3] ?? '')), 100, '');
            $autor          = \Illuminate\Support\Str::limit(strip_tags(trim($fila[4] ?? '')), 255, '');
            $editorial      = \Illuminate\Support\Str::limit(strip_tags(trim($fila[5] ?? '')), 255, '');
            $observacion    = \Illuminate\Support\Str::limit(strip_tags(trim($fila[6] ?? '')), 255, '');
            $codigoBarras   = \Illuminate\Support\Str::limit(strip_tags(trim($fila[7] ?? '')), 100, '');
            $proveedor      = \Illuminate\Support\Str::limit(strip_tags(trim($fila[8] ?? '')), 255, '');

            // Saltar filas vacías o sin título
            // Saltar solo si no hay título (fila realmente vacía)
            if (empty($titulo)) {
                continue;
            }

            // Si no tiene código de barras, generamos uno interno temporal
            if (empty($codigoBarras)) {
                $codigoBarras = 'SIN-CB-' . str_pad($i + 2, 5, '0', STR_PAD_LEFT);
            }

            // Evitar duplicados por código de barras
            if (\App\Models\Libro::where('codigo_barras', $codigoBarras)->exists()) {
                $omitidos++;
                continue;
            }

            // Buscar o crear la carrera según la clave del Excel
            $carrera_id = null;
            if (!empty($claveCarrera)) {
                $carrera = \App\Models\Carrera::where('clave', $claveCarrera)->first();

                if (!$carrera) {
                    $carrera = \App\Models\Carrera::create([
                        'clave'  => $claveCarrera,
                        'nombre' => $claveCarrera, // se puede editar después desde el módulo de Carreras
                        'activa' => true,
                    ]);
                    $carrerasCreadas[] = $claveCarrera;
                }

                $carrera_id = $carrera->id;
            }

            try {
                \App\Models\Libro::create([
                    'carrera_id'          => $carrera_id,
                    'codigo'              => 'LIB-' . $codigoBarras,
                    'tipo'                => 'Regular',
                    'titulo'              => $titulo,
                    'autor'               => $autor ?: 'Sin autor',
                    'editorial'           => $editorial ?: 'Sin editorial',
                    'codigo_barras'       => $codigoBarras,
                    'localizacion'        => $localizacion ?: null,
                    'cantidad_total'      => is_numeric($cantidad) ? $cantidad : 1,
                    'cantidad_disponible' => is_numeric($cantidad) ? $cantidad : 1,
                ]);
                $insertados++;
            } catch (\Exception $e) {
                $errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
            }
        }

        $mensaje = "$insertados libros importados correctamente.";
        if ($omitidos > 0) {
            $mensaje .= " $omitidos omitidos por código de barras duplicado.";
        }
        if (count($carrerasCreadas) > 0) {
            $mensaje .= " Carreras creadas automáticamente: " . implode(', ', array_unique($carrerasCreadas)) . ".";
        }
        if (count($errores) > 0) {
            $mensaje .= " " . count($errores) . " filas con error.";
        }
        \Log::info('Importación de libros - Detalle', [
            'insertados' => $insertados,
            'omitidos_duplicados' => $omitidos,
            'errores' => $errores,
            'carreras_creadas' => $carrerasCreadas,
        ]);

        return redirect()->route('libros.index')->with('success', $mensaje);
    }
    public function plantilla()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();

        $encabezados = ['codigo_barras', 'tipo', 'titulo', 'autor', 'editorial', 'localizacion', 'cantidad_total', 'cantidad_disponible', 'costo'];
        $hoja->fromArray($encabezados, null, 'A1');

        $hoja->fromArray(['7501234567890', 'Regular', 'Cálculo Diferencial', 'James Stewart', 'Cengage', 'Estante A1', 3, 3, 450.00], null, 'A2');

        foreach (range('A', 'I') as $col) {
            $hoja->getColumnDimension($col)->setAutoSize(true);
        }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $nombreArchivo = "plantilla_libros.xlsx";
        $rutaTemp = storage_path("app/{$nombreArchivo}");
        $writer->save($rutaTemp);

        return response()->download($rutaTemp)->deleteFileAfterSend(true);
    }
    public function pendientesCodigoBarras(\Illuminate\Http\Request $request)
    {
        $query = Libro::with('carrera')->where('codigo_barras', 'like', 'SIN-CB-%');

        if ($request->filled('buscar')) {
            $buscar = $request->buscar;
            $query->where(function($q) use ($buscar) {
                $q->where('titulo', 'like', "%{$buscar}%")
                ->orWhere('autor', 'like', "%{$buscar}%");
            });
        }

        $libros = $query->paginate(10)->withQueryString();
        return view('libros.pendientes', compact('libros'));
    }

    public function actualizarCodigoBarras(\Illuminate\Http\Request $request, Libro $libro)
    {
        $request->validate([
            'codigo_barras' => 'required|string|unique:libros,codigo_barras,' . $libro->id,
        ]);

        $libro->update([
            'codigo_barras' => $request->codigo_barras,
        ]);

        return redirect()->route('libros.pendientes')->with('success', "Código de barras actualizado para '{$libro->titulo}'.");
    }
    public function buscarPorCodigoBarras(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'codigo_barras' => 'required|string|max:100',
        ]);

        $libro = Libro::where('codigo_barras', trim($request->codigo_barras))
            ->where('cantidad_disponible', '>', 0)
            ->first();

        if (!$libro) {
            return response()->json(['encontrado' => false]);
        }

        return response()->json([
            'encontrado' => true,
            'id'         => $libro->id,
            'titulo'     => $libro->titulo,
            'codigo'     => $libro->codigo,
            'disponible' => $libro->cantidad_disponible,
        ]);
    }
}