<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Compras;

class ComprasController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;
    
    public function index() {
		try {
			$records           = Compras::with('proveedores')->get();
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
        // dd($request);
		try {
			$validacion = Compras::where("no_factura", $request->input('no_factura'))->first();
			if (!$validacion) {
				$record = Compras::create([
						'no_factura'         => $request->input('no_factura'),
                        'producto'           => $request->input('producto'),
                        'cantidad'           => $request->input('cantidad'),
                        'id_proveedor'       => $request->input('id_proveedor'),
                        'precio'             => $request->input('precio'),
                        'fecha'              =>date("Y-m-d", strtotime($request->input('fecha'))),
					]);
				if ($record) {
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Compra creado correctamente.';
					$this->records     = $record;
				} else {
					throw new \Exception('La compra no pudo ser creado.');
				}
			} else {
				throw new \Exception('Ya existe el mismo numero de factura.');
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
			$record = Compras::find($id);
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
            $validacion = Compras::where('no_factura',$request->input('no_factura'))->first();                   
            if ($validacion == true && $validacion->id != $id) {
                throw new \Exception('Ya existe esta factura de compra.');
            } else {
            $record = Compras::find($id);
            if ($record) {
                $record->no_factura             = $request->input('no_factura', $record->no_factura);
                $record->producto               = $request->input('producto', $record->producto);
                $record->cantidad  	            = $request->input('cantidad', $record->cantidad);
                $record->id_proveedor           = $request->input('id_proveedor', $record->id_proveedor);
                $record->precio                 = $request->input('precio', $record->precio);
                $record->fecha  	            = date("Y-m-d", strtotime($request->input('fecha', $record->fecha)));
                
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Compra actualizada correctamente.';
                    $this->records      = $record;
                } else {
                    throw new \Exception('La compra no pudo ser actualizada.');
                }
                } else {
                        $this->message = 'La compra no existe';
                        throw new \Exception('La compra no existe');
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
			$record = Compras::find($id);
			if ($record) {
				$record->delete();
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Compra eliminado correctamente.';
			} else {
				throw new \Exception('La compra no pudo ser encontrada.');
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
