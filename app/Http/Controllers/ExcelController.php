<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use App\Proveedores;
use App\Clientes;
use App\Compras;
use App\Movimientos;
use App\Orden;
use App\InventarioColorante;
use App\Facturas;
use App\Despachos;
use App\Muestra;
use Carbon\Carbon;
use App\ControlCalidad;

    
class ExcelController extends Controller
{
    public function index(Request $request){
        \Excel::create('Usuarios', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Usuarios::all();

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]  = $reporte->nombre;
                   $row ["Usuarios"] = $reporte->usuario;
                   $row ["Email"]    = $reporte->email;
              
                    if ($reporte->registro==1) {
                        $row ["Estado"] = "Con permisos";
                    } elseif ($reporte->registro==0){
                        $row ["Estado"] = "Sin permmisos"; 
                    }
                    
                    if ($reporte->administracion==1) {
                        $row ["Estado"] = "Con permisos";
                    } elseif ($reporte->administracion==0){
                        $row ["Estado"] = "Sin permmisos"; 
                    }
                    
                    if ($reporte->produccion==1) {
                        $row ["Produccion"] = "Con permisos";
                    } elseif ($reporte->produccion==0){
                        $row ["Produccion"] = "Sin permmisos"; 
                    }

                    if ($reporte->compras==1) {
                        $row ["Compras"] = "Con permisos";
                    } elseif ($reporte->compras==0){
                        $row ["Compras"] = "Sin permmisos"; 
                    }

                    if ($reporte->despachos==1) {
                        $row ["Despacho"] = "Con permisos";
                    } elseif ($reporte->despachos==0){
                        $row ["Despacho"] = "Sin permmisos"; 
                    }

                    if ($reporte->control==1) {
                        $row ["Control de calidad"] = "Con permisos";
                    } elseif ($reporte->control==0){
                        $row ["Control de calidad"] = "Sin permmisos"; 
                    }

                    if ($reporte->usuarios==1) {
                        $row ["Usuarios"] = "Con permisos";
                    } elseif ($reporte->usuarios==0){
                        $row ["Usuarios"] = "Sin permmisos"; 
                    }
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }


    public function reporteProveedores(Request $request){
        \Excel::create('Proveedores', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Proveedores::all();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]              = $reporte->nombre;
                   $row ["Nit"]                  = $reporte->nit;
                   $row ["Descripción"]          = $reporte->descripcion;
                   $row ["Fecha de Creación"]    = $reporte->created_at;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteClientes(Request $request){
        \Excel::create('Clientes', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Clientes::all();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]              = $reporte->nombre;
                   $row ["Nit"]                  = $reporte->nit;
                   $row ["Telefono"]             = $reporte->telefono;
                   $row ["Dirección"]            = $reporte->direccion;
                   $row ["Credito"]              = $reporte->credito;
                   $row ["Fecha de ingreso"]     = $reporte->created_at;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteControl(Request $request){
        \Excel::create('Control de Calidad', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = ControlCalidad::with('orden')->get();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["No. de orden"]         = $reporte->orden->orden;
                   $row ["Inspector"]            = $reporte->inspector;
                   $row ["Supervisor"]           = $reporte->supervisor;
                   $row ["Cantidad de conos"]    = $reporte->cantidad_cajas;
                   $row ["Lote"]                 = $reporte->lote;
                   $row ["Cantidad revisada"]    = $reporte->cantidad_revisada;
                   $row ["Aceptadas"]            = $reporte->aceptada;
                   $row ["Rechazadas"]           = $reporte->rechazada;
                   $row ["Solucion"]             = $reporte->solucion;
                   $row ["Observacion"]          = $reporte->observaciones;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteCompras(Request $request){
        \Excel::create('Compras', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Compras::with('proveedores')->get();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["No. de factura"]          = $reporte->no_factura;
                   $row ["Nit"]                     = $reporte->producto;
                   $row ["Telefono"]                = $reporte->cantidad;
                   $row ["Proveedor"]               = $reporte->proveedores->nombre;
                   $row ["Precio"]                  = $reporte->precio;
                   $row ["Fecha de compra"]         = $reporte->fecha;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteMovimientos(Request $request){
        \Excel::create('Movimientos', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Movimientos::all();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                    if ($reporte->tipo_movimiento==1) {
                    $row ["Tipo de Movimiento"] = "Ingreso";
                    } elseif ($reporte->tipo_movimiento==2){
                        $row ["Tipo de Movimiento"] = "Egreso"; 
                    }
                   
                   $row ["Monto"]                  = $reporte->monto;
                   $row ["Descripción"]            = $reporte->descripcion;
                   $row ["Fecha"]                  = $reporte->fecha;
                   $row ["No. de Cheque"]          = $reporte->no_cheque;
                   $row ["Nombre"]                 = $reporte->nombre;

                    if ($reporte->moneda==1) {
                        $row ["Moneda"] = "Quetzales";
                    } elseif ($reporte->moneda==2){
                        $row ["Moneda"] = "EgreDolaresso"; 
                    }

                    if ($reporte->cobrado==1) {
                        $row ["Cobrado"] = "Si";
                    } elseif ($reporte->cobrado==2){
                        $row ["Cobrado"] = "NO"; 
                    }
                 
                   $row ["Balance Q"]              = $reporte->balanceQ;
                   $row ["Balance D"]              = $reporte->balance_D;
                   $row ["No. de Cuerta"]          = $reporte->cuenta_id;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function ordenesfechas(Request $request){
        // dd($request);
       
        // $start_date =parse_str($request->start_date);
        // $end_date = parse_str($request->end_date);
        // dd($start_date, $end_date);     
    
        $request = Orden::whereBetween('fecha_entrega', [new Carbon($request->start_date), new Carbon($request->end_date)])->get();
        // dd($request);
        \Excel::create('Ordenes', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = $request;
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["No. de orden"]            = $reporte->orden;
                   $row ["Fecha y Hora"]            = $reporte->fecha_hora;
                   $row ["PO"]                      = $reporte->po;
                   $row ["Descripcion"]             = $reporte->descripcion;
                   $row ["Cantidad"]                = $reporte->cantidad;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function muestrasDoc(){
        return view('layouts.docmuestra');
    }

    public function reporteInventarioColorantes(Request $request){
        \Excel::create('InventarioColorante', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = InventarioColorante::with('colorante')->get();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Código"]          = $reporte->colorante->codigo;
                   $row ["Colorante"]       = $reporte->colorante->colorante;
                   $row ["Bodega"]          = $reporte->bodega;
                   $row ["Despacho"]        = $reporte->despacho;
                   $row ["Total"]           = $reporte->total;
                   $row ["Fecha"]           = $reporte->fecha;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteFacturas(Request $request){
        \Excel::create('Facturas', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Facturas::with('cliente','orden')->get();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Fecha de emisión"]  = $reporte->fecha;
                   $row ["Serie"]             = $reporte->serie;
                   $row ["No. Factura"]       = $reporte->no_factura;
                   $row ["Nombre"]            = $reporte->cliente->nombre;
                   $row ["Nit"]               = $reporte->cliente->nit;
                   $row ["Emisión en dólares"]= $reporte->emision_dolares;
                   $row ["Tipo de cambio"]    = $reporte->tipo_cambio;
                   $row ["Factura quetzalizada"] = $reporte->factura_quetzales;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteDespachos(Request $request){
        \Excel::create('Despachos', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Despachos::with('orden','orden.cliente','orden.estilo','orden.calibre','orden.metraje','orden.color','orden.lugar', 'orden.referencia','orden.tenido','orden.secado','orden.tipoOrden')->get();
                 

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Date"]             = $reporte->fecha;
                   $row ["Factory"]          = $reporte->orden->cliente->nombre;
                   $row ["PO. Numero"]       = $reporte->orden->po;
                   $row ["Style"]            = $reporte->orden->estilo->descripcion;
                   $row ["Tipo de orden"]    = $reporte->orden->tipoOrden->descripcion;
                   $row ["Calibre"]          = $reporte->orden->calibre->descripcion;
                   $row ["MTRS"]             = $reporte->orden->metraje->descripcion;
                   $row ["Color"]            = $reporte->orden->color->descripcion;
                   $row ["QTY"]              = $reporte->orden->cantidad;
                   $row ["U/Price"]          = ($reporte->orden->precio / $reporte->orden->cantidad);
                   $row ["Lugar de entrega"] = $reporte->orden->lugar->descripcion;
                   $row ["Date"]             = $reporte->orden->fecha_entrega;
                   $row ["Env#"]              = $reporte->envio;
                   $row ["QTY"]              = $reporte->orden->cantidad;
                   $row ["Amount"]           = $reporte->orden->precio;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteMuestras(Request $request){
        \Excel::create('Muestras', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Muestra::with('orden','orden.cliente','orden.estilo','orden.calibre','orden.metraje','orden.color','orden.lugar', 'orden.referencia','orden.tenido','orden.secado','orden.tipoOrden')->get();
                 

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Fecha"]            = $reporte->fecha_hora;
                   $row ["Cliente"]          = $reporte->orden->cliente->nombre;
                   $row ["Orden"]            = $reporte->orden->orden;
                   $row ["Envío"]            = $reporte->envio;
                   $row ["Rechazo"]          = $reporte->rechazo;
                   $row ["Fecha Aceptado"]   = $reporte->fecha_ok;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteOrdenesPorDia($param){
        \Excel::create('OrdenesPorDia', function($excel) use ($param){
             $excel->sheet('Datos', function($sheet) use ($param) {

                $reporte = Orden::where('fecha_hora', $param)->with('cliente','estilo','calibre','metraje','color','lugar', 'referencia','tenido','secado','tipoOrden')->get();
                 

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Date"]             = $reporte->fecha_hora;
                   $row ["Factory"]          = $reporte->cliente->nombre;
                   $row ["PO. Numero"]       = $reporte->po;
                   $row ["Style"]            = $reporte->estilo->descripcion;
                   $row ["Tipo de orden"]    = $reporte->tipoOrden->descripcion;
                   $row ["Calibre"]          = $reporte->calibre->descripcion;
                   $row ["MTRS"]             = $reporte->metraje->descripcion;
                   $row ["Color"]            = $reporte->color->descripcion;
                   $row ["QTY"]              = $reporte->cantidad;
                   $row ["U/Price"]          = ($reporte->precio / $reporte->cantidad);
                   $row ["Amount"]           = $reporte->precio;
                   $row ["Lugar de entrega"] = $reporte->lugar->descripcion;
              
                   $data[] = $row;
                }  
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteDespachosDiarios($param){
        \Excel::create('DespachosDiarios', function($excel) use ($param){
             $excel->sheet('Datos', function($sheet) use ($param) {

                $reporte = Despachos::where('fecha', $param)->with('orden','orden.cliente','orden.estilo','orden.calibre','orden.metraje','orden.color','orden.lugar', 'orden.referencia','orden.tenido','orden.secado','orden.tipoOrden')->get();

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Date"]             = $reporte->fecha;
                   $row ["Factory"]          = $reporte->orden->cliente->nombre;
                   $row ["PO. Numero"]       = $reporte->orden->po;
                   $row ["Style"]            = $reporte->orden->estilo->descripcion;
                   $row ["Tipo de orden"]    = $reporte->orden->tipoOrden->descripcion;
                   $row ["Calibre"]          = $reporte->orden->calibre->descripcion;
                   $row ["MTRS"]             = $reporte->orden->metraje->descripcion;
                   $row ["Color"]            = $reporte->orden->color->descripcion;
                   $row ["QTY"]              = $reporte->orden->cantidad;
                   $row ["U/Price"]          = ($reporte->orden->precio / $reporte->orden->cantidad);
                   $row ["Lugar de entrega"] = $reporte->orden->lugar->descripcion;
                   $row ["Fecha Entrega"]    = $reporte->orden->fecha_entrega;
                   $row ["Env#"]             = $reporte->envio;
                   $row ["QTY"]              = $reporte->orden->cantidad;
                   $row ["Amount"]           = $reporte->orden->precio;

              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteControlOrdenCafta($param, $param1){
        \Excel::create('OrdenesPorDia', function($excel) use ($param, $param1){
             $excel->sheet('Datos', function($sheet) use ($param, $param1) {

                $reporte = Orden::whereBetween('fecha_hora', [$param, $param1])->where('tipo', 2)->with('cliente','estilo','calibre','metraje','color','lugar', 'referencia','tenido','secado','tipoOrden')->get();
                 

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Date"]             = $reporte->fecha_hora;
                   $row ["Factory"]          = $reporte->cliente->nombre;
                   $row ["PO. Numero"]       = $reporte->po;
                   $row ["Style"]            = $reporte->estilo->descripcion;
                   $row ["Tipo de orden"]    = $reporte->tipoOrden->descripcion;
                   $row ["Calibre"]          = $reporte->calibre->descripcion;
                   $row ["MTRS"]             = $reporte->metraje->descripcion;
                   $row ["Color"]            = $reporte->color->descripcion;
                   $row ["QTY"]              = $reporte->cantidad;
                   $row ["U/Price"]          = ($reporte->precio / $reporte->cantidad);
                   $row ["Amount"]           = $reporte->precio;
                   $row ["Lugar de entrega"] = $reporte->lugar->descripcion;
              
                   $data[] = $row;
                }  
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }


    public function reporteOrdenEstadoCuenta($param, $param1){
        \Excel::create('OrdenesPorDia', function($excel) use ($param, $param1){
             $excel->sheet('Datos', function($sheet) use ($param, $param1) {

                $reporte = Orden::whereBetween('fecha_hora', [$param, $param1])->groupBy('id','orden','fecha_hora','id_empresa','po','id_estilo','descripcion','id_calibre','id_metraje','tipo','id_color','cantidad','balance','total_salida','amount','precio','fecha_entrega','id_referencias','id_lugar','facturado','created_at','updated_at')->with('cliente','estilo','calibre','metraje','color','lugar', 'referencia','tenido','secado','tipoOrden')->get();
                 

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Date"]             = $reporte->fecha_hora;
                   $row ["Factory"]          = $reporte->cliente->nombre;
                   $row ["PO. Numero"]       = $reporte->po;
                   $row ["Style"]            = $reporte->estilo->descripcion;
                   $row ["Tipo de orden"]    = $reporte->tipoOrden->descripcion;
                   $row ["Calibre"]          = $reporte->calibre->descripcion;
                   $row ["MTRS"]             = $reporte->metraje->descripcion;
                   $row ["Color"]            = $reporte->color->descripcion;
                   $row ["QTY"]              = $reporte->cantidad;
                   $row ["U/Price"]          = ($reporte->precio / $reporte->cantidad);
                   $row ["Amount"]           = $reporte->precio;
                   $row ["Lugar de entrega"] = $reporte->lugar->descripcion;
              
                   $data[] = $row;
                }  
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }
}

