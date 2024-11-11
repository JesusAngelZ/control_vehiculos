<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kilometraje extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_auto',
        'id_solicitud',
        'kilometraje_inicial',
        'kilometraje_salida',
    ];
}
