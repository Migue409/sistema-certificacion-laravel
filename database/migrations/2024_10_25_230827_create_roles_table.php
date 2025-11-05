<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('rol')->unique();
            $table->string('descripcion')->nullable();
            $table->timestamps();
        });

        DB::table('roles')->insert([
            ['rol' => '1', 'descripcion' => 'Administrador'],
            ['rol' => '2', 'descripcion' => 'Alumno'],
            ['rol' => '3', 'descripcion' => 'Profesor']
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
    }
};
