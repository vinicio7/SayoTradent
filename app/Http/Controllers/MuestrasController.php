<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Muestra;
use App\Orden;
class MuestrasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index()
    {
        try {
            $records = Muestra::with('orden','orden.orden','orden.orden.cliente','orden.orden.coloresOrden')->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function filtrar(Request $request) {
        try {
            $nombre       = $request->input('cliente');
            $orden        = $request->input('orden');
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin    = $request->input('fecha_fin');
            if (isset($nombre)) {
                if ($nombre == 0) {
                    $records = Muestra::with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')->get();
                } else {

                    $records = Muestra::whereHas('Orden', function($query) use($nombre)
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
                    $records = Muestra::whereHas('Orden', function ($q) use($nombre)
                    {
                       $q->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                        ->where('clientes.id', '=', $nombre);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();
                } else {
                    $records = Muestra::whereHas('Orden', function ($q) use($nombre, $orden)
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

                 $records = Muestra::whereHas('Orden', function ($q) use($nombre, $orden, $fecha_inicio, $fecha_fin)
                    {
                       $q
                         ->join('clientes', 'clientes.id', '=', 'ordenes.id_empresa')
                         ->where('clientes.id', '=', $nombre)
                         ->where('ordenes.id', '=', $orden)
                         ->whereBetween('fecha_hora',[$fecha_inicio,$fecha_fin]);
                    })
                      ->with('orden', 'orden.cliente', 'orden.coloresOrden', 'orden.coloresOrden.calibre', 'orden.coloresOrden.metraje', 'orden.coloresOrden.referencia', 'orden.coloresOrden.lugar', 'orden.coloresOrden.tipoOrden', 'orden.coloresOrden.estado')
                      ->get();
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
