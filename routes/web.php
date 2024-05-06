<?php

use App\Http\Controllers\Auth\LoginController;

use App\Http\Controllers\EmpresaController;
use App\Http\Controllers\EntregaVacunaController;
use App\Http\Controllers\EstablecimientoController;
use App\Http\Controllers\GeneralReportController;
use App\Http\Controllers\JeringaController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PoblacionController;
use App\Http\Controllers\SaldoVacunaController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\VacunaController;
use App\Http\Controllers\ValeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');




Route::get('/', function () {
    return view('auth.login');
})->name('login')->middleware('guest');

Auth::routes();
Route::put('/login', [LoginController::class, 'logout']);

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::resource('panel_control', PanelController::class);

Route::resource('acceso/usuario', UsuarioController::class);
Route::resource('configuracion/ajustes', EmpresaController::class);
Route::resource('registro/vacuna', VacunaController::class);
Route::resource('registro/establecimiento', EstablecimientoController::class);
Route::resource('registro/saldo_vacuna', SaldoVacunaController::class);
Route::resource('registro/poblacion', PoblacionController::class);

Route::resource('registro/jeringa', JeringaController::class);

Route::resource('inicio/entrega_vacunas', EntregaVacunaController::class);


Route::resource('reporte/vale', ValeController::class);
Route::get('reporte/vale/excel/{id}/{id2}/{id3}', [ValeController::class, 'reportExcel'])->name('vale.excel');

Route::resource('reporte/general', GeneralReportController::class);
Route::get('reporte/general/excel/{id}', [GeneralReportController::class, 'reportExcel'])->name('general.excel');

Route::get('inicio/entrega_vacunas/movimiento/{id}', [EntregaVacunaController::class, 'vistaMovimiento'])->name('vistaMovimiento');

Route::post('panel_control/entrega_vacunas/movimiento/', [EntregaVacunaController::class, 'storeMovimiento'])->name('storeMovimiento');

Route::get('registro/poblacion/asignacion/{id}', [PoblacionController::class, 'vistaPoblacion'])->name('vistaPoblacion');
Route::post('registro/poblacion/asignacion/', [PoblacionController::class, 'storeAsignacion'])->name('storeAsignacion');

Route::put('registro/vacuna/{id}/numJeringa', [VacunaController::class, 'numJeringas'])->name('numJeringas');



Route::get('/export', [PanelController::class, 'export'])->name('export');

Route::post('/importar', [PoblacionController::class, 'importar']);

Route::get('inicio/entrega_vacunas/{id}/{id2}/{id3}/excelVacunas', [EntregaVacunaController::class, 'reportExcel'])->name('excelVacunas.excel');
