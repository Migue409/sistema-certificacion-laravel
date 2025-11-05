<?php

namespace Database\Seeders;

use App\Models\Usuario;
use Illuminate\Database\Seeder;
use Database\Seeders\RolesTableSeeder; // Importa el seeder de roles

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Llama al seeder de roles
        $this->call(RolesTableSeeder::class);
        $this->call(AdminUserSeeder::class); // Llama al seeder del administrador
    }
}