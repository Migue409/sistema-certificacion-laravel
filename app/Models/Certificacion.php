<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    use HasFactory;

    // Especificar el nombre correcto de la tabla
    protected $table = 'certificacion';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'id_usuario',
        'nombre',
        'matricula',
        'correo',
        'division',
        'grupo_ingles',
        'nivel_in',
        'certificado',
        'archivo',
        'puntaje',
        'estatus',
    ];
}
