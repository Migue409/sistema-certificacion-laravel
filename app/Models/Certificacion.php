<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificacion extends Model
{
    use HasFactory;

    protected $table = 'certificacion'; // Define el nombre de la tabla
    protected $primaryKey = 'id';

    // Habilitar timestamps
    public $timestamps = true;

    protected $fillable = [
        'id_usuario', // Relación con la tabla usuarios
        'nombre',
        'matricula',
        'correo',
        'division',
        'grupo_ingles',
        'nivel_in',
        'certificado',
        'puntaje',
        'estatus',
    ];

    // Definir la relación inversa con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}