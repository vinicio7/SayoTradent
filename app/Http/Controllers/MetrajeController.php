<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Metraje;

class MetrajeController extends Controller
{
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index() {
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
    
    public function store(Request $request) {
        try {
            $validacion = Metraje::where("descripcion", $request->input('descripcion'))->first();
            if (!$validacion) {
                $record = Metraje::create([
                        'descripcion'          => $request->input('descripcion')
                    ]);
                if ($record) {
                    $this->status_code = 200;
                    $this->result      = true;
                    $this->message     = 'Metraje creado correctamente.';
                    $this->records     = $record;
                } else {
                    throw new \Exception('El metraje no pudo ser creado.');
                }
            } else {
                throw new \Exception('Ya existe el código de metraje.');
            }
            

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

    public function show($id){
       try {
            $record = Metraje::find($id);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'El metraje no existe.';
                $this->records      = $record;
            } else {
                throw new \Exception('El metraje no existe.');
            }
        } 
        catch (\Exception $e) {
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


    public function update(Request $request, $id) {
        try {
            $record = Metraje::find($id);
            if ($record) {
                $record->descripcion  = $request->input('descripcion', $record->descripcion);
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Metraje actualizado correctamente.';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El metraje no pudo ser actualizado.');
                }
                } else {
                        $this->message = 'El metraje a modificar no existe.';
                        throw new \Exception('El metraje a modificar no existe.');
                }
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

    public function destroy($id){
        try {
            $record = Metraje::find($id);
            if ($record) {
                $record->delete();
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Metraje eliminada correctamente';
            } else {
                throw new \Exception('El metraje no pudo ser encontrado');
            }
        } 
        catch (\Exception $e) {
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
}
