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
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->string('codigo')->unique();
            $table->enum('tipo', ['Regular', 'Donado', 'Adquirido']);
            $table->string('titulo');
            $table->string('autor');
            $table->string('editorial');
            $table->string('codigo_barras')->nullable();
            $table->string('localizacion')->nullable();
            $table->integer('cantidad_total')->default(1);
            $table->integer('cantidad_disponible')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('libros');
    }
};
