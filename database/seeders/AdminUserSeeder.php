<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        DB::table('usuarios')->insert([
            [
                'matricula' => '0241025987',
                'nombre' => 'Administrador',
                'curp' => 'ADMin12345?$',
                'id_rol' => 1,
                'created_at' => now(), // Asignar fecha de creación
                'updated_at' => now(), // Asignar fecha de actualización
            ],
        ]);
    }
}