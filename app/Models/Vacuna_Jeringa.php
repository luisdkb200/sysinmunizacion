<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vacuna_Jeringa extends Model
{
    use HasFactory;
    protected $table = 'vacuna_jeringa';
    protected $primaryKey = 'cod_vacuna_jeringa';
    public $timestamps = false;

    protected $fillable = [
        'cod_vacuna',     
        'cod_jeringa',                  
    ];
}
