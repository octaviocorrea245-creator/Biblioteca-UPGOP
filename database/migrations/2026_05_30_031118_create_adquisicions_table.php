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
        Schema::create('adquisiciones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('carrera_id')->constrained('carreras')->onDelete('restrict');
            $table->integer('cantidad');
            $table->string('titulo');
            $table->string('autor');
            $table->string('editorial');
            $table->string('localizacion')->nullable();
            $table->text('observacion')->nullable();
            $table->string('codigo_barras')->nullable();
            $table->string('proveedor');
            $table->string('factura');
            $table->date('fecha_factura');
            $table->decimal('costo', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('adquisicions');
    }
};
