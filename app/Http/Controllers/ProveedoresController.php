<?php

namespace App\Http\Controllers;

use App\Proveedores;
use Illuminate\Http\Request;
use DB;

class ProveedoresController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;
    
    public function index() {
		try {
			$records           = Proveedores::all();
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
			$validacion = Proveedores::where("nombre", $request->input('nombre'))->first();
			if (!$validacion) {
				$record = Proveedores::create([
						'nombre'        => $request->input('nombre'),
                        'nit'           => $request->input('nit'),
                        'descripcion'   => $request->input('descripcion'),
					]);
				if ($record) {
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Proveedor creado correctamente.';
					$this->records     = $record;
				} else {
					throw new \Exception('El proveedor no pudo ser creado.');
				}
			} else {
				throw new \Exception('Ya existe este proveedor.');
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
			$record = Proveedores::find($id);
			if ($record) {
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Cuenta consultado correctamente';
				$this->records     = $record;
			} else {
				throw new \Exception('Cuenta no encontrado');
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
            $validacion = Proveedores::where('nombre',$request->input('nombre'))->first();                   
            if ($validacion == true && $validacion->id != $id) {
                throw new \Exception('Ya existe este proveedor.');
            } else {
            $record = Proveedores::find($id);
            if ($record) {
                $record->nombre         = $request->input('nombre', $record->nombre);
                $record->nit            = $request->input('nit', $record->nit);
                $record->descripcion  	= $request->input('descripcion', $record->descripcion);
                
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Proveedor actualizado correctamente';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El proveedor no pudo ser actualizado');
                }
                } else {
                        $this->message = 'El proveedor no existe';
                        throw new \Exception('El proveedor no existe');
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
			$record = Proveedores::find($id);
			if ($record) {
				$record->delete();
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Proveedor eliminado correctamente.';
			} else {
				throw new \Exception('El proveedor no pudo ser encontrado.');
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
