<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB; // Asegúrate de importar DB

class CreateNivelesTable extends Migration
{
    public function up()
    {
        Schema::create('niveles', function (Blueprint $table) {
            $table->id('id_nivel');
            $table->string('nivel', 50);
            $table->timestamps();
        });

        // Insertar registros predeterminados
        DB::table('niveles')->insert([
            ['nivel' => 'Elementary'],
            ['nivel' => 'Pre-Intermediate']
        ]);
    }

    public function down()
    {
        Schema::dropIfExists('niveles');
    }
}