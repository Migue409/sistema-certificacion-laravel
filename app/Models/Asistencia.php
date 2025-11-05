<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    use HasFactory;

    protected $table = 'asistencias';  // Asegúrate de que coincida con el nombre de la tabla
    protected $fillable = [
        'id_usuario',  // Clave foránea a la tabla de usuarios
        'id_cita',     // Clave foránea a la tabla de citas
        'asistencia',  // Asistencia o inasistencia
    ];

    // Definir relación con la tabla de usuarios
    public function usuario()
    {
        return $this->belongsTo(Usuario::class, 'id_usuario');
    }

    // Relación con la tabla de citas
    public function cita()
    {
        return $this->belongsTo(Cita::class, 'id_cita');
    }

    public function reserva()
    {
        return $this->belongsTo(Reserva::class, 'id_cita', 'id_cita'); // 'id_cita' en Asistencia debe coincidir con el 'id_cita' en Reserva
    }
}
