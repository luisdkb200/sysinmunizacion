<?php

namespace App\Http\Controllers;

use App\Http\Requests\VacunaFormRequest;
use App\Models\Jeringa;
use App\Models\Vacuna;
use App\Models\Vacuna_Jeringa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class VacunaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 15;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $vacunas = Vacuna::where('nombre', 'LIKE', '%' . $searchText . '%')
                // ->join('jeringa as j', 'vacuna.cod_jeringa', '=', 'j.cod_jeringa')
                ->orderBy('vacuna.nombre')
                ->paginate($paginate);
            $jeringa = Jeringa::all();
            return view('registro.vacuna.index', compact("vacunas", "searchText", "paginate", "jeringa"));
        }
    }

    public function show($id)
    {
        $n_id = substr($id, 1);

        $vacuna_v = DB::table('vacuna')
            ->where('cod_vacuna', '=', $n_id)
            ->first();
        if (isset($vacuna_v->estado)) {
            if ($vacuna_v->estado == 1) {
                $estado = 0;
            } else {
                $estado = 1;
            }
        }

        $users = Vacuna::findOrFail($n_id);
        $users->estado = $estado;
        $users->update();
        return redirect()->back();
    }
    public function create()
    {
        return view('registro.vacuna.create');
    }
    public function store(VacunaFormRequest $request)
    {
        try {
            //code...
            $vacuna = new Vacuna();
            $vacuna->nombre = $request->get('nombre');
            $vacuna->sigla = $request->get('sigla');
            $vacuna->num_dosis = $request->get('num_dosis');
            $vacuna->estado = 1;
            // $jeringas = $request->get('cod_jeringa');

            $vacuna->save();
            $jeringas = $request->input('cod_jeringa');
            foreach ($jeringas as $j) {

                $vacuna_jeringa = new Vacuna_Jeringa();
                $vacuna_jeringa->cod_vacuna = $vacuna->cod_vacuna;
                $vacuna_jeringa->cod_jeringa = $j;
                $vacuna_jeringa->num_mul = 1;
                $vacuna_jeringa->save();
            }


            return Redirect::to('registro/vacuna')->with(['success' => '¡Satisfactorio!, ' . $vacuna->nombre . ' agregado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        $jeringa = Jeringa::all();
        $jeringas_asignadas = Vacuna_Jeringa::where('cod_vacuna', '=', $id)->get();


        return view("registro.vacuna.edit", ["vacunas" => Vacuna::findOrFail($id), "jeringa" => $jeringa, "jeringas_asignadas" => $jeringas_asignadas]);
    }
    public function update(VacunaFormRequest $request, $id)
    {
        try {
            $vacuna = Vacuna::findOrFail($id);
            $vacuna->nombre = $request->get('nombre');
            $vacuna->sigla = $request->get('sigla');
            $vacuna->num_dosis = $request->get('num_dosis');
            $vacuna->save();
            $jeringas = $request->input('cod_jeringa');
            Vacuna_Jeringa::where('cod_vacuna', $id)->delete();
            foreach ($jeringas as $j) {

                $vacuna_jeringa = new Vacuna_Jeringa();
                $vacuna_jeringa->cod_vacuna = $vacuna->cod_vacuna;
                $vacuna_jeringa->cod_jeringa = $j;

                $vacuna_jeringa->save();
            }
            return Redirect::to('registro/vacuna')->with(['success' => '¡Satisfactorio!, ' . $vacuna->nombre . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public static function obtenerJeringas($id)
    {
        $jeringas = Vacuna_Jeringa::join('jeringa as j', 'vacuna_jeringa.cod_jeringa', '=', 'j.cod_jeringa')
            ->where('cod_vacuna', $id)
            // ->select('j.descripcion')
            ->get();
        return $jeringas;
    }

    public function numJeringas(Request $request)
    {

        $vacuna_jeringa =   DB::table('vacuna_jeringa as vj')
            ->where('cod_vacuna', $request->get('cod_vacuna'))
            ->where('cod_jeringa', $request->get('cod_jeringa'))
            ->first();

        try {
            $vjeringa = Vacuna_Jeringa::findOrFail($vacuna_jeringa->cod_vacuna_jeringa);
            $vjeringa->num_mul = $request->get('num_mul');  
            $vjeringa->update();

            return Redirect::to('registro/vacuna')->with(['success' => '¡Satisfactorio!, ' . 'Numero de Jeringas' . ' modificado.']);
        } catch (\Exception $e) {
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }

    public function destroy(Request $request, $id)
    {
        try {
            $docu = Vacuna::findOrFail($id);
            $docu2 = Vacuna_Jeringa::where('cod_vacuna', '=', $id);
            $docu2->delete();
            if ($docu->delete()) {
                return response()->json([
                    'success' => true,
                    'message' => '¡Satisfactorio!, Registro eliminado con éxito.',
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, No se pudo eliminar.',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => '¡Error!, Este registro tiene enlazado uno o más registros.',
            ]);
        }
    }
}
