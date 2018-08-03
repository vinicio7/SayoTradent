<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenido;
use App\Orden;

class TenidoController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;

    public function index() {
		try {
			$records           = Tenido::all();
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
			$validacion = Tenido::where("id_orden", $request->input('id_orden'))->first();
			if (!$validacion) {
				$record = Tenido::create([
						'id_orden'          => $request->input('id_orden'),
                        'cantidad'          => $request->input('cantidad'),
                        'receta'            => $request->input('receta'),
						'estado_id'         => $request->input('estado_id'),
						'etapa_id'          => $request->input('etapa_id'),

						'fecha'				=> date("Y-m-d", strtotime($request->input('fecha'))),
						'maquina'			=> $request->input('maquina'),
						'operario'			=> $request->input('operario'),
						'contenedor'		=> $request->input('contenedor'),
						'kilos'				=> $request->input('kilos'),
						'quesos'			=> $request->input('quesos'),
						'hora_ingreso'		=> $request->input('hora_ingreso'),
						'hora_salida'		=> $request->input('hora_salida'),

					]);
				if ($record) {
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Proceso de teñido creado correctamente.';
					$this->records     = $record;
				} else {
					throw new \Exception('El proceso del teñido no pudo ser creado.');
				}
			} else {
				throw new \Exception('Ya existe el proceso de teñido para esta orden.');
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
            $record = Tenido::find($id);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Registro de proceso de teñido consultado correctamente.';
                $this->records      = $record;
            } else {
                throw new \Exception('Registro de proceso de teñido no encontrado.');
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
            if ($request->input('fecha')) {
            	$a = explode("T", $request->input('fecha'));
            	$fecha = $a[0];
            } else {
            	$fecha = null;
            }
            
            $record = Tenido::find($id);      
            if ($record) {
                $record->cantidad             = $request->input('cantidad', $record->cantidad);
                $record->receta               = $request->input('receta', $record->receta);
                $record->estado_id  	      = $request->input('estado_id', $record->estado_id);
                $record->etapa_id             = $request->input('etapa_id', $record->etapa_id);

                $record->fecha             	  = $fecha;
                $record->maquina              = $request->input('maquina', $record->maquina);
                $record->operario  	      	  = $request->input('operario', $record->operario);
                $record->contenedor           = $request->input('contenedor', $record->contenedor);
                $record->kilos                = $request->input('kilos', $record->kilos);
                $record->quesos               = $request->input('quesos', $record->quesos);
                $record->hora_ingreso         = $request->input('hora_ingreso', $record->hora_ingreso);
                $record->hora_salida          = $request->input('hora_salida', $record->hora_salida);

                
                //$record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Proceso de teñido actualizada correctamente.';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El proceso de teñido no pudo ser actualizada.');
                }
                } else {
                        $this->message = 'El proceso de teñido no existe.';
                        throw new \Exception('El proceso de teñido no existe.');
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

	public function filtrotenido() {
		try {
			$records = Tenido::with('orden','secado')->where('estado_id', 2)->get();
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

	public function destroy($id) {
		try {
			$record = Tenido::find($id);
			$record2 = Orden::find($id);
			if ($record) {
				$record->estado_id = 2;
				$record->save();
				$record2->estado_prod = 1;
				$record2->save();
				$this->status_code = 200;
				$this->result      = true;
				$this->message     = 'Proceso terminado correctamente.';
			} else {
				throw new \Exception('El proceso no pudo ser encontrado.');
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
