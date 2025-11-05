<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsistenciasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asistencias', function (Blueprint $table) {
            $table->id(); // Crea la columna 'id' (clave primaria)
            
            // Definimos la clave foránea a la tabla 'usuarios'
            $table->foreignId('id_usuario') 
                  ->constrained('usuarios', 'id_usuario') // Hace referencia a la columna 'id_usuario' en la tabla 'usuarios'
                  ->onDelete('cascade'); // Elimina la asistencia si el usuario es eliminado

            // Definimos la clave foránea a la tabla 'citas'
            $table->foreignId('id_cita') 
                  ->constrained('citas', 'id') // Hace referencia a la columna 'id' en la tabla 'citas'
                  ->onDelete('cascade'); // Elimina la asistencia si la cita es eliminada

            // Columna de asistencia: 1 para asistencia, 0 para inasistencia
            $table->tinyInteger('asistencia')->default(0);
            
            // Timestamps para 'created_at' y 'updated_at'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asistencias'); // Elimina la tabla 'asistencias' si se revierte la migración
    }
}
