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
        Schema::create('donaciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->string('codigo_donacion')->unique();
            $table->string('titulo');
            $table->string('autor');
            $table->string('editorial');
            $table->string('codigo_barras')->nullable();
            $table->decimal('costo', 8, 2)->nullable();
            $table->date('fecha');
            $table->string('alumno_donante');
            $table->string('matricula_donante');
            $table->string('cuatrimestre');
            $table->year('generacion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donacions');
    }
};
