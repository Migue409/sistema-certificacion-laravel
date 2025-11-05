<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TeamTask extends Model
{
    use HasFactory;

    protected $table = 'teamtask'; // Nombre de la tabla

    protected $primaryKey = 'id'; // Clave primaria

    protected $fillable = [
        'matricula',
        'nombre',
        'apellidoP',
        'apellidoM',
        'telefono',
        'division',
        'correo',
        'requisitos',
        'cuatrimestre'
    ];

    // Si utilizas timestamps
    public $timestamps = false;

    protected $dates = ['fecha'];
}
