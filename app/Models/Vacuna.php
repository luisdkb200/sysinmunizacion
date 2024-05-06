<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna extends Model
{
    use HasFactory;
    protected $table = 'vacuna';
    protected $primaryKey = 'cod_vacuna';
    public $timestamps = false;

    protected $fillable = [
        'nombre',     
        'sigla',  
        'num_dosis',   
        'estado',              
    ];
}
