<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class DatosAcademicosFactory extends Factory
{
    protected $model = \App\Models\DatosAcademicos::class;

    public function definition(): array
    {
        return [
            'id_usuario' => 1, 
            'nivel' => 'Pre-intermediate',
            'recurse' => 'No',
            'division' => 'DTIC',
            'grupo_division' => '1DSM2',
            'grupo_ingles' => '1IN33',
           
        ];
    }
}
