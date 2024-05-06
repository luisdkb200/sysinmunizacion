<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Jeringa extends Model
{
    use HasFactory;
    protected $table = 'jeringa';
    protected $primaryKey = 'cod_jeringa';
    public $timestamps = false;

    protected $fillable = [
        'descripcion',
    ];
}
