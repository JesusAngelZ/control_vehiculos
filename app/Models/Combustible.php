<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Combustible extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_auto',
        'id_solicitud',
        'combustible_inicial',
        'combustible_salida',
    ];
}
