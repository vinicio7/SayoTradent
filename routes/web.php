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

	Route::post 	('filtrar/movimientos',		'MovimientosController@filtrar');
	Route::post 	('filtrar/despacho',		'DespachosController@filtrar');
	Route::post 	('filtrar/muestra',			'MuestrasController@filtrar');
	Route::post 	('filtrar/estadoCuenta',	'OrdenesController@filtrar');
	Route::post 	('filtrar/estadoCuentaConsumo',	'OrdenesController@filtrarConsumo');
	Route::post 	('filtrar/planilla',		'PlanillaController@filtrar');
	Route::post 	('filtrar/cafta',			'OrdenesController@filtrarCafta');
	Route::post 	('consultar',				'PlanillaController@consultar');
	Route::post 	('consultar/tenidas',		'TenidoController@consultarTenidas');
	Route::resource ('usuarios', 				'UsuariosController');
	Route::any 		('login', 					'UsuariosController@login');
	Route::resource ('planilla', 				'PlanillaController');
	Route::any ('modificar/planilla', 		    'PlanillaController@modificar');
	Route::resource ('proveedores', 			'ProveedoresController');
	Route::resource ('clientes', 				'ClientesController');
    Route::resource ('cuentas', 				'CuentasController');
	Route::resource ('compras', 				'ComprasController');
	Route::resource ('excel/usuarios', 			'ExcelController');
	Route::any 		('excel/proveedores', 		'ExcelController@reporteProveedores');
	Route::any 		('excel/clientes', 			'ExcelController@reporteClientes');
	Route::any 		('excel/control', 			'ExcelController@reporteControl');
	Route::any 		('excel/compras', 			'ExcelController@reporteCompras');
	Route::any 		('excel/movimientos', 		'ExcelController@reporteMovimientos');
	Route::any 		('excel/planilla', 			'ExcelController@reportePlanillas');
	Route::any 		('excel/inventarioColorantes','ExcelController@reporteInventarioColorantes');
	Route::any 		('excel/despachos',			'ExcelController@reporteDespachos');
	Route::any 		('excel/facturas',			'ExcelController@reporteFacturas');
	Route::any 		('excel/muestras',			'ExcelController@reporteMuestras');
	Route::get 		('excel/ordenesPorDia/{param}',	'ExcelController@reporteOrdenesPorDia');
	Route::get 		('excel/despachosDiarios/{param}',	'ExcelController@reporteDespachosDiarios');
	Route::get 		('excel/controlOrdenCafta/{param}/{param1}', 'ExcelController@reporteControlOrdenCafta');
	Route::get 		('excel/estadoCuentaOrden/{param}/{param1}', 'ExcelController@reporteEstadoCuentaOrden');
	Route::get 		('excel/estadoCuentaConsumo/{param}/{param1}', 'ExcelController@reporteEstadoCuentaConsumo');
	Route::any 		('reporte/fechas', 			'ExcelController@ordenesfechas');
	Route::any 		('ordenes/tenido',			'OrdenesController@tenido');
	Route::resource ('ordenes', 				'OrdenesController');
	Route::resource ('facturas', 				'FacturasController');
	Route::post 	('ordenes/maseo',			'OrdenesController@maseo');
	Route::post 	('ordenes/secado',			'OrdenesController@secado');
	Route::post 	('ordenes/enconado',		'OrdenesController@enconado');
	Route::post 	('ordenes/maseo',		    'OrdenesController@maseo');
	Route::get 		('calidad',		    		'OrdenesController@control_calidad2');
	Route::resource ('movimientos', 			'MovimientosController');
	Route::get 		('cliente', 				'OrdenesController@cliente');
	Route::get 		('estilos', 				'OrdenesController@estilos');
	Route::get 		('calibres', 				'OrdenesController@calibres');
	Route::get 		('metraje', 				'OrdenesController@metraje');
	Route::get 		('tipoOrden', 				'OrdenesController@tipoOrden');
	Route::get 		('colores', 				'OrdenesController@colores');
	Route::get 		('referencias', 			'OrdenesController@referencias');
	Route::get 		('lugares', 				'OrdenesController@lugares');
	Route::get 		('estados', 				'OrdenesController@estado');
	Route::post 	('muestra', 				'OrdenesController@muestrastore');
	Route::get 		('mostrar/muestra/{id}', 	'OrdenesController@mostrarmuestra');
	Route::post 	('despachos', 				'OrdenesController@despachostore');
	Route::get 		('mostrar/despacho/{id}', 	'OrdenesController@mostrardespacho');
	Route::get 		('recetas',					'TenidoController@recetas');
	Route::get 		('recetasproceso',			'TenidoController@recetas_proceso');
	Route::post 	('rechazarproceso', 		'TenidoController@rechazar_proceso');
	Route::get	 	('tenido/rechazos', 		'TenidoController@rechazos');
	Route::resource ('tenido', 				    'TenidoController');
	Route::get      ('filtro/teñido', 			'TenidoController@filtrotenido');
	Route::get      ('buscar/{id}', 		    'TenidoController@buscar');
	Route::get      ('buscar1/{id}', 		    'SecadoController@buscar');
	Route::get      ('buscar2/{id}', 		    'EnconadoController@buscar');
	Route::get      ('buscar3/{id}', 		    'MaseoController@buscar');
	Route::resource ('secado', 				    'SecadoController');
	Route::get      ('filtro/secado', 			'SecadoController@filtrosecado');
	Route::resource ('enconado', 				'EnconadoController');
	Route::get      ('filtro/enconado', 		'EnconadoController@filtroenconado');
	Route::resource ('devanado', 				'DevanadoController');
	Route::get      ('filtro/devanado', 		'DevanadoController@filtrodevanado');
	Route::resource ('maseo', 				    'MaseoController');
	Route::resource ('colorantes', 				'InventarioColoranteController');
	Route::resource ('hilos', 					'CalibreController');
	Route::resource ('colorantesInfo',			'ColoranteController');
	Route::resource ('facturar',				'FacturasController');
	Route::resource ('metrajes', 				'MetrajeController');
	Route::resource ('estilo', 				    'EstiloController');
	Route::resource ('color', 				    'ColorController');
	Route::resource ('despacho',				'DespachosController');
	Route::resource ('muestras',				'MuestrasController');
	Route::get      ('ordenesPorDia/{param}',	'OrdenesController@ordenesPorDia');
	Route::get      ('despachosDiarios/{param}','DespachosController@despachosDiarios');
	Route::get      ('controlOrdenCafta/{param}/{param1}','OrdenesController@controlOrdenCafta');

	Route::resource ('control_calidada',				'ControlCalidadController');


	Route::get      ('estadoCuentaOrden/{param}/{param1}','OrdenesController@estadoCuentaOrden');
	Route::get      ('estadoCuentaConsumo/{param}/{param1}','OrdenesController@estadoCuentaConsumo');
	Route::get 		('consultarOrden/{id}',				'OrdenesController@consultarOrden');
	Route::get 		('showOrdenes',						'OrdenesController@ordenes');
});	

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::any('muestrasDoc', 'ExcelController@muestrasDoc');
