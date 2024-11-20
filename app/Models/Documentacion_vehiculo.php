<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Documentacion_vehiculo extends Model
{
    use HasFactory;


    protected $fillable = [
        'tarjeta_circulacion',
        'poliza_seguro',
        'id_auto',
    ];
}

