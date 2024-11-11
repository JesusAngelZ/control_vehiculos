<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Solicitud_utj extends Model
{
    use HasFactory;

    protected $fillable = [
        'fecha_solicitud',
        'fecha_salida',
        'fecha_regreso',
        'motivo',
        'oficio_comision',
        'estado_vehiculo',
        'estado_vehiculo_foto',
        'id_usuario',
        'id_auto',
    ];
}
