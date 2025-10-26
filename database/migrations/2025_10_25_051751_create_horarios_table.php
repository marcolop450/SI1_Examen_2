<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->id();
            $table->string('dia', 20);
            $table->time('hora_inicio');
            $table->time('hora_final');
            $table->string('gestion', 10);
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();
            $table->boolean('es_virtual')->default(false); 
            
            //Foreign Keys
            $table->integer('id_docente');
            $table->foreignId('id_materia')->constrained('materias')->onDelete('restrict');
            $table->foreignId('id_grupo')->constrained('grupos')->onDelete('restrict');
            $table->foreignId('id_aula')->nullable()->constrained('aulas')->onDelete('restrict'); // ← nullable para virtuales
            
            $table->foreign('id_docente')->references('registro')->on('docentes')->onDelete('restrict');
            
            $table->timestamps();
        });
        
        //Constraint para validar horas
        DB::statement('ALTER TABLE horarios ADD CONSTRAINT check_hora_valida CHECK (hora_inicio < hora_final)');
        
        //Constraints para evitar conflictos de horarios
        Schema::table('horarios', function (Blueprint $table) {
            $table->unique(['id_docente', 'dia', 'hora_inicio', 'gestion'], 'unique_docente_horario');
            $table->unique(['id_aula', 'dia', 'hora_inicio', 'gestion'], 'unique_aula_horario');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};