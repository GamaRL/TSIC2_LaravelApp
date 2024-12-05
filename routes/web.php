<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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

Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

/**
 * Modelo Paciente
 */

Route::redirect('/', '/pacientes');

Route::get('/pacientes/create', 'PacienteController@create');
Route::post('/pacientes', 'PacienteController@store');

Route::get('/pacientes', 'PacienteController@index');
Route::get('/pacientes/{paciente}', 'PacienteController@show')
    ->where('paciente', '\d+');

Route::post('/pacientes/dataTable', 'PacienteController@dataTable');
Route::post('/pacientes/riesgo/dataTable/{sesion}', 'ConsultasController@riesgoDatatable');

Route::get('/pacientes/{id}/getStatistics', 'PacienteController@getStatData')
    ->where('id', '\d+');

Route::get('/pacientes/{id_paciente}/consulta/', 'ConsultasController@create')->where('id_paciente', '\d+');
Route::post('/pacientes/{id_paciente}/consulta/', 'ConsultasController@store')->where('id_paciente', '\d+');

Route::get('/pacientes/{paciente}/edit/', 'PacienteController@edit')->where('id_paciente', '\d+');
Route::post('/pacientes/{paciente}/edit/', 'PacienteController@update')->where('id_paciente', '\d+');

Route::post('/pacientes/export/{paciente}', 'ReporteController@individual');

Route::post('/pacientes/{paciente}/mensajes', 'MensajeController@store');
Route::get('/pacientes/{paciente}/mensajes_data', 'PacienteController@get_alertas_data');
Route::get('/pacientes/mensajes_data_all', 'ConsultasController@get_mensajes_disponibles');
Route::post('/pacientes/mensajes', 'MensajeController@store_all');

Route::group(['middleware' => ['admin']], function () {
    Route::get('/admin/', function () {
        return view('admin');
    });
    Route::get('/admin/pacientes/{sesion}', 'ConsultasController@getPacientesRiesgo');
    Route::get('/admin/pacientes/{sesion}/{paciente}', 'PacienteController@getRiesgo')
        ->where(['sesion' => '\d+', 'paciente' => '\d+']);
    Route::get('/admin/pacientes/diab_mill/{id}', 'PacienteController@changeDiabMill')
        ->where('id', '\d+');
    Route::get('admin/alertas/{sesion}', 'AlertaController@getAlertasSesion');

    Route::get('/admin/usuarios/eliminar', function () {
        return view('remove_user');
    });

    Route::get('/admin/usuarios/eliminar/{id}', function ($id) {
        if ($id != Auth::id()) {
            DB::table('users')->where('id', $id)->delete();
        }
        return redirect('/admin/usuarios/eliminar');
    })->where('id', '\d*');

    Route::get('/admin/estadisticas/get/general', 'ConsultasController@getStatGeneral');
    Route::get('/admin/estadisticas/get/{sesion}', 'ConsultasController@statistics');
    Route::get('/admin/estadisticas/sesion', function () {
        return view('estadisticas_sesion');
    });

    Route::get('/admin/estadisticas/general', function () {
        return view('estadisticas_general');
    });

    Route::get('/admin/consultas/export', 'ConsultasController@exportExcel');

    Route::get('/admin/reportes/generar', 'ReporteController@generar');
    Route::get('/admin/reportes', 'ReporteController@index');
});

