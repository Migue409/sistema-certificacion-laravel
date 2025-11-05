<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario'); // ID del usuario
            $table->string('matricula')->unique(); // Matricula única
            $table->string('nombre'); // Nombre del usuario
            $table->string('curp')->unique(); // CURP único
            $table->string('correo')->unique(); // Correo Electrónico único
            $table->unsignedBigInteger('id_rol'); // ID del rol
            $table->timestamps(); // Crea las columnas created_at y updated_at

            // Clave foránea si es necesario
            $table->foreign('id_rol')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}