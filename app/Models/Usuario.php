<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Usuario extends Authenticatable
{
    use HasFactory;

    // Definir la tabla correspondiente si no sigue la convención
    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    // Habilitar timestamps
    public $timestamps = true;

    // Definir los campos que se pueden llenar
    protected $fillable = [
        'matricula',
        'nombre',
        'curp',
        'id_rol',
        'correo'
    ];

    // Definir la relación con la tabla datos_academicos
    public function datosAcademicos()
    {
        return $this->hasOne(DatosAcademicos::class, 'id_usuario', 'id_usuario');
    }

    public function asistencia()
    {
        return $this->hasOne(Asistencia::class, 'id_usuario', 'id_usuario');
    }

    
}