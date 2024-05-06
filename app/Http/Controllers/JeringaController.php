<?php

namespace App\Http\Controllers;

use App\Http\Requests\JeringaFormRequest;
use App\Models\Jeringa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class JeringaController extends Controller
{
     //
     public function __construct(){
       
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $paginate = 8;
        $searchText = trim($request->get('searchText'));
        if ($request) {
            $jeringa = Jeringa::where('descripcion', 'LIKE', '%' . $searchText . '%')
                ->orderBy('cod_jeringa', 'asc')
                ->paginate($paginate);
            return view('registro.jeringa.index', compact("jeringa", "searchText", "paginate"));
        }
    }
    public function create()
    {
        return view('registro.jeringa.create');
    }
    public function store(JeringaFormRequest $request)
    {
        try {
            //code...
            $jeringa = new Jeringa();
            $jeringa->descripcion=$request->get('descripcion'); 
            $jeringa->save();
            return Redirect::to('registro/jeringa')->with(['success' => '¡Satisfactorio!, ' . $jeringa->descripcion . ' agregado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    public function edit($id)
    {
        return view("registro.jeringa.edit", ["jeringa" => jeringa::findOrFail($id)]);
    }
    public function update(jeringaFormRequest $request, $id)
    {
        try {
            $jeringa=Jeringa::findOrFail($id);
            $jeringa->descripcion=$request->get('descripcion');            
            $jeringa->update();
            return Redirect::to('registro/jeringa')->with(['success' => '¡Satisfactorio!, ' . $jeringa->descripcion . ' modificado.']);
        } catch (\Exception $e) {
            //throw $th;
            return redirect()->back()->with(['error' => '¡Error!, ' . $e->getMessage()]);
        }
    }
    

    public function destroy(Request $request, $id)
    {
        try {
            if ($request->ajax()) {
                $docu   = Jeringa::findOrFail($id);
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
            }
        } catch (\Exception $e) {
            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => '¡Error!, Este registro tiene enlazado uno o mas registros.',
                ]);
            }
        }
    }
}
