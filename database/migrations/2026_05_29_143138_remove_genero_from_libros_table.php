<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Columna genero ya no existe en la tabla, migración omitida
    }

    public function down(): void
    {
        Schema::table('libros', function (Blueprint $table) {
            $table->string('genero')->nullable();
        });
    }
};