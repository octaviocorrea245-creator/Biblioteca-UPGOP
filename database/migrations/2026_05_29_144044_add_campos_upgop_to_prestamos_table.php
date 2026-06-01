<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Columnas ya incluidas en create_libros_table, migración omitida
    }

    public function down(): void
    {
        Schema::table('prestamos', function (Blueprint $table) {
            $table->dropForeign(['carrera_id']);
            $table->dropColumn(['folio', 'carrera_id', 'cuatrimestre', 'anio', 'fecha_devolucion_esperada', 'fecha_devolucion_real', 'observaciones']);
        });
    }
};