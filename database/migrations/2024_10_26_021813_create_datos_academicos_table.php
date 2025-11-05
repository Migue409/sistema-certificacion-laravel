<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDatosAcademicosTable extends Migration
{
    public function up()
    {
        Schema::create('datos_academicos', function (Blueprint $table) {
            $table->id(); // ID del registro
            $table->unsignedBigInteger('id_usuario'); // ID del usuario
            $table->string('nivel', 50);
            $table->boolean('recurse')->default(false);
            $table->string('division', 100);
            $table->string('grupo_division', 10);
            $table->string('grupo_ingles', 10);
            $table->timestamps();

            // Clave foránea a la tabla usuarios
            $table->foreign('id_usuario')->references('id_usuario')->on('usuarios')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('datos_academicos');
    }
}