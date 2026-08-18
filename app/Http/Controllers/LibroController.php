<?php

namespace App\Http\Controllers;

use App\Models\Libro;
use App\Models\Carrera;
use Illuminate\Http\Request;
use App\Http\Requests\StoreLibroRequest;
use App\Http\Requests\UpdateLibroRequest;

class LibroController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $query = Libro::with('carrera');

        if ($request->filled('buscar')) {
            $query->buscar($request->buscar);
        }

        $libros = $query->paginate(10)->withQueryString();
        return view('libros.index', compact('libros'));
    }

    public function create()
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.create', compact('carreras'));
    }

    public function store(StoreLibroRequest $request)
    {
        Libro::create($request->validated());
        return redirect()->route('libros.index')->with('success', 'Libro registrado correctamente.');
    }

    public function edit(Libro $libro)
    {
        $carreras = Carrera::where('activa', true)->get();
        return view('libros.edit', compact('libro', 'carreras'));
    }

    public function update(UpdateLibroRequest $request, Libro $libro)
    {
        $libro->update($request->validated());
        return redirect()->route('libros.index')->with('success', 'Libro actualizado correctamente.');
    }

    public function destroy(Libro $libro)
    {
        // Verificar si el libro tiene préstamos asociados
        if ($libro->prestamos()->exists()) {
            return redirect()->route('libros.index')
                ->with('error', 'No se puede eliminar el libro "' . $libro->titulo . '" porque tiene préstamos registrados. Devuelve o cancela los préstamos primero.');
        }

        $libro->delete();
        return redirect()->route('libros.index')->with('success', 'Libro eliminado correctamente.');
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
        $hoja->setTitle('Libros');

        // Orden exacto que lee el importador (fila[0]..fila[8])
        $encabezados = [
            'clave_carrera',   // fila[0]
            'cantidad',        // fila[1]
            'titulo',          // fila[2]
            'localizacion',    // fila[3]
            'autor',           // fila[4]
            'editorial',       // fila[5]
            'observacion',     // fila[6]
            'codigo_barras',   // fila[7]
            'proveedor',       // fila[8]
        ];
        $hoja->fromArray($encabezados, null, 'A1');

        // Fila de ejemplo
        $hoja->fromArray([
            'IAEV', 2, 'Cálculo Diferencial', 'Estante A1',
            'James Stewart', 'Cengage', '', '7501234567890', 'Editorial Mc',
        ], null, 'A2');

        // Estilo encabezado: fondo navy, texto blanco, negrita
        $styleHead = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D1B35']],
            'alignment' => ['horizontal' => 'center'],
            'borders'   => ['bottom' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF1A56B0']]],
        ];
        $hoja->getStyle('A1:I1')->applyFromArray($styleHead);

        // Fila ejemplo en gris claro
        $hoja->getStyle('A2:I2')->applyFromArray([
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFF0F4FA']],
            'font' => ['italic' => true, 'color' => ['argb' => 'FF8496B0']],
        ]);

        // Hoja de instrucciones
        $info = $spreadsheet->createSheet();
        $info->setTitle('Instrucciones');
        $info->setCellValue('A1', 'INSTRUCCIONES — Plantilla de Carga Masiva de Libros');
        $info->setCellValue('A3', 'Columna');
        $info->setCellValue('B3', 'Campo');
        $info->setCellValue('C3', 'Descripción');
        $info->setCellValue('D3', '¿Obligatorio?');
        $filas = [
            ['A', 'clave_carrera', 'Clave de la carrera (ej: IAEV, LNI, LMAD). Si no existe se crea automáticamente.', 'No'],
            ['B', 'cantidad', 'Número de ejemplares del libro. Si se omite, se asume 1.', 'No'],
            ['C', 'titulo', 'Título completo del libro.', 'SÍ'],
            ['D', 'localizacion', 'Estante o lugar físico (ej: Estante A1, Bodega 3).', 'No'],
            ['E', 'autor', 'Nombre del autor o autores.', 'No'],
            ['F', 'editorial', 'Editorial del libro.', 'No'],
            ['G', 'observacion', 'Notas internas, estado del libro, etc.', 'No'],
            ['H', 'codigo_barras', 'Código de barras físico. Si está vacío se genera uno interno.', 'No'],
            ['I', 'proveedor', 'Proveedor o fuente de adquisición.', 'No'],
        ];
        $row = 4;
        foreach ($filas as $f) {
            $info->setCellValue("A{$row}", $f[0]);
            $info->setCellValue("B{$row}", $f[1]);
            $info->setCellValue("C{$row}", $f[2]);
            $info->setCellValue("D{$row}", $f[3]);
            $row++;
        }
        $info->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 12]]);
        $info->getStyle('A3:D3')->applyFromArray(['font' => ['bold' => true]]);
        foreach (['A','B','C','D'] as $col) { $info->getColumnDimension($col)->setAutoSize(true); }

        $spreadsheet->setActiveSheetIndex(0);
        foreach (range('A', 'I') as $col) { $hoja->getColumnDimension($col)->setAutoSize(true); }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $ruta = storage_path('app/plantilla_libros.xlsx');
        $writer->save($ruta);

        return response()->download($ruta, 'plantilla_libros.xlsx')->deleteFileAfterSend(true);
    }

    public function plantillaDonaciones()
    {
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $hoja = $spreadsheet->getActiveSheet();
        $hoja->setTitle('Donaciones');

        // Orden exacto que lee importarDonaciones (fila[0]..fila[7])
        $encabezados = [
            'clave_carrera',  // fila[0]
            'cantidad',       // fila[1]
            'titulo',         // fila[2]
            'localizacion',   // fila[3]
            'autor',          // fila[4]
            'editorial',      // fila[5]
            'observacion',    // fila[6]
            'codigo_barras',  // fila[7]
        ];
        $hoja->fromArray($encabezados, null, 'A1');

        // Fila de ejemplo
        $hoja->fromArray([
            'LNI', 1, 'Legislación Mexicana de Comercio', 'Estante B2',
            'González Pérez', 'Porrúa', '', '7509876543210',
        ], null, 'A2');

        // Estilo encabezado
        $styleHead = [
            'font'      => ['bold' => true, 'color' => ['argb' => 'FFFFFFFF']],
            'fill'      => ['fillType' => 'solid', 'startColor' => ['argb' => 'FF0D1B35']],
            'alignment' => ['horizontal' => 'center'],
            'borders'   => ['bottom' => ['borderStyle' => 'thin', 'color' => ['argb' => 'FF7D3C98']]],
        ];
        $hoja->getStyle('A1:H1')->applyFromArray($styleHead);

        $hoja->getStyle('A2:H2')->applyFromArray([
            'fill' => ['fillType' => 'solid', 'startColor' => ['argb' => 'FFF4ECF7']],
            'font' => ['italic' => true, 'color' => ['argb' => 'FF7D3C98']],
        ]);

        // Hoja de instrucciones
        $info = $spreadsheet->createSheet();
        $info->setTitle('Instrucciones');
        $info->setCellValue('A1', 'INSTRUCCIONES — Plantilla de Importación de Donaciones');
        $info->setCellValue('A3', 'Columna');
        $info->setCellValue('B3', 'Campo');
        $info->setCellValue('C3', 'Descripción');
        $info->setCellValue('D3', '¿Obligatorio?');
        $filas = [
            ['A', 'clave_carrera', 'Clave de la carrera (ej: LNI, IAEV). Si no existe se crea automáticamente.', 'No'],
            ['B', 'cantidad', 'Número de ejemplares donados. Si se omite, se asume 1.', 'No'],
            ['C', 'titulo', 'Título completo del libro donado.', 'SÍ'],
            ['D', 'localizacion', 'Lugar físico donde se colocará el libro.', 'No'],
            ['E', 'autor', 'Nombre del autor o autores.', 'No'],
            ['F', 'editorial', 'Editorial del libro.', 'No'],
            ['G', 'observacion', 'Notas adicionales sobre la donación.', 'No'],
            ['H', 'codigo_barras', 'Código de barras del libro. Si está vacío se genera uno interno (DON-SIN-CB-...).', 'No'],
        ];
        $row = 4;
        foreach ($filas as $f) {
            $info->setCellValue("A{$row}", $f[0]);
            $info->setCellValue("B{$row}", $f[1]);
            $info->setCellValue("C{$row}", $f[2]);
            $info->setCellValue("D{$row}", $f[3]);
            $row++;
        }
        $info->getStyle('A1')->applyFromArray(['font' => ['bold' => true, 'size' => 12]]);
        $info->getStyle('A3:D3')->applyFromArray(['font' => ['bold' => true]]);
        foreach (['A','B','C','D'] as $col) { $info->getColumnDimension($col)->setAutoSize(true); }

        $spreadsheet->setActiveSheetIndex(0);
        foreach (range('A', 'H') as $col) { $hoja->getColumnDimension($col)->setAutoSize(true); }

        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
        $ruta = storage_path('app/plantilla_donaciones.xlsx');
        $writer->save($ruta);

        return response()->download($ruta, 'plantilla_donaciones.xlsx')->deleteFileAfterSend(true);
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
    public function listarHojas(\Illuminate\Http\Request $request)
{
    $request->validate([
        'archivo' => 'required|file|mimes:xlsx,xls,csv',
    ]);

    try {
        $archivo = $request->file('archivo');
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($archivo->getPathname());
        $hojas = array_map(fn($sheet) => $sheet->getTitle(), $spreadsheet->getAllSheets());
        return response()->json(['hojas' => $hojas]);
    } catch (\Exception $e) {
        return response()->json(['error' => 'No se pudo leer el archivo: ' . $e->getMessage()], 422);
    }
}

public function importarDonacionesForm()
{
    return view('libros.importar_donaciones');
}

public function importarDonaciones(\Illuminate\Http\Request $request)
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
            return back()->withErrors(['hoja' => "No se encontró la hoja '{$request->hoja}'."]);
        }
    } else {
        $hoja = $spreadsheet->getActiveSheet();
    }

    $filas = $hoja->toArray();
    array_shift($filas);

    $insertados = 0;
    $omitidos   = 0;
    $errores    = [];
    $carrerasCreadas = [];

    foreach ($filas as $i => $fila) {
        $claveCarrera = \Illuminate\Support\Str::limit(strip_tags(trim($fila[0] ?? '')), 50, '');
        $cantidad     = $fila[1] ?? 1;
        $titulo       = \Illuminate\Support\Str::limit(strip_tags(trim($fila[2] ?? '')), 255, '');
        $localizacion = \Illuminate\Support\Str::limit(strip_tags(trim($fila[3] ?? '')), 100, '');
        $autor        = \Illuminate\Support\Str::limit(strip_tags(trim($fila[4] ?? '')), 255, '');
        $editorial    = \Illuminate\Support\Str::limit(strip_tags(trim($fila[5] ?? '')), 255, '');
        $codigoBarras = \Illuminate\Support\Str::limit(strip_tags(trim($fila[7] ?? '')), 100, '');

        if (empty($titulo)) continue;

        if (empty($codigoBarras) || strtoupper($codigoBarras) === 'S/C') {
            $codigoBarras = 'DON-SIN-CB-' . str_pad($i + 2, 5, '0', STR_PAD_LEFT);
        }

        if (\App\Models\Libro::where('codigo_barras', $codigoBarras)->exists()) {
            $omitidos++;
            continue;
        }

        $carrera_id = null;
        if (!empty($claveCarrera)) {
            $carrera = \App\Models\Carrera::where('clave', $claveCarrera)->first();
            if (!$carrera) {
                $carrera = \App\Models\Carrera::create([
                    'clave'  => $claveCarrera,
                    'nombre' => $claveCarrera,
                    'activa' => true,
                ]);
                $carrerasCreadas[] = $claveCarrera;
            }
            $carrera_id = $carrera->id;
        }

        try {
            \DB::transaction(function() use (
                $carrera_id, $codigoBarras, $titulo, $autor,
                $editorial, $localizacion, $cantidad
            ) {
                \App\Models\Libro::create([
                    'carrera_id'          => $carrera_id,
                    'codigo'              => 'DON-' . $codigoBarras,
                    'tipo'                => 'Donado',
                    'titulo'              => $titulo,
                    'autor'               => $autor ?: 'Sin autor',
                    'editorial'           => $editorial ?: 'Sin editorial',
                    'codigo_barras'       => $codigoBarras,
                    'localizacion'        => $localizacion ?: null,
                    'cantidad_total'      => is_numeric($cantidad) ? (int)$cantidad : 1,
                    'cantidad_disponible' => is_numeric($cantidad) ? (int)$cantidad : 1,
                ]);

                $codigoDonacion = \App\Models\Donacion::generarCodigo(date('Y'));
                \App\Models\Donacion::create([
                    'carrera_id'        => $carrera_id,
                    'codigo_donacion'   => $codigoDonacion,
                    'titulo'            => $titulo,
                    'autor'             => $autor ?: 'Sin autor',
                    'editorial'         => $editorial ?: 'Sin editorial',
                    'codigo_barras'     => $codigoBarras,
                    'costo'             => null,
                    'fecha'             => now()->toDateString(),
                    'alumno_donante'    => 'Donación institucional',
                    'matricula_donante' => 'N/A',
                    'cuatrimestre'      => date('Y') . '-1',
                    'generacion'        => date('Y'),
                ]);
            });
            $insertados++;
        } catch (\Exception $e) {
            $errores[] = "Fila " . ($i + 2) . ": " . $e->getMessage();
        }
    }

    $mensaje = "$insertados libros donados importados correctamente.";
    if ($omitidos > 0) $mensaje .= " $omitidos omitidos por código duplicado.";
    if (count($carrerasCreadas) > 0) $mensaje .= " Carreras creadas: " . implode(', ', array_unique($carrerasCreadas)) . ".";
    if (count($errores) > 0) $mensaje .= " " . count($errores) . " filas con error.";

    return redirect()->route('donaciones.index')->with('success', $mensaje);
}

public function importarDonacionesAntiguas(\Illuminate\Http\Request $request)
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
            return back()->withErrors(['hoja' => "No se encontró la hoja '{$request->hoja}'."]);
        }
    } else {
        $hoja = $spreadsheet->getActiveSheet();
    }

    $filas = $hoja->toArray();
    array_shift($filas);
    array_shift($filas);

    $insertados = 0;
    $omitidos   = 0;
    $errores    = [];

    foreach ($filas as $i => $fila) {
        $titulo       = \Illuminate\Support\Str::limit(strip_tags(trim($fila[1] ?? '')), 255, '');
        $autor        = \Illuminate\Support\Str::limit(strip_tags(trim($fila[2] ?? '')), 255, '');
        $editorial    = \Illuminate\Support\Str::limit(strip_tags(trim($fila[3] ?? '')), 255, '');
        $localizacion = \Illuminate\Support\Str::limit(strip_tags(trim($fila[4] ?? '')), 100, '');

        if (empty($titulo)) continue;

        $codigoBarras = 'DON-ANT-' . str_pad($i + 3, 5, '0', STR_PAD_LEFT);

        if (\App\Models\Libro::where('codigo_barras', $codigoBarras)->exists()) {
            $omitidos++;
            continue;
        }

        // El formato antiguo no incluye carrera ni cantidad — se usan valores por defecto
        $carrera_id = null;
        $cantidad   = 1;

        try {
            \DB::transaction(function() use (
                $carrera_id, $codigoBarras, $titulo, $autor,
                $editorial, $localizacion, $cantidad
            ) {
                \App\Models\Libro::create([
                    'carrera_id'          => $carrera_id,
                    'codigo'              => 'DON-' . $codigoBarras,
                    'tipo'                => 'Donado',
                    'titulo'              => $titulo,
                    'autor'               => $autor ?: 'Sin autor',
                    'editorial'           => $editorial ?: 'Sin editorial',
                    'codigo_barras'       => $codigoBarras,
                    'localizacion'        => $localizacion ?: null,
                    'cantidad_total'      => $cantidad,
                    'cantidad_disponible' => $cantidad,
                ]);

                $codigoDonacion = \App\Models\Donacion::generarCodigo(date('Y'));
                \App\Models\Donacion::create([
                    'carrera_id'        => $carrera_id,
                    'codigo_donacion'   => $codigoDonacion,
                    'titulo'            => $titulo,
                    'autor'             => $autor ?: 'Sin autor',
                    'editorial'         => $editorial ?: 'Sin editorial',
                    'codigo_barras'     => $codigoBarras,
                    'costo'             => null,
                    'fecha'             => now()->toDateString(),
                    'alumno_donante'    => 'Donación institucional',
                    'matricula_donante' => 'N/A',
                    'cuatrimestre'      => date('Y') . '-1',
                    'generacion'        => date('Y'),
                ]);
            });
            $insertados++;
        } catch (\Exception $e) {
            $errores[] = "Fila " . ($i + 3) . ": " . $e->getMessage();
        }
    }

    $mensaje = "$insertados libros donados antiguos importados correctamente.";
    if ($omitidos > 0) $mensaje .= " $omitidos omitidos.";
    if (count($errores) > 0) $mensaje .= " " . count($errores) . " filas con error.";

    return redirect()->route('donaciones.index')->with('success', $mensaje);
}
}