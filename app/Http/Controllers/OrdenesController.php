<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Orden;
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
            $records           = Orden::with('empresa','estilo','calibre','metraje','color','referencia','lugar')->get();
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

    public function empresas()
    {
        try {
            $records           = Empresa::all();
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
        try
        {
            $validator = $this->rules($request);
            if (!$validator->fails()) {
                $this->records = Orden::create($request->all());
                $this->result  = true;
                $this->message = 'Registro creado exitosamente.';
            } else {
                $this->result = false;
                $this->message = $validator->messages()->first();
            }
        }
        catch(Exception $e)
        {
            $this->status_code  = 200;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
        }
        finally
        {
            $response = [
                'result'    =>  $this->result,
                'message'   =>  $this->message,
                'records'   =>  $this->records
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

        private function rules($request)
        {
            switch ($request->method())
            {
                case 'GET':
                case 'POST':
                    {
                        return Validator::make($request->all(), [
                            'orden'              => 'required',
                            'fecha_hora'         => 'required',
                            'id_empresa'         => 'required',
                            'po'                 => 'required',
                            'id_estilo'          => 'required',
                            'descripcion'        => 'required',
                            'id_calibre'         => 'required',
                            'id_metraje'         => 'required',
                            'tipo'               => 'required',
                            'id_color'           => 'required',
                            'cantidad'           => 'required',
                            'estado'             => 'required',
                            'precio'             => 'required',
                            'fecha_entrega'      => 'required',
                            'fecha_aprobacion'   => 'required',
                            'id_referencias'     => 'required',
                            'id_lugar'           => 'required'
                        ]);
                    }
                case 'PUT':
                    {
                        return Validator::make($request->all(), [
                            'cantidad'          => 'required',
                            'cliente'           => 'required',
                            'color'             => 'required',
                            'descripcion'       => 'required',
                            'empresa'           => 'required',
                            'estado'            => 'required',
                            'estilo'            => 'required',
                            'fecha_hora'        => 'required',
                            'lugar_entrega'     => 'required',
                            'metraje'           => 'required',
                            'orden '            => 'required',
                            'po'                => 'required',
                            'precio'            => 'required',
                            'referencias '      => 'required',
                            'tipo'               => 'required'
                        ]);
                    }
                case 'PATCH':
                case 'DELETE':
                default: break;
            }
        }
}
