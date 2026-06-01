<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('reposiciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestamo_id')->constrained('prestamos')->onDelete('restrict');
            $table->foreignId('alumno_id')->constrained('alumnos')->onDelete('restrict');
            $table->foreignId('libro_id')->constrained('libros')->onDelete('restrict');
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->enum('tipo', ['Perdida', 'Daño']);
            $table->decimal('monto', 10, 2);
            $table->enum('estado_pago', ['Pendiente', 'Pagado'])->default('Pendiente');
            $table->date('fecha_reporte');
            $table->date('fecha_pago')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reposicions');
    }
};
