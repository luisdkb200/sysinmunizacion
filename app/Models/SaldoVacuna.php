<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaldoVacuna extends Model
{
    use HasFactory;
    protected $table = 'saldo';
    protected $primaryKey = 'cod_saldo';
    public $timestamps = false;

    protected $fillable = [
        'cod_vacuna',
        'stock',
        'mes',
        'anio',
    ];
}
