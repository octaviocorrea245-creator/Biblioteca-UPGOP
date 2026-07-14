<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarreraController;
use App\Http\Controllers\AlumnoController;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\DeudorController;
use App\Http\Controllers\DonacionController;
use App\Http\Controllers\AdquisicionController;
use App\Http\Controllers\ReporteController;
use App\Http\Controllers\ReposicionController;



Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalLibros'          => \App\Models\Libro::count(),
        'librosDisponibles'    => \App\Models\Libro::where('cantidad_disponible', '>', 0)->count(),
        'totalAlumnos'         => \App\Models\Alumno::count(),
        'alumnosActivos'       => \App\Models\Alumno::where('estado', 'Activo')->count(),
        'prestamosActivos'  => \App\Models\Prestamo::activos()->count(),      
        'prestamosVencidos' => \App\Models\Prestamo::vencidos()->count(),
        'deudores'             => \App\Models\Alumno::deudores()->count(),
        'rezagados'            => \App\Models\Alumno::rezagados()->count(),
        'donaciones'           => \App\Models\Donacion::count(),
        'adquisiciones'        => \App\Models\Adquisicion::count(),
        'reposicionesPend'     => \App\Models\Reposicion::where('estado_pago', 'Pendiente')->count(),
        'carreras'             => \App\Models\Carrera::where('activa', true)->count(),
        'proximosVencer'    => \App\Models\Prestamo::with(['alumno', 'libro'])
                            ->proximosAVencer(3)
                            ->orderBy('fecha_devolucion_esperada')
                            ->get(),
        'ultimosPrestamos'     => \App\Models\Prestamo::with(['alumno', 'libro'])
                                    ->latest()
                                    ->take(5)
                                    ->get(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('carreras', CarreraController::class);
Route::resource('alumnos', AlumnoController::class);
Route::get('libros/importar', [LibroController::class, 'importarForm'])->name('libros.importar.form');
Route::post('libros/importar', [LibroController::class, 'importar'])->name('libros.importar');
Route::get('libros/plantilla-excel', [LibroController::class, 'plantilla'])->name('libros.plantilla');
Route::get('libros/pendientes-codigo-barras', [LibroController::class, 'pendientesCodigoBarras'])->name('libros.pendientes');
Route::patch('libros/{libro}/actualizar-codigo-barras', [LibroController::class, 'actualizarCodigoBarras'])->name('libros.actualizarCodigoBarras');
Route::get('libros/buscar-por-codigo-barras', [LibroController::class, 'buscarPorCodigoBarras'])->name('libros.buscarPorCodigoBarras');
Route::get('libros/importar-donaciones', [LibroController::class, 'importarDonacionesForm'])->name('libros.importar.donaciones.form');
Route::post('libros/importar-donaciones', [LibroController::class, 'importarDonaciones'])->name('libros.importar.donaciones');
Route::post('libros/importar-donaciones-antiguas', [LibroController::class, 'importarDonacionesAntiguas'])->name('libros.importar.donaciones.antiguas');
Route::post('libros/listar-hojas', [LibroController::class, 'listarHojas'])->name('libros.listarHojas');
Route::resource('libros', LibroController::class);
Route::resource('prestamos', PrestamoController::class);
Route::patch('prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
Route::get('deudores', [DeudorController::class, 'index'])->name('deudores.index');
Route::resource('donaciones', DonacionController::class)->parameters([
    'donaciones' => 'donacion'
]);
Route::resource('adquisiciones', AdquisicionController::class)->parameters([
    'adquisiciones' => 'adquisicion'
]);

Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('reportes/prestamos-mensuales', [ReporteController::class, 'prestamensuales'])->name('reportes.prestamensuales');
Route::get('reportes/prestamos-cuatrimestrales', [ReporteController::class, 'prestamoscuatrimestrales'])->name('reportes.prestamoscuatrimestrales');
Route::get('reportes/deudores', [ReporteController::class, 'deudores'])->name('reportes.deudores');
Route::get('reportes/rezagados', [ReporteController::class, 'rezagados'])->name('reportes.rezagados');
Route::get('reportes/donaciones', [ReporteController::class, 'donaciones'])->name('reportes.donaciones');
Route::get('reportes/adquisiciones', [ReporteController::class, 'adquisiciones'])->name('reportes.adquisiciones');
Route::get('reportes/prestamos-mensuales-excel', [ReporteController::class, 'prestamosMensualesExcel'])->name('reportes.prestamensuales.excel');
Route::get('reportes/deudores-excel', [ReporteController::class, 'deudoresExcel'])->name('reportes.deudores.excel');
Route::get('reportes/rezagados-excel', [ReporteController::class, 'rezagadosExcel'])->name('reportes.rezagados.excel');
Route::get('reportes/donaciones-excel', [ReporteController::class, 'donacionesExcel'])->name('reportes.donaciones.excel');
Route::get('reportes/adquisiciones-excel', [ReporteController::class, 'adquisicionesExcel'])->name('reportes.adquisiciones.excel');

Route::resource('reposiciones', ReposicionController::class)->parameters([
    'reposiciones' => 'reposicion'
]);
Route::post('reposiciones/importar', [ReposicionController::class, 'importar'])->name('reposiciones.importar');
Route::patch('reposiciones/{reposicion}/pago', [ReposicionController::class, 'registrarPago'])->name('reposiciones.pago');
Route::get('reposiciones/{reposicion}/comprobante', [ReposicionController::class, 'comprobante'])->name('reposiciones.comprobante');

Route::get('prestamos/{prestamo}/vale', [PrestamoController::class, 'vale'])->name('prestamos.vale');


require __DIR__.'/auth.php';
