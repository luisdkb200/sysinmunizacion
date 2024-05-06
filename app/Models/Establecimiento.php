<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Establecimiento extends Model
{
    use HasFactory;
    protected $table = 'establecimiento';
    protected $primaryKey = 'cod_establecimiento';
    public $timestamps = false;

    protected $fillable = [
        'nombre_est',     
        'codigo_est',    
        'cod_microred',    
        'cod_acopio',               
    ];
}
