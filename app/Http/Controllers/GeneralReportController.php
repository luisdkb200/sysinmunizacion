<?php

namespace App\Http\Controllers;

use App\Exports\GeneralReport;
use App\Exports\VacunasSheets;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class GeneralReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if ($request) {
            // $searchText = trim($request->get('searchText'));
            $searchText1 = trim($request->get('searchText1'));
            $ambito = DB::table('acopio as a')
                // ->join('microred as mr', 'e.cod_microred', '=', 'mr.cod_microred')
                // ->orderByDesc('mr.cod_microred')          
                ->get();

            // $mesM = [
            //     1 => 'Enero',
            //     2 => 'Febrero',
            //     3 => 'Marzo',
            //     4 => 'Abril',
            //     5 => 'Mayo',
            //     6 => 'Junio',
            //     7 => 'Julio',
            //     8 => 'Agosto',
            //     9 => 'Septiembre',
            //     10 => 'Octubre',
            //     11 => 'Noviembre',
            //     12 => 'Diciembre'
            // ];
            $anioM = ['2021', '2022', '2023', '2024', '2025'];
            $mytime = Carbon::now('America/Lima');
            $fecha = $mytime->toDateString();
            // $searchText = empty($request->get('searchText')) ? date('n') : $request->get('searchText');
            $searchText1 = empty($request->get('searchText1')) ? date('Y') : $request->get('searchText1');
            return view('reporte.general.index', compact("searchText1", "anioM"));
        }
    }



    public function reportExcel($f1)
    {
        $randomNumber = rand(1000, 9999);
        return Excel::download(new VacunasSheets($f1), 'Control_Entrega_' . $randomNumber . '.xlsx');
    }
}
