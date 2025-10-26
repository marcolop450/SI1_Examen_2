<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('grupo_materias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_grupo')->constrained('grupos')->onDelete('cascade');
            $table->foreignId('id_materia')->constrained('materias')->onDelete('cascade');
            $table->string('gestion', 10);
            $table->boolean('activo')->default(true);
            $table->timestamps();
            
            $table->unique(['id_grupo', 'id_materia', 'gestion']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupo_materias');
    }
};