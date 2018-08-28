<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ColoresOrden;
use App\Orden;
use App\Cliente;
use App\Estilo;
use App\Calibre;
use App\Color;
use App\Referencia;
use App\Lugar;
use App\Metraje;
use App\Muestra;
use App\Estados;
use App\Despachos;
use App\TipoOrden;
use App\Http\Controllers\Controller;
use Validator;

class OrdenesController extends Controller
{

    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index()
    {
        try {
            $records           = ColoresOrden::with('orden','calibre','metraje','referencia','lugar','estado','orden.cliente')->orderBy('created_at','DESC')->get();
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

    public function consultarOrden($id){
        try {
            $records           = Orden::where('orden',$id)->with('cliente')->first();
            if ($records) {
                $records2 = ColoresOrden::where([['id_orden',$records->orden],['estado_prod', 0],])->with('calibre','metraje','tipoOrden')->get();
                    // dd($records2);

                // $records2 = ColoresOrden::where('id_orden',$records->orden)->with('calibre','metraje','tipoOrden')->get();
                // $var = $records->fecha_hora;
                // $date = str_replace('-', '/', $var);
                // $records->fecha_hora = date('d/m/Y', strtotime($date));
                $records->colores_orden = $records2;
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
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function tenido()
    {
        try {
            // dd("lego");
            $records           = ColoresOrden::with('calibre','metraje','tipoOrden','orden','orden.cliente','detalle_tenido','detalle_tenido.tenido')->get();
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
    

    // public function maseo()
    // {
    //     try {
    //         // dd("lego");
    //         $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado')->where('estado_prod',3)->get();
    //         $this->status_code = 200;
    //         $this->result      = true;
    //         $this->message     = 'Registros consultados correctamente';
    //         $this->records     = $records;
    //     } catch (\Exception $e) {
    //         $this->status_code = 400;
    //         $this->result      = false;
    //         $this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
    //     }finally{
    //         $response = [
    //             'result'  => $this->result,
    //             'message' => $this->message,
    //             'records' => $this->records,
    //         ];

    //         return response()->json($response, $this->status_code);
    //     }
    // }

    public function secado()
    {
        try {
            // dd("lego");
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado')->where('estado_prod',1)->get();
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

    public function enconado()
    {
        try {
            // dd("lego");
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado','enconado')->where('estado_prod',2)->get();
            // dd($records);
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

    public function maseo()
    {
        try {
            // dd("lego");
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado','enconado')->where('estado_prod',3)->get();
            // dd($records);
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

    public function control_calidad2()
    {
        try {
            // dd("lego");
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado','enconado')->where('estado_prod',4)->get();
            // dd($records);
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

    public function cliente()
    {
        try {
            $records           = Clientes::all();
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

    public function estado()
    {
        try {
            $records           = Estados::all();
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

    public function estilos()
    {
        try {
            $records           = Estilo::all();
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

    public function calibres()
    {
        try {
            $records           = Calibre::all();
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

    public function tipoOrden()
    {
        try {
            $records           = TipoOrden::all();
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

    public function metraje()
    {
        try {
            $records           = Metraje::all();
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

    public function colores()
    {
        try {
            $records           = Color::all();
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

    public function referencias()
    {
        try {
            $records           = Referencia::all();
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

    public function lugares()
    {
        try {
            $records           = Lugar::all();
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
            $record = Orden::create([
                'orden'             =>  $request->input('orden'),
                'fecha_hora'        =>  date("Y-m-d", strtotime($request->input('fecha_hora'))), 
                'id_empresa'        =>  $request->input('id_empresa'),
                'balance'           =>  $request->input('cantidad'),
                'total_salida'      =>  0,
                'precio_total'      =>  $request->input('total'),
                'amount'            =>  $request->input('total'),
                'cantidad_total'    =>  0,
                'facturado'         =>  false,
                'estado_prod'       =>  0,
                'id_estado'         =>  0,
                'hora'              =>  date('h:i:s', strtotime($request->input('fecha_hora')))
            ]);

            // $record = Orden::create([
            //     'orden'                 => $request->input('orden'),
            //     'id_estado'             => $request->input('id_estado'),
            //     'fecha_hora'       	    => date("Y-m-d", strtotime($request->input('fecha_hora'))),
            //     'id_empresa'       		=> $request->input('id_empresa'),
            //     'po'          		    => $request->input('po'),
            //     'id_estilo'          	=> $request->input('id_estilo'),
            //     'descripcion'       	=> $request->input('descripcion'),
            //     'id_calibre'       		=> $request->input('id_calibre'),
            //     'id_metraje'            => $request->input('id_metraje'),
            //     'tipo'                  => $request->input('tipo'),
            //     'color'                 => $request->input('color'),
            //     'cantidad'       		=> $request->input('cantidad'),
            //     'balance'       		=> $request->input('cantidad'),
            //     'total_salida'       	=> '0',
            //     'amount'                => '0',
            //     'precio'       		    => $request->input('precio'),
            //     'fecha_entrega'         => date("Y-m-d", strtotime($request->input('fecha_entrega'))),
            //     'id_referencias'       	=> $request->input('id_referencias'),
            //     'id_lugar'       		=> $request->input('id_lugar'),
            //     'facturado'             => false,
            //     'estado_prod'           => '0'
            // ]);
            if ($record) {
                $a = json_decode($request->input('colores_orden'));
                $b = 0;
                $c = 0;
                foreach ($a as $item) {
                    $record2 = ColoresOrden::create([

                        'id_orden'      =>  $record->orden,
                        'po'            =>  $item->po,
                        'estilo'        =>  $item->estilo,
                        'descripcion'   =>  $item->descripcion, 
                        'id_calibre'    =>  $item->id_calibre,
                        'id_metraje'    =>  $item->id_metraje,
                        'tipo'          =>  $item->tipo,
                        'color'         =>  $item->color,
                        'cantidad'      =>  $item->cantidad,
                        'referencia'    =>  $item->referencia,
                        'lugar'         =>  $item->lugar,
                        'id_estado'     =>  $item->id_estado,
                        'sub_total'     =>  $item->sub_total,
                        'precio'        => $item->precio,
                        'estado_prod'       =>  0,
                    ]);
                    $b = $b + $record2->cantidad;
                    $c = $c + $record2->sub_total;
                }
                // $record->amount = $b;
                // $record->balance = $b;
                // $record->precio_total = $c;
                $record->save();
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Registro de  orden creada correctamente';
                $this->records      = $record;
            } else {
                throw new \Exception('El registro no pudo ser creado');
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
        try {

            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registro consultado correctamente.';
            $this->records      = Orden::find($id);

        } catch (Exception $e) {
            $this->status_code  = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result'    =>  $this->result,
                'message'   =>  $this->message,
                'records'   =>  $this->records
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validator = $this->rules($request);

            if (!$validator->fails()) {

                $condominium = Orden::find($id);

                if ($condominium){

                    $condominium->update($request->all());

                    $this->records = $condominium;
                    $this->result  = true;
                    $this->message = 'Regristo actualizado exitosamente.';
                }else{
                    $this->result  = false;
                    $this->message = 'El registro no existe.';
                }
            } else {
                $this->result = false;
                $this->message = $validator->messages()->first();
            }
        } catch (Exception $e) {
            $this->status_code = 200;
            $this->result = false;
            $this->message = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result' => $this->result,
                'message' => $this->message,
                'records' => $this->records
            ];
            return response()->json($response, $this->status_code);
        }
    }

    public function destroy($id)
    {
        try {
            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registro eliminado correctamente.';
            $this->records      = Orden::find($id)->delete();

        } catch (Exception $e) {
            $this->status_code  = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result'    =>  $this->result,
                'message'   =>  $this->message,
                'records'   =>  $this->records
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function muestrastore(Request $request)
    {
        // dd($request);
        try {
            $record = Muestra::create([
                
                'fecha_hora'       	=> date("Y-m-d", strtotime($request->input('fecha_hora'))),
                'id_orden'       	=> $request->input('id_orden'),
                'envio'       		=> $request->input('envio'),
                'rechazo'           => $request->input('rechazo'),
                'fecha_ok'          =>date("Y-m-d", strtotime($request->input('fecha_ok'))),
                'id_estado'       	=> 1//$request->input('id_estado'),
                ]);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Registro de  planilla creado correctamente';
                $this->records      = $record;
            } else {
                throw new \Exception('El registro de planill no pudo ser creado');
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

    public function mostrarmuestra($id)
    {
        // dd("llego");
        try {

            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registro consultado correctamente.';
            $this->records      = Muestra::where('id_orden', $id)->with('estados')->get();

        } catch (Exception $e) {
            $this->status_code  = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result'    =>  $this->result,
                'message'   =>  $this->message,
                'records'   =>  $this->records
            ];

            return response()->json($response, $this->status_code);
        }
    }


    public function despachostore(Request $request)
    {
        // dd($request);
        try {
            $record2                 = Orden::find($request->input('id_orden'));
            if ($record2) {
                if ($request->input('cantidad') > $record2->balance ) {
                    throw new \Exception('La cantidad no puede ser mayor al balance');
                }  
            }
            $record = Despachos::create([
                
                'fecha'       	    => date("Y-m-d", strtotime($request->input('fecha'))),
                'id_orden'       	=> $request->input('id_orden'),
                'envio'       		=> $request->input('envio'),
                'cantidad'          => $request->input('cantidad'),
               
                ]);
            if ($record) {
                $record2->total_salida   = $record2->total_salida + $request->input('cantidad');
                $record2->balance        = $record2->cantidad - $record2->total_salida;
                $record2->amount         = $record2->precio * $record2->total_salida;
                
                $record2->save();
                $this->status_code      = 200;
                $this->result           = true;
                $this->message          = 'Registro de despacho creado correctamente';
                $this->records          = $record;
            } else {
                throw new \Exception('El registro de despacho no pudo ser creado');
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


    public function mostrardespacho($id)
    {
        // dd("llego");
        try {

            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registro consultado correctamente.';
            $this->records      = Despachos::where('id_orden', $id)->get();

        } catch (Exception $e) {
            $this->status_code  = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        } finally {
            $response = [
                'result'    =>  $this->result,
                'message'   =>  $this->message,
                'records'   =>  $this->records
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function ordenesPorDia($param)
    {
        try {
            $records           = Orden::where('fecha_hora', $param)->with('cliente','coloresOrden','coloresOrden.calibre')->get();
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

    public function controlOrdenCafta($param, $param1)
    {
        try {
            /*$records = Orden::whereBetween('fecha_hora', [$param, $param1])->where('coloresOrden.tipo', 2)->with('cliente','calibre','coloresOrden')->get();
*/
            $records = Orden::whereHas('ColoresOrden', function($query)
                    {
                        $query
                        ->join('tipo_orden', 'tipo_orden.id', '=', 'colores_orden.tipo')
                        ->where('colores_orden.tipo', '=', 1);
                        })->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();

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

    public function estadoCuentaOrden($param, $param1)
    {
        try {
            $records = Orden::orderBy('orden')->with('cliente', 'coloresOrden')->get();
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

    public function estadoCuentaConsumo($param, $param1)
    {
        try {
            $records = Orden::orderBy('orden')->with('cliente','coloresOrden', 'coloresOrden.tipoOrden')->get();
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

    public function ordenes(){
        try {
7
            $records = Orden::orderBy('orden')->with('cliente')->get();
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
            if (isset($nombre)) {

                if ($nombre == 0) {
                    $records = Orden::with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')->get();
                } else {

                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();

                }
            }
            if (isset($orden)) {
                if ($orden == 0) {
                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                } else {
                    $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                }
            }
            if (isset($fecha_fin)) {

                $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->whereBetween('fecha_hora',[$fecha_inicio,$fecha_fin])->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
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

    public function filtrarConsumo(Request $request) {
        try {

            $nombre       = $request->input('cliente');
            $orden        = $request->input('orden');
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin    = $request->input('fecha_fin');
            if (isset($nombre)) {

                if ($nombre == 0) {
                    $records = Orden::with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')->get();
                } else {

                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();

                }
            }
            if (isset($orden)) {
                if ($orden == 0) {
                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                } else {
                    $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                }
            }
            if (isset($fecha_fin)) {

                $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->whereBetween('fecha_hora',[$fecha_inicio,$fecha_fin])->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
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

    public function filtrarCafta(Request $request) {
        try {

            $nombre       = $request->input('cliente');
            $orden        = $request->input('orden');
            $fecha_inicio = $request->input('fecha_inicio');
            $fecha_fin    = $request->input('fecha_fin');
            $estado       = $request->input('estado');
            if (isset($nombre)) {

                if ($nombre == 0) {
                    $records = Orden::with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')->get();
                } else {

                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();

                }
            }
            if (isset($orden)) {
                if ($orden == 0) {
                    $records = Orden::where('id_empresa','=',$nombre)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                } else {
                    $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                }
            }
            if (isset($fecha_fin)) {

                $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->whereBetween('fecha_hora',[$fecha_inicio,$fecha_fin])->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
            }
            if (isset($estado)) {
                if ($estado == 0) {
                    $records = Orden::where('id_empresa','=',$nombre)->where('ordenes.id', '=', $orden)->whereBetween('fecha_hora',[$fecha_inicio,$fecha_fin])->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
                        ->get();
                } else {
                    $records = $records = Orden::join('colores_orden', function ($q) use($nombre, $orden, $fecha_inicio, $fecha_fin, $estado)
                    {
                       $q->on('colores_orden.id_orden', '=', 'ordenes.orden')
                         ->join('estados', 'estados.id', '=', 'colores_orden.id_estado')
                         ->where('ordenes.id_empresa', '=', $nombre)
                         ->where('ordenes.id', '=', $orden)
                         ->whereBetween('ordenes.fecha_hora',[$fecha_inicio,$fecha_fin])
                         ->where('colores_orden.id_estado', '=', $estado);
                    })
                      ->with('cliente', 'coloresOrden', 'coloresOrden.calibre', 'coloresOrden.metraje', 'coloresOrden.referencia', 'coloresOrden.lugar', 'coloresOrden.tipoOrden', 'coloresOrden.estado')
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
