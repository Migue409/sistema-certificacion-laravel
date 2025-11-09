<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class UsuarioFactory extends Factory
{
    public function definition(): array
    {
        return [
            'matricula' => '25' . $this->faker->numerify('#######'), // Ejemplo: 25XXXXXXXX
            'nombre' => $this->faker->name(),
            'curp' => strtoupper($this->faker->bothify('????######??????##')), // CURP aleatorio
            'correo' => $this->faker->unique()->safeEmail(),
            'id_rol' => 2, // Asumiendo 2 = Estudiante.
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
