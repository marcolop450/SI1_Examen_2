<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id();
            $table->date('fecha');
            $table->time('hora_llegada');
            $table->time('hora_salida')->nullable();
            $table->string('estado', 20);
            $table->string('metodo_registro', 20);
            $table->text('observaciones')->nullable();
            $table->boolean('justificada')->default(false);
            
            //Foreign Keys
            $table->integer('id_docente');
            $table->foreignId('id_horario')->constrained('horarios')->onDelete('cascade');
            
            $table->foreign('id_docente')->references('registro')->on('docentes')->onDelete('cascade');
            
            $table->timestamps();
        });
        
        //Constraints para validar estados y métodos
        DB::statement("ALTER TABLE asistencias ADD CONSTRAINT check_estado_valido CHECK (estado IN ('A tiempo', 'Tardanza', 'Falta'))");
        DB::statement("ALTER TABLE asistencias ADD CONSTRAINT check_metodo_valido CHECK (metodo_registro IN ('manual', 'qr'))");
    }

    public function down(): void
    {
        Schema::dropIfExists('asistencias');
    }
};