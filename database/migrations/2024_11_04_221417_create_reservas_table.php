<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservasTable extends Migration
{
    public function up()
    {
        Schema::create('reservas', function (Blueprint $table) {
            $table->id(); // ID de la reserva
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade'); // Clave foránea a usuarios
            $table->foreignId('id_cita')->constrained('citas', 'id')->onDelete('cascade'); // Clave foránea a citas
            $table->string('estatus'); // Estatus de la reserva
            $table->timestamps(); // Crea las columnas created_at y updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('reservas');
    }
}