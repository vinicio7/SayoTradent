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
		return redirect('src');
});

Route::group(['prefix' => 'ws'], function (){

	Route::resource ('usuarios', 				'UsuariosController');
	Route::any 		('login', 					'UsuariosController@login');
	Route::resource ('planilla', 				'PlanillaController');
	Route::resource ('proveedores', 			'ProveedoresController');
	Route::resource ('clientes', 				'ClientesController');
    Route::resource ('cuentas', 				'CuentasController');
	Route::resource ('compras', 				'ComprasController');
	Route::resource ('excel/usuarios', 			'ExcelController');
	Route::any 		('excel/proveedores', 		'ExcelController@reporteProveedores');
	Route::any 		('excel/clientes', 			'ExcelController@reporteClientes');
	Route::any 		('excel/compras', 			'ExcelController@reporteCompras');
	Route::any 		('excel/movimientos', 		'ExcelController@reporteMovimientos');
	Route::resource ('ordenes', 				'OrdenesController');
	Route::resource ('movimientos', 			'MovimientosController');
	Route::get 		('empresa', 				'OrdenesController@empresas');
	Route::get 		('estilos', 				'OrdenesController@estilos');
	Route::get 		('calibres', 				'OrdenesController@calibres');
	Route::get 		('metraje', 				'OrdenesController@metraje');
	Route::get 		('colores', 				'OrdenesController@colores');
	Route::get 		('referencias', 			'OrdenesController@referencias');
	Route::get 		('lugares', 				'OrdenesController@lugares');
	Route::get 		('estados', 				'OrdenesController@estado');
	Route::post 	('muestra', 				'OrdenesController@muestrastore');
	Route::get 		('mostrar/muestra/{id}', 	'OrdenesController@mostrarmuestra');
	Route::post 	('despachos', 				'OrdenesController@despachostore');
	Route::get 		('mostrar/despacho/{id}', 	'OrdenesController@mostrardespacho');

});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
