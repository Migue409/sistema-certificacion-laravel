<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reserva extends Model
{
    use HasFactory;

    protected $table = 'reservas'; // Nombre de la tabla

    protected $fillable = [
        'id_usuario', // Clave foránea a usuarios
        'id_cita', // Clave foránea a citas
        'estatus', // Estatus de la reserva
    ];

    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario', 'id_usuario');
    }

    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }


    public function actividad()
    {
        return $this->belongsTo(Actividad::class, 'id_actividad', 'id_actividad');
    }

    public function asistencia()
    {
        return $this->hasOne(Asistencia::class, 'id_cita', 'id_cita'); // 'id_cita' en Asistencia debe coincidir con el 'id_cita' en Reserva
    }
    
}
