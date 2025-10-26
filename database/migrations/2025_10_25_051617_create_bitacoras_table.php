<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bitacoras', function (Blueprint $table) {
            $table->id();
            $table->string('accion', 100);
            $table->text('descripcion')->nullable();
            $table->string('tabla_afectada', 50)->nullable();
            $table->string('registro_afectado', 50)->nullable();
            $table->string('ip_direccion', 45)->nullable();
            $table->foreignId('id_usuario')->constrained('users')->onDelete('cascade');
            $table->timestamp('fecha')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('bitacoras');
    }
};