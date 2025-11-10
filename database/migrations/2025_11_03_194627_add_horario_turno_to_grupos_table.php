<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->time('hora_inicio_turno')->nullable()->after('turno')->comment('Hora de inicio del turno');
            $table->time('hora_fin_turno')->nullable()->after('hora_inicio_turno')->comment('Hora de fin del turno');
        });
    }

    public function down(): void
    {
        Schema::table('grupos', function (Blueprint $table) {
            $table->dropColumn(['hora_inicio_turno', 'hora_fin_turno']);
        });
    }
};