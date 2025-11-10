<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->boolean('es_electiva')->default(false)->after('activo');
            $table->integer('horas_semanales')->default(270)->after('es_electiva')->comment('En minutos: 270min=4h30min, 180min=3h');
            $table->integer('dias_semana')->default(2)->after('horas_semanales')->comment('Cuántos días a la semana se dicta (2 o 3)');
        });
    }

    public function down(): void
    {
        Schema::table('materias', function (Blueprint $table) {
            $table->dropColumn(['es_electiva', 'horas_semanales', 'dias_semana']);
        });
    }
};