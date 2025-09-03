<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LibroController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\PrestamoController;
use App\Http\Controllers\EstadisticaController;


Route::middleware('api')->group(function () {
    // Rutas para libros
    Route::apiResource('libros', LibroController::class);

    // Rutas para usuarios
    Route::apiResource('usuarios', UsuarioController::class);

    // Rutas para prestamos
    Route::apiResource('prestamos', PrestamoController::class);
    Route::put('prestamos/{id}/devolver', [PrestamoController::class, 'devolver']);

    // Rutas para estadisticas
    Route::prefix('estadisticas')->group(function () {
        Route::get('resumen', [EstadisticaController::class, 'resumen']);
        Route::get('libros-mas-prestados', [EstadisticaController::class, 'librosMasPrestados']);
        Route::get('usuarios-mas-activos', [EstadisticaController::class, 'usuariosMasActivos']);
        Route::get('prestamos-por-mes', [EstadisticaController::class, 'prestamosPorMes']);
        Route::get('generos-populares', [EstadisticaController::class, 'generosMasPopulares']);
    });
});

