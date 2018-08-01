<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado')->get();
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
            $records           = Orden::with('cliente','estilo','calibre','metraje','color','referencia','lugar','tenido','secado')->where('estado_prod',0)->get();
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
                'orden'                 => $request->input('orden'),
                'id_estado'             => $request->input('id_estado'),
                'fecha_hora'       	    => date("Y-m-d", strtotime($request->input('fecha_hora'))),
                'id_empresa'       		=> $request->input('id_empresa'),
                'po'          		    => $request->input('po'),
                'id_estilo'          	=> $request->input('id_estilo'),
                'descripcion'       	=> $request->input('descripcion'),
                'id_calibre'       		=> $request->input('id_calibre'),
                'id_metraje'            => $request->input('id_metraje'),
                'tipo'                  => $request->input('tipo'),
                'id_color'              => $request->input('id_color'),
                'cantidad'       		=> $request->input('cantidad'),
                'balance'       		=> $request->input('cantidad'),
                'total_salida'       	=> '0',
                'amount'                => '0',
                'precio'       		    => $request->input('precio'),
                'fecha_entrega'         => date("Y-m-d", strtotime($request->input('fecha_entrega'))),
                'id_referencias'       	=> $request->input('id_referencias'),
                'id_lugar'       		=> $request->input('id_lugar'),
                'facturado'             => false,
                'estado_prod'           => 0
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
            $record = Despachos::create([
                
                'fecha'       	    => date("Y-m-d", strtotime($request->input('fecha'))),
                'id_orden'       	=> $request->input('id_orden'),
                'envio'       		=> $request->input('envio'),
                'cantidad'          => $request->input('cantidad'),
               
                ]);
            if ($record) {
                $record                 = Orden::find($request->input('id_orden'));
                $record->total_salida   = $record->total_salida + $request->input('cantidad');
                $record->balance        = $record->balance - $record->total_salida;
                $record->amount         = $record->precio * $record->total_salida;
                
                $record->save();
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
            $records           = Orden::where('fecha_hora', $param)->with('cliente')->get();
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
            $records = Orden::whereBetween('fecha_hora', [$param, $param1])->where('tipo', 2)->with('cliente')->get();
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
            $records = Orden::whereBetween('fecha_hora', [$param, $param1])->orderBy('orden')->with('cliente')->get();
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
            $records = Orden::whereBetween('fecha_hora', [$param, $param1])->orderBy('orden')->with('cliente','estilo','tipoOrden')->get();
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

}
