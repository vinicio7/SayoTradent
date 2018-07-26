<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Maseo;

class MaseoController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;

    public function index() {
		try {
			$records           = Maseo::all();
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
			$validacion = Maseo::where("id_orden", $request->input('id_orden'))->first();
			if (!$validacion) {
				$record = Maseo::create([
						'id_orden'          => $request->input('id_orden'),
                        'cantidad'          => $request->input('cantidad'),
						'estado_id'         =>$request->input('estado_id'),
						'etapa_id'          =>$request->input('etapa_id'),
					]);
				if ($record) {
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Proceso de maseo creado correctamente.';
					$this->records     = $record;
				} else {
					throw new \Exception('El proceso del maseo no pudo ser creado.');
				}
			} else {
				throw new \Exception('Ya existe el proceso de maseo para esta orden.');
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
            $record = Maseo::find($id);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Proceso de maseo consultado correctamente.';
                $this->records      = $record;
            } else {
                throw new \Exception('Proceso de maseo no encontrado.');
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
            
            $record = Maseo::find($id);
            if ($record) {
                $record->cantidad             = $request->input('cantidad', $record->cantidad);
                $record->estado_id  	      = $request->input('estado_id', $record->estado_id);
                $record->etapa_id             = $request->input('etapa_id', $record->etapa_id);
                
                
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Proceso de maseo actualizada correctamente.';
                    $this->records      = $record;
                } else {
                    throw new \Exception('El proceso de maseo no pudo ser actualizada.');
                }
                } else {
                        $this->message = 'El proceso de maseo no existe.';
                        throw new \Exception('El proceso de maseo no existe.');
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
