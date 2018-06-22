<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimientos;

class MovimientosController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;
    
    public function index() {
		try {
			$records           = Movimientos::all();
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
		
            $record = Movimientos::create([
                    'tipo_movimiento'       => $request->input('tipo_movimiento'),
                    'monto'                 => $request->input('monto'),
                    'descripcion'           => $request->input('descripcion'),
                    'saldo'                 => $request->input('saldo'),
                ]);
            if ($record) {
                $this->status_code = 200;
                $this->result      = true;
                $this->message     = 'Movimiento creado correctamente.';
                $this->records     = $record;
            } else {
                throw new \Exception('El movimiento no pudo ser creado.');
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
			$record = Movimientos::find($id);
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
            
            $record = Movimientos::find($id);
            if ($record) {
                $record->tipo_movimiento    = $request->input('tipo_movimiento', $record->tipo_movimiento);
                $record->monto              = $request->input('monto', $record->monto);
                $record->descripcion  	    = $request->input('descripcion', $record->descripcion);
                $record->saldo  	        = $request->input('saldo', $record->saldo);
                
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Movimiento actualizado correctamente';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El movimiento no pudo ser actualizado');
                }
                } else {
                        $this->message = 'El movimiento no existe';
                        throw new \Exception('El movimiento no existe');
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
			$record = Movimientos::find($id);
			if ($record) {
				$record->delete();
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Movimiento eliminado correctamente.';
			} else {
				throw new \Exception('El movimiento no pudo ser encontrado.');
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
