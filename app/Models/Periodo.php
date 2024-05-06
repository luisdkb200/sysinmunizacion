<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periodo extends Model
{
    use HasFactory;
    protected $table = 'periodo';
    protected $primaryKey = 'cod_periodo';
    public $timestamps = false;
    protected $fillable = ['cod_vacuna', 'mes', 'anio', 'saldo', 'entrada','salida','cod_establecimiento'];
    protected $guarded = [];
}
