<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Poblacion extends Model
{
    use HasFactory;
    protected $table = 'poblacion';
    protected $primaryKey = 'cod_poblacion';
    public $timestamps = false;

    protected $fillable = [
        'cod_vacuna',
        'poblacion_asignada',
        'mes',
        'anio',
    ];
}
