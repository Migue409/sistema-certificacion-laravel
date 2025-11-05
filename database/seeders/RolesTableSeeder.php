<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
{
    $roles = [
        ['rol' => 'administrador', 'descripcion' => 'Usuario con privilegios administrativos'],
        ['rol' => 'estudiante', 'descripcion' => 'Usuario que asiste a actividades'],
        ['rol' => 'profesor', 'descripcion' => 'Usuario encargado de enseñar'],
    ];

    foreach ($roles as $role) {
        // Verifica si el rol ya existe
        if (!DB::table('roles')->where('rol', $role['rol'])->exists()) {
            DB::table('roles')->insert($role);
        }
    }   
}
}
