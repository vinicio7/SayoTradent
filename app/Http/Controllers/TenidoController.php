<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tenido;
use App\ColoresOrden;
use App\detalle_tenido;

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

	public function recetas_proceso(Request $request) {
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
	
	public function rechazar_proceso(Request $request) {
		try {
			$detalle = json_decode($request->input('detalle'));
			$id_tenido = $request->input('id_tenido');

			detalle_tenido::where('id_tenido', $id_tenido)->update(['estado' => 0]);
			foreach($detalle as $item) {
				$registro = ColoresOrden::find($item->orden->id);
				$registro->estado_prod = 0;
				$registro->save();
			}

			$this->status_code = 200;
			$this->result      = true;
			$this->message     = 'Proceso rechazado exitosamente';
			$this->records     = null;
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

	
	public function recetas(Request $request) {
		try {
			$records           = detalle_tenido::where('id_tenido', $request->input('id_tenido'))->with('tenido','orden')->get();

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
	
	public function rechazos(Request $request) {
		try {
			$records = detalle_tenido::where('color', $request->input('color'))->with('tenido', 'orden')->get();

			$this->status_code = 200;
			$this->result      = true;
			$this->message     = 'Registros consultados correctamente';
			$this->records     = $records;
		}
		catch(\Exception $e) {
			$this->status_code = 200;
			$this->result      = false;
			$this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
		}
		finally {
			$response = [
				'result'  => $this->result,
				'message' => $this->message,
				'records' => $this->records,
			];

			return response()->json($response, $this->status_code);
		}
	}

  
  public function consultarTenidas( Request $request) {
		try {
			$records           = detalle_tenido::where('id_color',$request->input('id'))->with('color','color.orden','color.orden.cliente','color.calibre','color.metraje')->get();
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
			// $validacion = Tenido::where("id_orden", $request->input('id_orden'))->first();
			// $tenido = 
			// $detalle = detalle_tenido::where('id_color',$request->input('id_color'))->get(); 
			if (true) {
				$record = Tenido::create([
						'id_orden'          => 0,
						'cantidad'          => $request->input('cantidad'),
						'receta'            => $request->input('receta'),
						'estado_id'         => 1,
						'etapa_id'          => 1,
						'fecha'				=> date("Y-m-d", strtotime($request->input('fecha'))),
						'maquina'			=> $request->input('maquina'),
						'operario'			=> $request->input('operario'),
						'contenedor'		=> $request->input('contenedor'),
						'kilos'				=> $request->input('kilos'),
						'quesos'			=> $request->input('quesos'),
						'hora_ingreso'		=> $request->input('hora_ingreso'),
						'hora_salida'		=> $request->input('hora_salida'),
						'tipo'				=> $request->input('tipo')
					]);
					$array  = json_decode($request->input('colores_tenido'));

					foreach ($array as $item) {
						$kilos = ($item->para_tenir * $record->kilos) / $record->cantidad;
						$quesos = ($item->para_tenir * $record->quesos) / $record->cantidad;
						$record2 = ColoresOrden::where('estilo',$item->estilo)->first();
						if ($record2) {
							$record2->estado_id 	= 1;
							$record2->estado_prod   = 1;
							$record2->id_estado 	= 1;
							$record2->save();
						}
						$validar = detalle_tenido::where('color',$item->estilo)->where('estado', 1)->first();
						if ($validar) {
							$total = count($array);
							$nuevo = detalle_tenido::create([
								'id_tenido'           => $record->id,
								'estado'          	 => 1,

								'cantidad_tenida'    => $validar->cantidad_tenida + $item->para_tenir,

								'etapa'              => $validar->etapa + 1,
								'kilos'				 => $kilos,
								'quesos'          	 => $quesos,
								'color'				 => $item->estilo,
							]);
						} else {
							$nuevo = detalle_tenido::create([
								'id_tenido'           => $record->id,
								'estado'          	 => 1,
								'cantidad_tenida'    => $item->para_tenir,
								'etapa'              => 1,
								'kilos'				 => $kilos,
								'quesos'          	 => $quesos,
								'color'				 => $item->estilo
							]);
						}
					}
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

	public function buscar($id) {
		try {
			$records = Tenido::where('id_orden', $id)->with('orden')->get();
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
		// dd($id);
		try {
			// $record = Tenido::find($id);
			$record2 = Orden::find($id);
			// dd($record2);
			if ($record2) {
				// $record->estado_id = 2;
				// $record->save();
				$record2->estado_prod = 1;
				$record2->id_estado = 2;
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
