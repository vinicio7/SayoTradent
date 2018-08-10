<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Movimientos;
use App\Cuentas;
use DB;
class MovimientosController extends Controller
{
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
    protected $status_code = 400;
    protected $total_dolares   = 0;
    protected $total_quetzales = 0;
    
    public function index() {
		try {
			$records           = Movimientos::with('cuenta')->get();
			$suma_quetzales    = DB::table('movimientos')->where('tipo_movimiento', 1)->where('moneda',1)->get()->sum('monto');
			$suma_dolares	   = DB::table('movimientos')->where('tipo_movimiento', 1)->where('moneda',2)->get()->sum('monto');

			$resta_quetzales    = DB::table('movimientos')->where('tipo_movimiento', 2)->where('moneda',1)->get()->sum('monto');

			$resta_dolares      = DB::table('movimientos')->where('tipo_movimiento', 2)->where('moneda',2)->get()->sum('monto');
			
			$total_quetzales = $suma_quetzales - $resta_quetzales;
			$total_dolares   = $suma_dolares   - $resta_dolares;


			$this->status_code = 200;
			$this->result      = true;
			$this->message     = 'Registros consultados correctamente';
			$this->records     = $records;
			$this->total_dolares   = $total_dolares;
			$this->total_quetzales = $total_quetzales;
		} catch (\Exception $e) {
			$this->status_code = 400;
			$this->result      = false;
			$this->message     = env('APP_DEBUG')?$e->getMessage():$this->message;
		}finally{
			$response = [
				'result'  => $this->result,
				'message' => $this->message,
				'records' => $this->records,
				'total_dolares' => $this->total_dolares,
				'total_quetzales' => $this->total_quetzales,
			];

			return response()->json($response, $this->status_code);
		}
	}
	 public function cuentas()
    {
        try {
            $records           = Cuentas::all();
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
			$cuenta = explode(" -", $request->input('cuenta_id'));
			$fecha  = date_create($request->input('fecha'));
			$ingreso = Movimientos::where('tipo_movimiento', 1)->get()->last();
			$egreso = Movimientos::where('tipo_movimiento', 2)->get()->last();
			
            $record = Movimientos::create([
                    'tipo_movimiento'       => $request->input('tipo_movimiento'),
                    'monto'                 => $request->input('monto'),
                    'descripcion'           => $request->input('descripcion'),
                    'fecha'      		    => $fecha->format('Y-m-d'),
                    'no_cheque'             => $request->input('no_cheque'),
                    'nombre'   		        => $request->input('nombre'),
                    'moneda'                => $request->input('moneda'),
                    'cobrado'    		    => $request->input('cobrado'),
                    // 'balanceQ'              => $balanceQ,
                    // 'balance_D'             => $balanceD,
                    'cuenta_id'             => $cuenta[0],
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
			$record = MovimientosController::find($id);
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
              
                $record->fecha     		    = date("Y-m-d", strtotime($request->input('fecha')));
                $record->no_cheque          = $request->input('no_cheque', $record->no_cheque);
                $record->nombre  		    = $request->input('nombre', $record->nombre);
                $record->moneda             = $request->input('moneda',$record->moneda);
                $record->cobrado    		= $request->input('cobrado',$record->cobrado );
                // $record->balanceQ           = $request->input('balanceQ',$record->balanceQ);
                // $record->balance_D          = $request->input('balance_D',$record->balance_D);
                $record->cuenta_id          = $request->input('cuenta_id',$record->cuenta_id );
   //              if ($request->input('tipo_movimiento') == 1) {
			// 	if ($request->input('moneda') == 1) {
			// 		$balanceQ  = intval($ultimo->balanceQ)  + intval($request->input('monto')); 
			// 	} else {
			// 		$balance_D = intval($ultimo->balance_D) + intval($request->input('monto')); 
			// 	}
			// } else {
			// 	if ($request->input('moneda') == 1) {
			// 		$balanceQ  = intval($ultimo->balanceQ)  - intval($request->input('monto')); 
			// 	} else {
			// 		$balance_D = intval($ultimo->balance_D) - intval($request->input('monto')); 
			// 	}
			// }

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
