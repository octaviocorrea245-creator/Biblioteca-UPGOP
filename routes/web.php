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
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'totalLibros'          => \App\Models\Libro::count(),
        'librosDisponibles'    => \App\Models\Libro::where('cantidad_disponible', '>', 0)->count(),
        'totalAlumnos'         => \App\Models\Alumno::count(),
        'alumnosActivos'       => \App\Models\Alumno::where('estado', 'Activo')->count(),
        'prestamosActivos'     => \App\Models\Prestamo::where('estado', 'Activo')->count(),
        'prestamosVencidos'    => \App\Models\Prestamo::where('estado', 'Vencido')->count(),
        'deudores'             => \App\Models\Alumno::where('estado', 'Deudor')->count(),
        'rezagados'            => \App\Models\Alumno::where('estado', 'Rezagado')->count(),
        'donaciones'           => \App\Models\Donacion::count(),
        'adquisiciones'        => \App\Models\Adquisicion::count(),
        'reposicionesPend'     => \App\Models\Reposicion::where('estado_pago', 'Pendiente')->count(),
        'carreras'             => \App\Models\Carrera::where('activa', true)->count(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('carreras', CarreraController::class);
Route::resource('alumnos', AlumnoController::class);
Route::resource('libros', LibroController::class);
Route::resource('prestamos', PrestamoController::class);
Route::patch('prestamos/{prestamo}/devolver', [PrestamoController::class, 'devolver'])->name('prestamos.devolver');
Route::get('deudores', [DeudorController::class, 'index'])->name('deudores.index');
Route::resource('donaciones', DonacionController::class);
Route::resource('adquisiciones', AdquisicionController::class);

Route::get('reportes', [ReporteController::class, 'index'])->name('reportes.index');
Route::get('reportes/prestamos-mensuales', [ReporteController::class, 'prestamensuales'])->name('reportes.prestamensuales');
Route::get('reportes/prestamos-cuatrimestrales', [ReporteController::class, 'prestamoscuatrimestrales'])->name('reportes.prestamoscuatrimestrales');
Route::get('reportes/deudores', [ReporteController::class, 'deudores'])->name('reportes.deudores');
Route::get('reportes/rezagados', [ReporteController::class, 'rezagados'])->name('reportes.rezagados');
Route::get('reportes/donaciones', [ReporteController::class, 'donaciones'])->name('reportes.donaciones');
Route::get('reportes/adquisiciones', [ReporteController::class, 'adquisiciones'])->name('reportes.adquisiciones');

Route::resource('reposiciones', ReposicionController::class)->parameters([
    'reposiciones' => 'reposicion'
]);Route::patch('reposiciones/{reposicion}/pago', [ReposicionController::class, 'registrarPago'])->name('reposiciones.pago');
Route::get('reposiciones/{reposicion}/comprobante', [ReposicionController::class, 'comprobante'])->name('reposiciones.comprobante');

Route::get('prestamos/{prestamo}/vale', [PrestamoController::class, 'vale'])->name('prestamos.vale');


require __DIR__.'/auth.php';
