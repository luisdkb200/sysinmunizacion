<?php

namespace App\Exports;

use App\Models\Vacuna;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class VacunasSheets implements WithMultipleSheets
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $year;

    private $f1;
    private $fontFamily;
    public function __construct($f1)
    {
        $this->f1 = $f1;
        //  $this->f2 = $f2;
        //  $this->f3 = $f3;

        $this->fontFamily = 'Arial Narrow';
    }
    /**
     * @return array
     */
    public function sheets(): array
    {
        $sheets = [];
        $vacunas = Vacuna::all();


        foreach ($vacunas as $v) {
            $cod_vacuna = $v->cod_vacuna; // Use a suitable name based on your Vacuna model

            $sheets[] = new GeneralReport($this->f1, $cod_vacuna);
        }

        return $sheets;
    }
}
