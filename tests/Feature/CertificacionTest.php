<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Usuario;
use App\Models\Certificacion;
use App\Models\DatosAcademicos;
use App\Http\Controllers\CertificacionEstudianteController;
use App\Http\Controllers\CertificacionController;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CertificacionTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
public function un_estudiante_puede_registrar_un_certificado()
{
    // Crear usuario y guardarlo en base de datos
    $usuario = \App\Models\Usuario::factory()->create([
        'nombre' => 'Héctor Ariel Ortiz Villagomez',
        'matricula' => '2526220056',
        'correo' => '2526220056@e.uttecamac.edu.mx',
    ]);

    // Autenticar usuario
    $this->actingAs($usuario);

    // 🔧 Forzar el ID explícitamente en datos_academicos
    \App\Models\DatosAcademicos::create([
        'id' => $usuario->id,
        'id_usuario' => 1,
        'nivel' => 'Pre-Intermediate',
        'recurse' => false,
        'division' => 'DTIC',
        'grupo_division' => '1DSM2',
        'grupo_ingles' => '1IN33',
    ]);

    // Enviar la solicitud de registro del certificado
    $response = $this->post(route('certificacionEST.store'), [
        'puntaje' => 95,
        'nivel_in' => 'B2',
        'certificado' => 'TOEFL (iBT)',
        'archivo' => \Illuminate\Http\UploadedFile::fake()->create('certificado.pdf', 100, 'application/pdf'),
    ]);


    // Verificar que se guardó el registro
    $this->assertDatabaseHas('certificacion', [
        'nivel_in' => 'B2',
        'puntaje' => '95',
        'estatus' => 'Pendiente',
    ]);
}

}