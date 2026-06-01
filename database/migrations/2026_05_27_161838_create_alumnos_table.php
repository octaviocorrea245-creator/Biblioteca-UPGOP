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
        Schema::create('alumnos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->string('nombre');
            $table->string('matricula')->unique();
            $table->enum('genero', ['M', 'F', 'Otro']);
            $table->integer('cuatrimestre');
            $table->enum('turno', ['M', 'V', 'N']);
            $table->year('generacion');
            $table->enum('estado', ['Activo', 'Deudor', 'Rezagado'])->default('Activo');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumnos');
    }
};
