<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecurseEC extends Model
{
    use HasFactory;

    protected $table = 'recurseec'; // Nombre de la tabla

    protected $primaryKey = 'id'; // Clave primaria

    protected $fillable = [
        'correo',
        'matricula',
        'nombre',
        'apellidoP',
        'apellidoM',
        'telefono',
        'division',
        'grupoDivision',
        'grupoInglesReg',
        'grupoInglesRec',
        'nivel',
        'cuatrimestre',
    ];

    // Si utilizas timestamps
    public $timestamps = false;

    protected $dates = ['fecha'];
}
