<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DatosAcademicos extends Model
{
    use HasFactory;

    protected $table = 'datos_academicos'; // Define el nombre de la tabla
    protected $primaryKey = 'id';

    // Habilitar timestamps
    public $timestamps = true;

    protected $fillable = [
        'id_usuario', // Relación con la tabla usuarios
        'nivel',
        'recurse',
        'division',
        'grupo_division',
        'grupo_ingles',
    ];

    // Definir la relación inversa con el modelo Usuario
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }
}