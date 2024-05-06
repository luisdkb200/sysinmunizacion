<?php

namespace App\Http\Controllers;

use App\Exports\VacunasReport;
use Illuminate\Http\Request;
use App\Http\Requests\PeriodoFormRequest;
use App\Http\Requests\SaldoVacunaFormRequest;
use App\Models\Periodo;
use App\Models\SaldoVacuna;
use App\Models\Vacuna;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;


class EntregaVacunaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {
        // $vacunas = Vacuna::all();
        $vacunas = Vacuna::where('estado', 1)->get();

        return view('inicio.entrega_vacunas.index', compact("vacunas"));
    }

    public function vistaMovimiento($id, Request $request)
    {
        $searchText = trim($request->get('searchText'));
        $searchText1 = trim($request->get('searchText1'));
        $vacunas = Vacuna::findOrFail($id);
        // $vacunas = Vacuna::where('estado', 1)->findOrFail($id);
        // $microred= DB::table('microred as mr')::all();



        $eess = DB::table('establecimiento as e')
            ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
            ->select('mr.cod_microred', 'e.nombre_est', 'e.cod_establecimiento')
            ->orderByDesc('mr.cod_microred')
            ->get();
        $mesM = [
            1 => 'Enero',
            2 => 'Febrero',
            3 => 'Marzo',
            4 => 'Abril',
            5 => 'Mayo',
            6 => 'Junio',
            7 => 'Julio',
            8 => 'Agosto',
            9 => 'Septiembre',
            10 => 'Octubre',
            11 => 'Noviembre',
            12 => 'Diciembre'
        ];
        $anioM = ['2021', '2022', '2023', '2024', '2025'];

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $searchText = empty($request->get('searchText')) ? date('n') : $request->get('searchText');
        $searchText1 = empty($request->get('searchText1')) ? date('Y') : $request->get('searchText1');

        //   dd(self::restarUnMes($searchText, $searchText1));

        $data = [];

        foreach ($eess as $e) {
            $id_data = self::getData($id, $searchText, $searchText1, $e->cod_establecimiento)[0];
            $salida = self::getData($id, $searchText, $searchText1, $e->cod_establecimiento)[3];
            $entrada = self::getData($id, $searchText, $searchText1, $e->cod_establecimiento)[2];

            $saldo = self::getSaldo($id,  $searchText, $searchText1, $e->cod_establecimiento)[0];
            $poblacion = self::getPoblacion($id, $searchText, $searchText1, $e->cod_establecimiento)[0];
            $data[] = ['id_data' => $id_data, 'codigo_esta' => $e->cod_establecimiento,  'cod_microred' => $e->cod_microred, 'establecimiento' => $e->nombre_est, 'salida' => $salida, 'entrada' => $entrada, 'saldo' => $saldo, 'poblacion' => $poblacion];
        }

        $saldoVacuna = DB::table('saldo as s')
            ->where('s.cod_vacuna', $id)
            ->where('s.mes', $searchText)
            ->where('s.anio', $searchText1)
            ->first();

        $periodo = DB::table('periodo as p')->get();
        return view("inicio.entrega_vacunas.movimiento", compact("saldoVacuna", "vacunas", "eess", "periodo", "searchText", "searchText1", "mesM", "anioM", 'data'));
    }


    public static function getSaldo($id_vacuna, $mes, $anio, $id_establecimiento)
    {
        // Obtenemos el mes anterior al proporcionado
        $mes_anterior = $mes - 1;
        $anio_anterior = $anio;

        // Si el mes anterior es enero, ajustamos el año y el mes
        if ($mes_anterior == 0) {
            $mes_anterior = 12;
            $anio_anterior = $anio - 1;
        }

        $periodo = DB::table('periodo as p')
            ->where('p.cod_vacuna', $id_vacuna)
            ->where('p.mes', $mes_anterior)
            ->where('p.anio', $anio_anterior)
            ->where('p.cod_establecimiento', $id_establecimiento)
            ->first();

        if (isset($periodo->saldo)) {
            return [$periodo->saldo];
        } else {
            return [0];
        }
    }
    public function storeMovimiento(PeriodoFormRequest $request)
    {
        // return $request->get('stockVacuna');

        $mytime = Carbon::now('America/Lima');
        $fecha = $mytime->toDateString();
        $anio = date('Y', strtotime($fecha));
        $mes = date('n', strtotime($fecha));
        // dd($request->get('cod_vacuna'));
        $eess = DB::table('establecimiento as e')
            ->get();

        $cantEst = count($eess);

        try {
            //code...

            // $codigoest = $request->get('datos');
            $id_data = $request->get('id_data');
            $establecimiento = $request->get('codigo_esta');
            $saldo = $request->get('sma');
            $entrega = $request->get('entrega');
            $salida = $request->get('salida');
            $stock = $request->get('stock');
            // return count($establecimiento);
            // dd($request->get('cod_saldoVacuna'));
            // dd($request->get('cod_saldoVacuna'));

            if ($request->get('cod_saldoVacuna') != -1) {
                $saldoVacuna = SaldoVacuna::findOrFail($request->get('cod_saldoVacuna'));
                $saldoVacuna->stock =  $request->get('saldoVacuna');
                $saldoVacuna->update();
            } else {
                $saldoVacuna = new SaldoVacuna();
                $saldoVacuna->stock = $request->get('saldoVacuna');
                $saldoVacuna->cod_vacuna = $request->get('cod_vacuna');
                $saldoVacuna->mes = $request->get('mes');
                $saldoVacuna->anio = $request->get('anio');
                $saldoVacuna->save();
            }

            $cont = 0;
            while ($cont < count($establecimiento)) {
                if ($id_data[$cont] != -1) {
                    $periodo = Periodo::findOrFail($id_data[$cont]);
                    // $periodo->cod_vacuna = $request->get('cod_vacuna');
                    $periodo->mes = $request->get('mes');
                    $periodo->anio = $request->get('anio');
                    $periodo->saldo = $stock[$cont];
                    $periodo->entrada = $entrega[$cont];
                    $periodo->salida = $salida[$cont];
                    $periodo->cod_establecimiento = $establecimiento[$cont];
                    $periodo->update();
                } else {
                    $periodo = new Periodo();
                    $periodo->cod_vacuna = $request->get('cod_vacuna');
                    $periodo->mes = $request->get('mes');
                    $periodo->anio = $request->get('anio');
                    $periodo->saldo = $stock[$cont];
                    $periodo->entrada = $entrega[$cont];
                    $periodo->salida = $salida[$cont];
                    $periodo->cod_establecimiento = $establecimiento[$cont];
                    $periodo->save();
                    // echo $establecimiento[$cont].'<br>';
                }


                $cont = $cont + 1;
            }
            return  redirect()->back()->with(['success' => '¡Satisfactorio!, ' . 'Vacunas Asignadas' . '.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public static function getData($id_vacuna, $mes, $anio, $id_establecimiento)
    {


        $periodo = DB::table('periodo as p')
            ->where('p.cod_vacuna', $id_vacuna)
            ->where('p.mes', $mes)
            ->where('p.anio', $anio)
            ->where('p.cod_establecimiento', $id_establecimiento)
            ->first();

        if (isset($periodo->saldo)) {
            return [$periodo->cod_periodo, $periodo->saldo, $periodo->entrada, $periodo->salida];
        } else {
            return [-1, 0, 0, 0];
        }
    }

    // public static function getPoblacion($id, $id_establecimiento)
    // {
    //     $poblacion = DB::table('poblacion as p')
    //         ->where('cod_establecimiento', $id_establecimiento)
    //         ->where('cod_vacuna', $id)
    //         ->first();
    //     if (isset($poblacion->poblacion_asignada)) {
    //         return [$poblacion->poblacion_asignada];
    //     } else {
    //         return [0];
    //     }
    // }

    public static function getPoblacion($id, $mes, $anio, $id_establecimiento)
    {
        // Calcular el mes 6 meses antes del mes dado
        $mes_inicio = $mes - 6;
        $anio_inicio = $anio;

        // Ajustar el año si el mes es menor a 1 (enero)
        while ($mes_inicio < 1) {
            $mes_inicio += 12;
            $anio_inicio--;
        }

        // Obtener la población de los 6 meses anteriores y calcular la suma
        $suma_poblacion = 0;
        for ($i = 0; $i < 6; $i++) {
            $poblacion = DB::table('poblacion as p')
                ->where('cod_establecimiento', $id_establecimiento)
                ->where('cod_vacuna', $id)
                ->where('mes', $mes_inicio)
                ->where('anio', $anio_inicio)
                ->first();

            if (isset($poblacion->poblacion_asignada)) {
                $suma_poblacion += $poblacion->poblacion_asignada;
            }

            // Pasar al mes siguiente
            $mes_inicio++;
            if ($mes_inicio > 12) {
                $mes_inicio = 1;
                $anio_inicio++;
            }
        }

        // Calcular el promedio de población
        $promedio_poblacion = ceil($suma_poblacion / 6);

        if (isset($poblacion->poblacion_asignada)) {
            return [$promedio_poblacion];
        } else {
            return [0];
        }
    }



    public static function obtenerColorFondo($codigo)
    {
        $colores = [
            1 => '#609c77',
            2 => '#8b5e8f',
            3 => '#308573',
            4 => '#9a2c24',
            5 => '#1e638b',
            6 => '#c6840e',
            7 => '#0d7a65',
            8 => '#743c71',
            9 => '#ae6119',
            10 => '#238c5e',
            11 => '#1d704e',
            // Agrega más códigos y colores según tus necesidades
        ];

        return $colores[$codigo] ?? 'gray';
    }


    public function reportExcel($f1,$f2,$f3)
    {
        $vacuna = DB::table('vacuna as v')
            ->where('cod_vacuna', $f1)
            ->first();
        $randomNumber = rand(1000, 9999);
        return Excel::download(new VacunasReport($f1,$f2,$f3), 'Movimiento_' . $vacuna->nombre . '_' . $randomNumber . '.xlsx');
    }

    // public function export()
    // {
    //     // Crear una nueva instancia de Spreadsheet
    //     $spreadsheet = new Spreadsheet();

    //     // Obtener la hoja activa del documento
    //     $sheet = $spreadsheet->getActiveSheet();

    //     // // Definir el array bidimensional como los datos de la tabla
    //     // $employees = [
    //     //     ['Name', 'Age', 'Email'],
    //     //     ['John Doe', 30, 'john@example.com'],
    //     //     ['Jane Smith', 25, 'jane@example.com'],
    //     //     // Add more data rows as needed
    //     // ];

    //     $employeesFromDB = DB::table('vacuna')->get();

    //     // Crear el array bidimensional a partir de los datos obtenidos
    //     $employees = [['Name', 'Age', 'Email']];

    //     foreach ($employeesFromDB as $employee) {
    //         $employees[] = [$employee->nombre, $employee->sigla, $employee->num_dosis];
    //     }

    //     // Definir los datos en la hoja de cálculo

    //     $cellPositions = array();


    //     $secuenciaA = [];
    //     $secuenciaH = [];
    //     $limit = 7; // Número de datos que deseas generar (en este caso, 7 elementos)

    //     for ($i = 13; $i <= $limit * 28; $i += 28) {
    //         $secuenciaA[] = 'A' . $i; // Agrega un elemento con 'A' seguido del número
    //         $secuenciaH[] = 'H' . $i; // Agrega un elemento con 'H' seguido del número
    //     }

    //     // Ahora, puedes usar las secuencias corregidas para escribir los datos en la hoja de cálculo
    //     foreach ($secuenciaA as $position) {
    //         $sheet->fromArray($employees, NULL, $position);
    //     }

    //     foreach ($secuenciaH as $position) {
    //         $sheet->fromArray($employees, NULL, $position);
    //     }


    //     // Crear un objeto Writer y guardar el archivo
    //     $writer = new Xlsx($spreadsheet);
    //     $filename = 'data.xlsx';
    //     $writer->save($filename);

    //     // Descargar el archivo generado
    //     return response()->download($filename)->deleteFileAfterSend(true);
    // }


    // private function getDataFromDatabase()
    // {
    //     // Lógica para obtener los datos de la base de datos
    //     // Reemplaza esto con tu propia lógica y devuelve los datos en forma de arreglo
    //     // Ejemplo:
    //     $vacunas = Vacuna::select('nombre')->get();


    //     return $vacunas;
    // }

}
