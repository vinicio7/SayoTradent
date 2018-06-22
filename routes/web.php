<?php

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

Route::get('/', function () {
		return redirect(env('PHASE'));
});

Route::group(['prefix' => 'ws'], function (){

	Route::resource ('usuarios', 			'UsuariosController');
	Route::any 		('login', 				'UsuariosController@login');
	Route::resource ('planilla', 			'PlanillaController');
	Route::resource ('proveedores', 		'ProveedoresController');
	Route::resource ('clientes', 			'ClientesController');
	Route::resource ('compras', 			'ComprasController');
	Route::resource ('excel/usuarios', 		'ExcelController');
	Route::any 		('excel/proveedores', 	'ExcelController@reporteProveedores');
	Route::any 		('excel/clientes', 		'ExcelController@reporteClientes');
	Route::any 		('excel/compras', 		'ExcelController@reporteCompras');
	Route::any 		('excel/movimientos', 	'ExcelController@reporteMovimientos');
	Route::resource ('ordenes', 			'OrdenesController');
	Route::resource ('movimientos', 		'MovimientosController');
	// Route::resource ('empresa', 			'EmpresasController');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
