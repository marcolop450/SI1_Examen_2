<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_llegada')->nullable();
            $table->time('hora_salida')->nullable();
            $table->enum('estado', ['A tiempo', 'Tardanza', 'Falta'])->default('A tiempo');
            $table->text('observaciones')->nullable();
            $table->boolean('justificada')->default(false);
            
            // Foreign Keys
            $table->integer('id_docente')->unsigned();
            $table->foreignId('id_horario')->constrained('horarios')->onDelete('cascade');
            
            $table->foreign('id_docente')->references('registro')->on('docentes')->onDelete('cascade');
            
            // Índices para optimizar consultas
            $table->index(['fecha', 'id_docente']);
            $table->index(['id_horario', 'fecha']);
            $table->index('estado');
            
            // Constraint único: un docente solo puede registrar una asistencia por horario y fecha
            $table->unique(['id_docente', 'id_horario', 'fecha'], 'uq_asistencia_docente_horario_fecha');
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};