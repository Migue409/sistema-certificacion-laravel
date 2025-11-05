<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        if (!Schema::hasTable('actividades')) {
            Schema::create('actividades', function (Blueprint $table) {
                $table->id('id_actividad');
                $table->string('actividad', 255);
                $table->foreignId('id_nivel')->constrained('niveles', 'id_nivel');
                $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario');
                $table->dateTime('fecha');
                $table->integer('cupo');
                $table->integer('cupo_disponible');
                $table->string('salon', 100)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades'); // Eliminar la tabla actividades si se revierte la migración
    }
};
