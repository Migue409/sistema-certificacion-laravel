<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Nivel extends Model
{
    use HasFactory;

    protected $table = 'niveles'; // Nombre de la tabla

    protected $primaryKey = 'id_nivel'; // Clave primaria

    protected $fillable = [
        'nivel',
    ];

    // Si utilizas timestamps
    public $timestamps = true;

    // Relación con el modelo Actividad (opcional)
    public function actividades()
    {
        return $this->hasMany(Actividad::class, 'id_nivel');
    }
}