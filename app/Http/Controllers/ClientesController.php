<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clientes;

class ClientesController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;
    
    public function index() {
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

	public function store(Request $request) {
		try {
			$validacion = Clientes::where("nit", $request->input('nit'))->first();
			if (!$validacion) {
				$record = Clientes::create([
						'nombre'        => $request->input('nombre'),
                        'nit'           => $request->input('nit'),
                        'telefono'      => $request->input('telefono'),
                        'direccion'     => $request->input('direccion'),
						'credito'       => $request->input('credito'  ),
						'tiempo_estimado'       => $request->input('tiempo_estimado'  ),
					]);
				if ($record) {
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Cliente creado correctamente.';
					$this->records     = $record;
				} else {
					throw new \Exception('El cliente no pudo ser creado.');
				}
			} else {
				throw new \Exception('Ya existe este cliente.');
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

	public function show($id) {
		try {
			$record = Clientes::find($id);
			if ($record) {
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Cliente consultado correctamente';
				$this->records     = $record;
			} else {
				throw new \Exception('Cliente no encontrado');
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

	public function update(Request $request, $id) {
		try {
            $validacion = Clientes::where('nit',$request->input('nit'))->first();                   
            if ($validacion == true && $validacion->id != $id) {
                throw new \Exception('Ya existe este cliente.');
            } else {
            $record = Clientes::find($id);
            if ($record) {
                $record->nombre        		 	= $request->input('nombre', $record->nombre);
                $record->nit            		= $request->input('nit', $record->nit);
                $record->telefono       		= $request->input('telefono', $record->telefono);
                $record->direccion      		= $request->input('direccion', $record->direccion);
                $record->credito  	    		= $request->input('credito', $record->credito);
				$record->tiempo_estimado  	    = $request->input('tiempo_estimado', $record->tiempo_estimado);

                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Cliente actualizado correctamente';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El cliente no pudo ser actualizado');
                }
                } else {
                        $this->message = 'El cliente no existe';
                        throw new \Exception('El cliente no existe');
                }
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
	

	public function destroy($id) {
		try {
			$record = Clientes::find($id);
			if ($record) {
				$record->delete();
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Cliente eliminado correctamente.';
			} else {
				throw new \Exception('El cliente no pudo ser encontrado.');
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

}