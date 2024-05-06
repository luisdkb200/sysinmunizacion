<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $primaryKey = 'idEmpresa';
    public $timestamps = false;
    protected $fillable = ['nomEmp', 'direcEmp', 'teleEmp', 'nroRucEmp', 'logoEmp'];
    protected $guarded = [];
}
