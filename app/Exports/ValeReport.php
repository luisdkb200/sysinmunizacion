<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Maatwebsite\Excel\Concerns\WithGridlines;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Events\BeforeExport;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooterDrawing;
use PhpOffice\PhpSpreadsheet\Worksheet\HeaderFooter;
use Maatwebsite\Excel\Concerns\WithHeaderImage;

use Maatwebsite\Excel\Concerns\WithStyles;

class ValeReport implements FromView, ShouldAutoSize, WithEvents, WithDrawings, WithStyles
{

    /**
     * @return \Illuminate\Support\Collection
     */

    private $f1, $f2, $f3;
    private $fontFamily;
    public function __construct($f1, $f2, $f3)
    {
        $this->f1 = $f1;
        $this->f2 = $f2;
        $this->f3 = $f3;

        $this->fontFamily = 'Arial Narrow';
    }



    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logo');
        $drawing->setDescription('This is my logo');
        $drawing->setPath(public_path('/images/encabezado.png'));
        $drawing->setHeight(60);
        $drawing->setWidth(700);
        $drawing->setCoordinates('B1');

        $drawing->setOffsetX(200); // Alinear horizontalmente al centro
        $drawing->setOffsetY(0); // Alinear verticalmente al centro
        return $drawing;
    }

    public function registerEvents(): array
    {
        return [

            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->setShowGridlines(false);

                // $event->sheet->getDelegate()->getPageSetup()->setPrintArea('A1:M1');
                // // $event->sheet->getPageSetup()->setPrintArea('A1:M1');
                // $lastRow = $event->sheet->getHighestRow();

                // // Establecer el área de impresión vertical para incluir todos los datos
                // $printArea = 'A1:M' . $lastRow;


                // $event->sheet->getPageSetup()->setPrintArea($printArea);
                $event->sheet->getPageSetup()->setPaperSize(PageSetup::PAPERSIZE_A4); // Por ejemplo, A4
                $event->sheet->getPageSetup()->setFitToPage(true);

                $event->sheet->getPageSetup()->setFitToWidth(1);
                $event->sheet->getPageSetup()->setFitToHeight(0);


                // // Set the odd header
                // $event->sheet->getHeaderFooter()->setOddHeader('&C&H AQUI LA IMAGEN');


                // // Agregar pie de página
                // $event->sheet->getHeaderFooter()->setOddFooter('&CPagina &P de &N');
                // $sheet = $event->sheet->getDelegate();

                // Obtén la imagen que deseas usar




            },

        ];
    }




    public function view(): View
    {
        $id = $this->f1;
        $id1 = $this->f2;
        $id2 = $this->f3;

        $id = $id == '-1' ? '' : $id;

        $establecimiento = DB::table('establecimiento as e')
            ->join('acopio as a', 'e.cod_acopio', '=', 'a.cod_acopio')
            ->where('a.cod_acopio', $id)
            // ->select('e.nombre_est')
            ->get();



        // // Creamos nuestra tabla maestra
        // $tabla_maestra = array();

        // // Haces la consulta de tus establecimientos y haces un foreach
        // // $establecimiento = ['CWILSOLFT', 'INFINITY_SYSTEM'];

        // foreach ($establecimiento as $e) {


        //     // Tablas de ejemplo - Tienes que sacar con consultas por cada establecimiento 3xn
        //     // $tabla1 = array(
        //     //     array("Nº", "Biológicos", "Cantidad"),
        //     //     array("01", "BCG", self::getData($id, $id1, $id2, $e->cod_establecimiento)[1]),
        //     //     array("02", "HVB x Dosis Pediatrico", "0"),
        //     //     array("03", "HVB x 01 Dosis Adulto", "0"),
        //     //     array("04", "Pentavalente x Dosis", "0"),
        //     //     array("05", "Antipolio x 10 Dosis", "0"),
        //     //     array("06", "Neumococo", "0"),
        //     //     array("07", "Rotavirus", "0"),
        //     //     array("08", "Influenza Pediatrica", "0"),
        //     //     array("09", "DPT x 10 Dosis", "0"),
        //     //     array("10", "HIB", "0"),
        //     //     array("11", "SPR x 01 Dosis", "0"),
        //     //     array("12", "Antiamarilica x 1 Dosis", "0"),
        //     //     array("13", "SR x 10 Dosis", "0"),
        //     //     array("14", "Dt Adulto x 10 Dosis", "0"),
        //     //     array("15", "Dt Pediatrico x 10 Dosis", "0"),
        //     //     array("16", "Antipolio iny x 1 Dosis", "0"),
        //     //     array("17", "Influenza Adulto", "0"),
        //     //     array("18", "VPH", "0"),
        //     //     array("19", "Varicela", "0"),
        //     //     array("20", "DPTA", "0"),
        //     //     array("21", "SR MONODOSIS", "0"),
        //     //     array("22", "HEPATITIS A", "0"),
        //     //     array("23", "Otros", "0")
        //     // );
        //     $tabla1 = self::getData($id1, $id2, $e->cod_establecimiento);

        //     // 2xn
        //     $tabla2 = array(
        //         array("Jeringas", "Cantidad"),
        //         array("1cc c/a 27Gx1/2\"", "0"),
        //         array("1cc c/a 25Gx5/8\"", "0"),
        //         array("1cc c/a 25Gx1º", "0"),
        //         array("1cc c/a 21Gx11/2º", "0"),
        //         array("5cc c/a 21x1\"", "0")
        //     );

        //     // // 3xn
        //     // $tabla3 = array(
        //     //     array("Nº", "Biológicos", "Cantidad"),
        //     //     array("01", "BCG", "0"),
        //     //     array("02", "HVB x Dosis Pediatrico", "0"),
        //     //     array("03", "HVB x 01 Dosis Adulto", "0"),
        //     //     array("04", "Pentavalente x Dosis", "0"),
        //     //     array("05", "Antipolio x 10 Dosis", "0"),
        //     //     array("06", "Neumococo", "0"),
        //     //     array("07", "Rotavirus", "0"),
        //     //     array("08", "Influenza Pediatrica", "0"),
        //     //     array("09", "DPT x 10 Dosis", "0"),
        //     //     array("10", "HIB", "0"),
        //     //     array("11", "SPR x 01 Dosis", "0"),
        //     //     array("12", "Antiamarilica x 1 Dosis", "0"),
        //     //     array("13", "SR x 10 Dosis", "0"),
        //     //     array("14", "Dt Adulto x 10 Dosis", "0"),
        //     //     array("15", "Dt Pediatrico x 10 Dosis", "0"),
        //     //     array("16", "Antipolio iny x 1 Dosis", "0"),
        //     //     array("17", "Influenza Adulto", "0"),
        //     //     array("18", "VPH", "0"),
        //     //     array("19", "Varicela", "0"),
        //     //     array("20", "DPTA", "0"),
        //     //     array("21", "SR MONODOSIS", "0"),
        //     //     array("22", "HEPATITIS A", "0"),
        //     //     array("23", "Otros", "0")
        //     // );
        //     $tabla3 = self::getConsolidado($id1, $id2, $id);
        //     // 2xn
        //     $tabla4 = array(
        //         array("Jeringas", "Cantidad"),
        //         array("1cc c/a 27Gx1/2\"", "0"),
        //         array("1cc c/a 25Gx5/8\"", "0"),
        //         array("1cc c/a 25Gx1º", "0"),
        //         array("1cc c/a 21Gx11/2º", "0"),
        //         array("5cc c/a 21x1\"", "0")
        //     );



        //     // Obtenemos el nro de filas mayor de los array;
        //     $nroColumnas = 13;
        //     $nroFila = count($tabla1); // La cantidad de vacunas

        //     // Creamos nuestra matriz
        //     $matriz = array();

        //     // Hacemos un buble que recorra las filas (i) y columnas (j)
        //     for ($i = 0; $i < $nroFila; $i++) {
        //         for ($j = 0; $j < $nroColumnas; $j++) {
        //             // llenamos la matriz con valores predeterminados:
        //             if ($j <= 2) {
        //                 $val = $tabla1[$i][$j];
        //             } elseif ($j ==  4 || $j ==  5) {
        //                 $val = isset($tabla2[$i][$j == 4 ? 0 : 1]) ? $tabla2[$i][$j == 4 ? 0 : 1] : '';
        //             } elseif ($j >=  7 && $j <=  9) {
        //                 if ($j == 7) {
        //                     $auxj  = 0;
        //                 } elseif ($j == 8) {
        //                     $auxj  = 1;
        //                 } else {
        //                     $auxj  = 2;
        //                 }
        //                 $val = isset($tabla3[$i][$auxj]) ? $tabla3[$i][$auxj] : '';
        //             } elseif ($j == 11 || $j == 12) {
        //                 $val = isset($tabla4[$i][$j == 11 ? 0 : 1]) ? $tabla4[$i][$j == 11 ? 0 : 1] : '';
        //             } elseif ($j == 3 || $j == 6 || $j == 10) {
        //                 $val = "b"; // Para las columnas en blanco 
        //             } else {
        //                 $val = "";
        //             }
        //             $matriz[$i][$j] = $val;
        //         }
        //     }

        //     // Aqui pasamos los datos del establecimiento y de la matriz respectiva
        //     $tabla_maestra[] = ["establecimiento" => $e->nombre_est, "matriz" => $matriz];
        // }

        $tabla_maestra = array();
        $miArray = ['CONSOLIDADO'];

        // Opción 1: Usar el método merge()
        foreach ($establecimiento as $e) {

            array_push($miArray, $e->nombre_est);
        }
        // $tabla5 = self::getConsolidado($id1, $id2, $id);

        $printedConsolidado = false;
        $indices = array_keys($miArray);
        // $tabla1 = ($miArray[0] = 'CONSOLIDADO') ? self::getConsolidado($id1, $id2, $id)  : self::getData($id1, $id2,  $indices + 1);
        foreach ($indices as $indice) {

            // dd($indice);
            if ($indice % 2 === 0) {
                $valorActual = $miArray[$indice];
                $indiceSiguiente = $indice + 1;
                $valorSiguiente = isset($miArray[$indiceSiguiente]) ? $miArray[$indiceSiguiente] : null;


                // $tabla1 = ($valorActual = 'CONSOLIDADO') ? self::getConsolidado($id1, $id2, $id) : self::getData($id1, $id2, $valorActual);

                // Imprimir el "CONSOLIDADO" solo si aún no se ha impreso
                if ($valorActual === 'CONSOLIDADO' && !$printedConsolidado) {
                    $tabla1 = self::getConsolidado($id1, $id2, $id);
                    $suma = $tabla1[3][2] + $tabla1[4][2] + $tabla1[6][2] + $tabla1[8][2] * 16  + $tabla1[9][2] * 8  + $tabla1[14][2] * 8  + $tabla1[15][2] * 8  + $tabla1[17][2] + $tabla1[18][2] + $tabla1[20][2];
                    // dd($tabla1[1][2]+0);
                    // $tabla2 = array(
                    //     array("Jeringas", "Cantidad"),
                    //     array("1cc c/a 27Gx1/2\"", "" . $tabla1[1][2]),
                    //     array("1cc c/a 25Gx5/8\"", "" . ($tabla1[2][2] + $tabla1[11][2] + $tabla1[12][2] + $tabla1[13][2] + $tabla1[19][2] + $tabla1[21][2])),
                    //     array("1cc c/a 25Gx1º", "$suma"),
                    //     array("1cc c/a 21Gx11/2º", "0"),
                    //     array("5cc c/a 21x1\"", "" . ($tabla1[1][2] + $tabla1[11][2] + $tabla1[12][2] + $tabla1[13][2] + $tabla1[19][2] + $tabla1[21][2])),
                    //     array("             ", " "),
                    //     array("             ", " "),
                    //     array("", ""),

                    //     array("Observaciones:", "")

                    // );


                    $tabla2 = self::getJeringaConsolidado($id1, $id2, $id);
                    $complemento = array(
                        array("             ", " "),
                        array("             ", " "),
                        array("", ""),
                        array("Observaciones:", "")
                    );

                    $tabla2 = array_merge($tabla2, $complemento);
                    // dd($tabla1);
                    $printedConsolidado = true; // Actualizamos la variable para indicar que ya se imprimió
                } else {
                    $tabla1 = self::getData($id1, $id2, $valorActual);
                    $suma = $tabla1[3][2] + $tabla1[4][2] + $tabla1[6][2] + $tabla1[8][2] * 16  + $tabla1[9][2] * 8  + $tabla1[14][2] * 8  + $tabla1[15][2] * 8  + $tabla1[17][2] + $tabla1[18][2] + $tabla1[20][2];
                    // dd($tabla1[1][2] + 0);
                    // $tabla2 = array(
                    //     array("Jeringas", "Cantidad"),
                    //     array("1cc c/a 27Gx1/2\"", "" . $tabla1[1][2]),
                    //     array("1cc c/a 25Gx5/8\"", "" . ($tabla1[2][2] + $tabla1[11][2] + $tabla1[12][2] + $tabla1[13][2] + $tabla1[19][2] + $tabla1[21][2])),
                    //     array("1cc c/a 25Gx1º", "$suma"),
                    //     array("1cc c/a 21Gx11/2º", "0"),
                    //     array("5cc c/a 21x1\"", "" . ($tabla1[1][2] + $tabla1[11][2] + $tabla1[12][2] + $tabla1[13][2] + $tabla1[19][2] + $tabla1[21][2])),
                    //     array("             ", " "),
                    //     array("             ", " "),
                    //     array("", ""),

                    //     array("Observaciones:", "")
                    // );
                    $tabla2 = self::getJeringa($id1, $id2, $valorActual);

                    $complemento = array(
                        array("             ", " "),
                        array("             ", " "),
                        array("", ""),
                        array("Observaciones:", "")
                    );

                    $tabla2 = array_merge($tabla2, $complemento);
                    // dd($tabla1[1][2]*0);
                }


                // Tablas de ejemplo - Tienes que sacar con consultas por cada establecimiento 3xn
                // $tabla1 = array(
                //     array("Nº", "Biológicos", "Cantidad"),
                //     array("01", "BCG", "11"),
                //     array("02", "HVB x Dosis Pediatrico", "0"),
                //     array("03", "HVB x 01 Dosis Adulto", "0"),
                //     array("04", "Pentavalente x Dosis", "0"),
                //     array("05", "Antipolio x 10 Dosis", "0"),
                //     array("06", "Neumococo", "0"),
                //     array("07", "Rotavirus", "0"),
                //     array("08", "Influenza Pediatrica", "0"),
                //     array("09", "DPT x 10 Dosis", "0"),
                //     array("10", "HIB", "0"),
                //     array("11", "SPR x 01 Dosis", "0"),
                //     array("12", "Antiamarilica x 1 Dosis", "0"),
                //     array("13", "SR x 10 Dosis", "0"),
                //     array("14", "Dt Adulto x 10 Dosis", "0"),
                //     array("15", "Dt Pediatrico x 10 Dosis", "0"),
                //     array("16", "Antipolio iny x 1 Dosis", "0"),
                //     array("17", "Influenza Adulto", "0"),
                //     array("18", "VPH", "0"),
                //     array("19", "Varicela", "0"),
                //     array("20", "DPTA", "0"),
                //     array("21", "SR MONODOSIS", "0"),
                //     array("22", "HEPATITIS A", "0"),
                //     array("23", "Otros", "0")
                // );







                // 3xn

                $tabla3 = self::getData($id1, $id2,  $valorSiguiente);


                // $tabla3 = array(
                //     array("Nº", "Biológicos", "Cantidad"),
                //     array("01", "BCG", "0"),
                //     array("02", "HVB x Dosis Pediatrico", "0"),
                //     array("03", "HVB x 01 Dosis Adulto", "0"),
                //     array("04", "Pentavalente x Dosis", "0"),
                //     array("05", "Antipolio x 10 Dosis", "0"),
                //     array("06", "Neumococo", "0"),
                //     array("07", "Rotavirus", "0"),
                //     array("08", "Influenza Pediatrica", "0"),
                //     array("09", "DPT x 10 Dosis", "0"),
                //     array("10", "HIB", "0"),
                //     array("11", "SPR x 01 Dosis", "0"),
                //     array("12", "Antiamarilica x 1 Dosis", "0"),
                //     array("13", "SR x 10 Dosis", "0"),
                //     array("14", "Dt Adulto x 10 Dosis", "0"),
                //     array("15", "Dt Pediatrico x 10 Dosis", "0"),
                //     array("16", "Antipolio iny x 1 Dosis", "0"),
                //     array("17", "Influenza Adulto", "0"),
                //     array("18", "VPH", "0"),
                //     array("19", "Varicela", "0"),
                //     array("20", "DPTA", "0"),
                //     array("21", "SR MONODOSIS", "0"),
                //     array("22", "HEPATITIS A", "0"),
                //     array("23", "Otros", "0")
                // );

                // 2xn
                // $tabla4 = array(
                //     array("Jeringas", "Cantidad"),
                //     array("1cc c/a 27Gx1/2\"", "0"),
                //     array("1cc c/a 25Gx5/8\"", "0"),
                //     array("1cc c/a 25Gx1º", "0"),
                //     array("1cc c/a 21Gx11/2º", "0"),
                //     array("5cc c/a 21x1\"", "0")
                // );

                $suma = $tabla3[3][2] + $tabla3[4][2] + $tabla3[6][2] + $tabla3[8][2] * 16  + $tabla3[9][2] * 8  + $tabla3[14][2] * 8  + $tabla3[15][2] * 8  + $tabla3[17][2] + $tabla3[18][2] + $tabla3[20][2];
                // dd($tabla3[1][2] + 0);
                // $tabla4 = array(
                //     array("Jeringas", "Cantidad"),
                //     array("1cc c/a 27Gx1/2\"", "" . $tabla3[1][2]),
                //     array("1cc c/a 25Gx5/8\"", "" . ($tabla3[2][2] + $tabla3[11][2] + $tabla3[12][2] + $tabla3[13][2] + $tabla3[19][2] + $tabla3[21][2])),
                //     array("1cc c/a 25Gx1º", "$suma"),
                //     array("1cc c/a 21Gx11/2º", "0"),
                //     array("5cc c/a 21x1\"", "" . ($tabla3[1][2] + $tabla3[11][2] + $tabla3[12][2] + $tabla3[13][2] + $tabla3[19][2] + $tabla3[21][2])),
                //     array("             ", " "),
                //     array("             ", " "),
                //     array("", ""),

                //     array("Observaciones:", "")
                // );
                $tabla4 = self::getJeringa($id1, $id2, $valorSiguiente);
                $complemento = array(
                    array("             ", " "),
                    array("             ", " "),
                    array("", ""),
                    array("Observaciones:", "")
                );

                $tabla4 = array_merge($tabla4, $complemento);


                // Obtenemos el nro de filas mayor de los array;
                $nroColumnas = 13;
                $nroFila = count($tabla1); // La cantidad de vacunas

                // Creamos nuestra matriz
                $matriz = array();

                // Hacemos un buble que recorra las filas (i) y columnas (j)
                for ($i = 0; $i < $nroFila; $i++) {
                    for ($j = 0; $j < $nroColumnas; $j++) {
                        // llenamos la matriz con valores predeterminados:

                        // Si tenemos registro siguiente

                        if ($valorSiguiente != null) {
                            if ($j <= 2) {
                                $val = $tabla1[$i][$j];
                            } elseif ($j ==  4 || $j ==  5) {
                                $val = isset($tabla2[$i][$j == 4 ? 0 : 1]) ? $tabla2[$i][$j == 4 ? 0 : 1] : '';
                            } elseif ($j >=  7 && $j <=  9) {
                                if ($j == 7) {
                                    $auxj  = 0;
                                } elseif ($j == 8) {
                                    $auxj  = 1;
                                } else {
                                    $auxj  = 2;
                                }
                                $val = isset($tabla3[$i][$auxj]) ? $tabla3[$i][$auxj] : '';
                            } elseif ($j == 11 || $j == 12) {
                                $val = isset($tabla4[$i][$j == 11 ? 0 : 1]) ? $tabla4[$i][$j == 11 ? 0 : 1] : '';
                            } elseif ($j == 3 || $j == 6 || $j == 10) {
                                $val = "b"; // Para las columnas en blanco 
                            } else {
                                $val = "";
                            }
                        } else {
                            if ($j <= 2) {
                                $val = $tabla1[$i][$j];
                            } elseif ($j ==  4 || $j ==  5) {
                                $val = isset($tabla2[$i][$j == 4 ? 0 : 1]) ? $tabla2[$i][$j == 4 ? 0 : 1] : '';
                            } else {
                                $val = "";
                            }
                        }

                        $matriz[$i][$j] = $val;
                    }
                }

                // Aqui pasamos los datos del establecimiento y de la matriz respectiva
                $tabla_maestra[] = ["establecimiento" => $valorActual, "establecimiento2" => $valorSiguiente = isset($miArray[$indiceSiguiente]) ? $miArray[$indiceSiguiente] : '', "matriz" => $matriz];
            }
        }
        $fontFamily = $this->fontFamily;


        return view('reporte.vale.excel', compact("tabla_maestra", "nroFila", 'fontFamily'));
    }

    public function styles(Worksheet $sheet)
    {
        // Agrega el encabezado personalizado en la fila 1
        $imagePath = public_path('/images/encabezado.png'); // Cambia la ruta a la ubicación de tu imagen

        // Suponiendo que $sheet es tu objeto de hoja de cálculo y $imagePath es la ruta de la imagen
        // $imagePath = '/images/encabezado.png';

        $headerFooter = $sheet->getHeaderFooter();

        // Crear un objeto HeaderFooterDrawing para la imagen en el centro
        $centerImage = new HeaderFooterDrawing();
        $centerImage->setName('Image');
        $centerImage->setPath($imagePath);
        $centerImage->setHeight(50); // Ajusta la altura de la imagen
        $centerImage->setCoordinates('CENTER'); // Centrar la imagen

        // Establecer la imagen en el encabezado o pie de página en el centro
        $headerFooter->setImages(['CENTER' => $centerImage]);
    }


    public static function getJeringaConsolidado($mes, $anio, $cod_acopio)
    {
        $array = array(["Jeringas", "Cantidad"]);
        $jeringa = DB::table('jeringa as j')
            ->where('j.descripcion', '!=', 'No Especifica')
            ->get();
        foreach ($jeringa as $j) {

            $periodo = DB::table('periodo as p')
                ->join('establecimiento as e', 'p.cod_establecimiento', '=', 'e.cod_establecimiento')
                ->join('acopio as a', 'e.cod_acopio', '=', 'a.cod_acopio')
                ->join('vacuna as v', 'p.cod_vacuna', '=', 'v.cod_vacuna')
                ->join('vacuna_jeringa as vj', 'v.cod_vacuna', '=', 'vj.cod_vacuna')
                ->where('a.cod_acopio', $cod_acopio)
                ->where('vj.cod_jeringa', $j->cod_jeringa)
                ->where('p.mes', $mes)
                ->where('p.anio', $anio)
                ->where('v.estado', 1) // Agregar esta condición
                // ->where('p.cod_establecimiento', $cod_establecimiento)
                ->selectRaw('SUM(p.entrada * vj.num_mul) AS suma_consolidado')
                // ->distinct()
                ->first();


            $algo = [$j->descripcion, ' ' . (isset($periodo->suma_consolidado) ? $periodo->suma_consolidado : 0)];

            array_push($array, $algo);
        }
        return $array;
    }

    public static function getJeringa($mes, $anio, $nombre_est)
    {
        $array = array(["Jeringas", "Cantidad"]);
        $jeringa = DB::table('jeringa as j')
            ->where('j.descripcion', '!=', 'No Especifica')
            ->get();
        foreach ($jeringa as $j) {

            $periodo = DB::table('periodo as p')
                ->join('establecimiento as e', 'p.cod_establecimiento', '=', 'e.cod_establecimiento')
                // ->join('acopio as a', 'e.cod_acopio', '=', 'a.cod_acopio')
                ->join('vacuna as v', 'p.cod_vacuna', '=', 'v.cod_vacuna')
                ->join('vacuna_jeringa as vj', 'v.cod_vacuna', '=', 'vj.cod_vacuna')
                ->where('e.nombre_est', $nombre_est)
                ->where('vj.cod_jeringa', $j->cod_jeringa)
                ->where('p.mes', $mes)
                ->where('p.anio', $anio)
                ->where('v.estado', 1) // Agregar esta condición
                // ->where('p.cod_establecimiento', $cod_establecimiento)
                ->selectRaw('SUM(p.entrada *  vj.num_mul) AS suma_consolidado')
                ->groupBy('vj.cod_jeringa')
                ->first();



            $algo = [$j->descripcion, ' ' . (isset($periodo->suma_consolidado) ? $periodo->suma_consolidado : 0)];

            array_push($array, $algo);
        }
        return $array;
    }




    public static function getData($mes, $anio, $nombre_est)
    {
        $array = array(["Nº", "Biológicos", "Cantidad"]);
        $vacuna = DB::table('vacuna as v')
            ->where('v.estado', 1)
            ->get();

        $cont = 1;
        foreach ($vacuna as $v) {

            $periodo = DB::table('periodo as p')
                ->join('establecimiento as e', 'p.cod_establecimiento', '=', 'e.cod_establecimiento')
                ->where('p.cod_vacuna', $v->cod_vacuna)
                ->where('p.mes', $mes)
                ->where('p.anio', $anio)
                ->where('e.nombre_est', $nombre_est)
                // ->where('p.cod_establecimiento', $id_establecimiento)
                // ->distinct()
                ->first();
            $algo = [$cont, $v->nombre, ' ' . (isset($periodo->entrada) ? $periodo->entrada : 0)];

            array_push($array, $algo);
            $cont++;
        }
        return $array;
    }

    public static function getConsolidado($mes, $anio, $cod_acopio)
    {
        $array = array(["Nº", "Biológicos", "Cantidad"]);
        $vacuna = DB::table('vacuna as v')
            ->where('v.estado', 1)
            ->get();

        $cont = 1;
        foreach ($vacuna as $v) {

            $periodo = DB::table('periodo as p')
                ->join('establecimiento as e', 'p.cod_establecimiento', '=', 'e.cod_establecimiento')
                ->join('acopio as a', 'e.cod_acopio', '=', 'a.cod_acopio')
                ->where('a.cod_acopio', $cod_acopio)
                ->where('p.cod_vacuna', $v->cod_vacuna)
                ->where('p.mes', $mes)
                ->where('p.anio', $anio)
                // ->where('p.cod_establecimiento', $cod_establecimiento)
                ->selectRaw('SUM(p.entrada) AS suma_consolidado')
                // ->distinct()
                ->first();
            $algo = [$cont, $v->nombre, ' ' . (isset($periodo->suma_consolidado) ? $periodo->suma_consolidado : 0)];

            array_push($array, $algo);
            $cont++;
        }
        return $array;
    }
}
