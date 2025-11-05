<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cita extends Model
{
    use HasFactory;

    protected $table = 'citas'; // Nombre de la tabla

    protected $fillable = [
        'id_actividad', // Clave foránea a actividades
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad');
    }


    public function reservas()
    {
        return $this->hasMany(Reserva::class, 'id_cita', 'id');
    }

    // En el modelo Cita
    public function asistencias()
    {
        return $this->hasMany(Asistencia::class, 'id_cita');
    }
}
