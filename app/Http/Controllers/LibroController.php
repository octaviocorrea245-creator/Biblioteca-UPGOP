<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;

class LibroController extends Controller
{
    public function index()
    {
        $libros = Libro::with('carrera')->paginate(10);
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.create', compact('carreras'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros',
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string',
            'autor'               => 'required|string',
            'editorial'           => 'required|string',
            'codigo_barras'       => 'nullable|string',
            'localizacion'        => 'nullable|string',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'costo'               => 'nullable|numeric|min:0',
        ]);

        Libro::create($request->all());
        return redirect()->route('libros.index')->with('success', 'Libro registrado correctamente.');
    }

    public function edit(Libro $libro)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.edit', compact('libro', 'carreras'));
    }

    public function update(Request $request, Libro $libro)
    {
        $request->validate([
            'carrera_id'          => 'nullable|exists:carreras,id',
            'codigo'              => 'required|string|unique:libros,codigo,' . $libro->id,
            'tipo'                => 'required|in:Regular,Donado,Adquirido',
            'titulo'              => 'required|string',
            'autor'               => 'required|string',
            'editorial'           => 'required|string',
            'codigo_barras'       => 'nullable|string',
            'localizacion'        => 'nullable|string',
            'cantidad_total'      => 'required|integer|min:1',
            'cantidad_disponible' => 'required|integer|min:0',
            'costo'               => 'nullable|numeric|min:0',
        ]);

        $libro->update($request->all());
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
            'archivo'    => 'required|mimes:xlsx,xls,csv',
            'carrera_id' => 'nullable|exists:carreras,id',
        ]);

        $archivo = $request->file('archivo');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo->getPathname());
        $hoja = $spreadsheet->getActiveSheet();
        $filas = $hoja->toArray();

        array_shift($filas);

        $insertados = 0;
        $errores = [];

        foreach ($filas as $i => $fila) {
            // Columnas: codigo_barras, tipo, titulo, autor, editorial, localizacion, cantidad_total, cantidad_disponible, costo
            if (empty($fila[0]) || empty($fila[2])) {
                continue;
            }

            $codigoBarras = trim($fila[0]);

            if (\App\Models\Libro::where('codigo_barras', $codigoBarras)->exists()) {
                $errores[] = "Fila " . ($i + 2) . ": código de barras {$codigoBarras} ya existe, omitido.";
                continue;
            }

            try {
                \App\Models\Libro::create([
                    'carrera_id'          => $request->carrera_id ?: null,
                    'codigo'              => 'LIB-' . $codigoBarras,
                    'tipo'                => in_array($fila[1], ['Regular', 'Donado', 'Adquirido']) ? $fila[1] : 'Regular',
                    'titulo'              => $fila[2],
                    'autor'               => $fila[3] ?? 'Sin autor',
                    'editorial'           => $fila[4] ?? 'Sin editorial',
                    'codigo_barras'       => $codigoBarras,
                    'localizacion'        => $fila[5] ?? null,
                    'cantidad_total'      => $fila[6] ?? 1,
                    'cantidad_disponible' => $fila[7] ?? ($fila[6] ?? 1),
                    'costo'               => $fila[8] ?? null,
                ]);
                $insertados++;
            } catch (\Exception $e) {
                $errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
            }
        }

        $mensaje = "$insertados libros importados correctamente.";
        if (count($errores) > 0) {
            $mensaje .= " " . count($errores) . " filas con observaciones.";
        }

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
}