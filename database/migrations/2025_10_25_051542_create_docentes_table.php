<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docentes', function (Blueprint $table) {
            $table->integer('registro')->primary();
            $table->string('carrera', 100)->nullable();
            $table->date('fecha_ingreso');
            $table->string('especialidad', 100)->nullable();
            $table->integer('carga_horaria_maxima')->default(80);
            $table->integer('carga_horaria_actual')->default(0);
            $table->boolean('activo')->default(true);
            $table->foreignId('id_usuario')->unique()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docentes');
    }
};