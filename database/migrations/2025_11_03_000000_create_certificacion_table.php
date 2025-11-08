<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Crear tabla certificaciones
     */
    public function up(): void
    {
        Schema::create('certificacion', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 255);
            $table->string('matricula', 20)->unique();
            $table->string('correo', 255);
            $table->string('division', 100);
            $table->string('grupo_ingles', 50);
            $table->string('nivel_in', 50);
            $table->string('certificado', 50);
            $table->string('puntaje',255);
            $table->string('archivo_pdf')->nullable();
            $table->enum('estatus', ['Pendiente', 'Acreditado', 'No acreditado'])->default('Pendiente');
            $table->timestamps(); // created_at y updated_at
        });

        $table->foreignId('id_usuario')->constrained('usuarios')->onDelete('cascade');
    }

    /**
     * Eliminar tabla (rollback)
     */
    public function down(): void
    {
        Schema::dropIfExists('certificacion');
    }
};
