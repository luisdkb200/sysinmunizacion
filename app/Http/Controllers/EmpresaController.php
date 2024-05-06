<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmpresaFormRequest;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\InformacionFormRequest;
use App\Models\Empresa;
use Illuminate\Support\Carbon;
use App\Models\Informacion;
use Illuminate\Support\Facades\Redirect;
use Intervention\Image\ImageManagerStatic as Image;


class EmpresaController extends Controller
{
    public function __construct()
    {
       
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if ($request) {
            $empresa = DB::table('empresa')
            // ->Where('u.idUsers', '=', auth()->user()->idUsers)
            ->first();
            return view('configuracion.ajustes.index',["empresa"=>$empresa]);

        }
    }

    public function update(EmpresaFormRequest $request,$id)
    {
        try {
            $empresa=Empresa::findOrFail($id);
            $empresa->nomEmp=$request->get('nomEmp');
            $empresa->direcEmp=$request->get('direcEmp');
            $empresa->telefEmp=$request->get('telefEmp');
            $empresa->nroRucEmp=$request->get('nroRucEmp');           

            // $empresa->logoEmp = $request->get('logoEmp');
            if ($request->hasFile('logoEmp')) {
                $file = $request->file('logoEmp');
                $customFileName = uniqid() . '.' . $file->extension();
                $file->move(public_path() . '/empresas', $customFileName);
                $empresa->logoEmp = $customFileName;
            }
            $empresa->update();
            return Redirect::to('configuracion/ajustes')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/ajustes')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }
    }
    public function actualizar_configuracion(Request $request){

        try {
            $empresa=Empresa::findOrFail($request->get('id'));
            $empresa->saleDelete=$request->get('saleDelete');
            $empresa->update();
            return Redirect::to('configuracion/ajustes')->with(['success' => 'Se ha modificado correctamente']);
        } catch (Exception $e) {
            return Redirect::to('configuracion/ajustes')->with(['error' => 'Ocurrió un error al procesar su petición']);
        }

    }
}
