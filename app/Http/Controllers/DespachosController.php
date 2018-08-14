<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Despachos;
use App\Orden;
use App\Clientes;
use DB;

class DespachosController extends Controller
{
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index()
    {
        try {
            $records = Despachos::with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')->get();
            $this->status_code = 200;
            $this->result      = true;
            $this->message     = 'Registros consultados correctamente';
            $this->records     = $records;
        } catch (\Exception $e) {
            $this->status_code = 400;
            $this->result      = false;
            $this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
        }finally{
            $response = [
                'result'  => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }
    public function store(Request $request)
    {
        /*try {
            $record = Facturas::create([
                'orden_id'              => $request->input('orden_id'),
                'serie'                 => $request->input('serie'),
                'no_factura'            => $request->input('no_factura'),
                'cliente_id'            => $request->input('cliente_id'),
                'emision_dolares'       => $request->input('emision_dolares'),
                'tipo_cambio'           => $request->input('tipo_cambio'),
                'factura_quetzales'     => $request->input('factura_quetzales'),
                'fecha'                 => date("Y-m-d", strtotime($request->input('fecha'))),
                ]);
            if ($record) {

                $orden = Orden::find($request->input('orden_id'));

                if ($orden){
                    $orden->facturado = true;
                    $orden->save();
                }else{
                    $this->result  = false;
                    $this->message = 'El registro no existe.';
                }

                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Orden facturada';
                $this->records      = $record;
            } else {
                throw new \Exception('No se pudo facturar');
            }
        } catch (\Exception $e) {
            $this->status_code  = 400;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result'  => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }*/
    }

    public function show($id)
    {
        
    }

    public function update(Request $request, $id)
    {
        
    }

    public function destroy($id)
    {
    }

    public function despachosDiarios($param)
    {
        try {
            $records           = Despachos::where('fecha', $param)->with('orden', 'orden.cliente', 'orden.color','orden.estilo', 'orden.calibre')->get();
            $this->status_code = 200;
            $this->result      = true;
            $this->message     = 'Registros consultados correctamente';
            $this->records     = $records;
        } catch (\Exception $e) {
            $this->status_code = 400;
            $this->result      = false;
            $this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
        }finally{
            $response = [
                'result'  => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function filtrar(Request $request) {
        try {
            $nombre       = $request->input('cliente');
            $orden        = $request->input('orden');
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin    = $request->input('fecha_fin');
            $estado       = $request->input('estado');
            if (isset($nombre)) {
                if ($nombre == 0) {
                    $records = Despachos::with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')->get();
                } else {

                    $records = Despachos::whereHas('Orden', function($query) use($nombre)
                    {
                        $query
                        ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                        ->where('clientes.id', '=', $nombre);
                        })->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                        ->get();

                }
            }
            if (isset($orden)) {
                if ($orden == 0) {
                    $records = Despachos::whereHas('Orden', function ($q) use($nombre)
                    {
                       $q->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                        ->where('clientes.id', '=', $nombre);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();
                } else {
                    $records = Despachos::whereHas('Orden', function ($q) use($nombre, $orden)
                    {
                       $q
                         ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                         ->where('clientes.id', '=', $nombre)
                         ->where('ordenes.id', '=', $orden);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();
                }
            }
            if (isset($fecha_fin)) {

                 $records = Despachos::whereHas('Orden', function ($q) use($nombre, $orden, $fecha_inicio, $fecha_fin)
                    {
                       $q
                         ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                         ->where('clientes.id', '=', $nombre)
                         ->where('ordenes.id', '=', $orden)
                         ->whereBetween('fecha',[$fecha_inicio,$fecha_fin]);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();
            }
            if (isset($estado)) {
                if ($estado == 0) {

                    $records = Despachos::whereHas('Orden', function ($q) use($nombre, $orden, $fecha_inicio, $fecha_fin)
                    {
                       $q
                         ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                         ->where('clientes.id', '=', $nombre)
                         ->where('ordenes.id', '=', $orden)
                         ->whereBetween('fecha',[$fecha_inicio,$fecha_fin]);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();   
                } else {
                    $records = $records = Despachos::whereHas('orden', function ($q) use($nombre, $orden, $fecha_inicio, $fecha_fin, $estado)
                    {
                       $q
                         ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                         ->join('colores_orden', 'colores_orden.id_orden', '=', 'ordenes.orden')
                         ->join('estados', 'estados.id', '=', 'colores_orden.id_estado')
                         ->where('clientes.id', '=', $nombre)
                         ->where('ordenes.id', '=', $orden)
                         ->whereBetween('fecha',[$fecha_inicio,$fecha_fin])
                         ->where('estados.id', '=', $estado);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get(); 
                }
            }
            $this->status_code = 200;
            $this->result      = true;
            $this->message     = 'Registros consultados correctamente';
            $this->records     = $records;
        } catch (\Exception $e) {
            $this->status_code = 400;
            $this->result      = false;
            $this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
        }finally{
            $response = [
                'result'  => $this->result,
                'message' => $this->message,
                'records' => $this->records
            ];

            return response()->json($response, $this->status_code);
        }
    }

}
