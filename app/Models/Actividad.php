<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades'; // Nombre de la tabla

    protected $primaryKey = 'id_actividad'; // Clave primaria

    protected $fillable = [
        'actividad',
        'id_nivel',
        'fecha',
        'cupo',
        'cupo_disponible',
        'id_usuario',
        'salon',
    ];

    // Si utilizas timestamps
    public $timestamps = true;

    protected $dates = ['fecha'];

    // Relación con el modelo Nivel (opcional)
    public function nivel()
    {
        return $this->belongsTo(Nivel::class, 'id_nivel');
    }
}