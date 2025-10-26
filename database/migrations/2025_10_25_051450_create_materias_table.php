<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100)->unique();
            $table->string('codigo', 20)->unique();
            $table->text('contenido')->nullable();
            $table->integer('semestre')->unsigned();
            $table->integer('horas_teoricas')->default(0);
            $table->integer('horas_practicas')->default(0);
            $table->integer('creditos')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
        
        //Constraint para validar semestre entre 1 y 10
        DB::statement('ALTER TABLE materias ADD CONSTRAINT check_semestre CHECK (semestre BETWEEN 1 AND 10)');
    }

    public function down(): void
    {
        Schema::dropIfExists('materias');
    }
};