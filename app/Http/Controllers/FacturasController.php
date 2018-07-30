<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Facturas;
use App\Orden;

class FacturasController extends Controller
{
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index()
    {

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
