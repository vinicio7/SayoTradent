<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturas;
use App\Orden;
use App\ColoresOrden;
use DB;

class FacturasController extends Controller
{
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index()
    {   
         try {
            // $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado','estado')->orderBy('created_at','DESC')->groupBy('orden')->get();
            $records    = ColoresOrden::with('calibre','metraje','tipoOrden','orden','orden.cliente')->where('estado_prod',4)->where('estado_id',2)->get();

            // dd($records);
            // $array = array();
            // foreach ($records as $item) {
            //     $item2 =  Orden::with('cliente','coloresOrden','coloresOrden.calibre','coloresOrden.metraje','coloresOrden.estado')->where('orden',$item->orden)->first();
            //     $item2->precio_total = $item->precio;
            //     array_push($array, $item2);
            // }
            // $news_records = $array;
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
        try {
            $record = Facturas::create([
                'orden_id'              => $request->input('orden_id'),
                'serie'       	    	=> $request->input('serie'),
                'no_factura'       		=> $request->input('no_factura'),
                'cliente_id'          	=> $request->input('cliente_id'),
                'emision_dolares'       => $request->input('emision_dolares'),
                'tipo_cambio'       	=> $request->input('tipo_cambio'),
                'factura_quetzales'     => $request->input('factura_quetzales'),
                'fecha'            		=> date("Y-m-d", strtotime($request->input('fecha'))),
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
        }
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
}
