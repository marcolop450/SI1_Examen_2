<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('docente_materias', function (Blueprint $table) {
            $table->id();
            $table->integer('id_docente');
            $table->foreignId('id_materia')->constrained('materias')->onDelete('cascade');
            $table->boolean('puede_impartir')->default(true);
            $table->timestamp('fecha_asignacion')->useCurrent();
            
            $table->foreign('id_docente')->references('registro')->on('docentes')->onDelete('cascade');
            $table->unique(['id_docente', 'id_materia']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('docente_materias');
    }
};