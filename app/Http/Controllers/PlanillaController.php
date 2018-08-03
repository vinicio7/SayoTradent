<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planilla;
use DB;
use App\DetallePlanilla;

class PlanillaController extends Controller{
  
    protected $result      = false;
    protected $message     = 'Ocurrió un problema al procesar su solicitud';
    protected $records     = array();
    protected $status_code = 400;

    public function index(){
        try {
            $records = Planilla::all();
            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registros de planilla consultados correctamente.';
            $this->records      = $records;
        } catch (\Exception $e) {
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

    public function consultar(Request $request){
        try {
            $planilla = Planilla::where('no_empleado',$request->input('no_empleado'))->first();
            if ($planilla) {
                $detalle = DetallePlanilla::where('id_planilla',$planilla->id)->where('quincena',$request->input('quincena'))->where('mes',$request->input('mes'))->first();
                if ($detalle) {
                    $detalle = $detalle;
                    throw new \Exception('Los registros para esta planilla ya existen');
                } else {
                    $detalle = [];
                }
            } else {
                $detalle = [];
            }
            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registros de planilla consultados correctamente.';
            $this->records      = $detalle;
        } catch (\Exception $e) {
            $this->status_code  = 400;
            $this->result       = false;
            $this->message      = env('APP_DEBUG') ? $e->getMessage() : $this->message;
            $this->records      = $detalle;
        } finally {
            $response = [
                'result'  => $this->result,
                'message' => $this->message,
                'records' => $this->records,
            ];

            return response()->json($response, $this->status_code);
        }
    }

    public function store(Request $request){
//         dd($request);
            try {
                $validacion = Planilla::where('no_empleado',$request->input('no_empleado'))->first();
                if (!$validacion) {
                    $record = (new Planilla)->create([
                        'no_empleado'               => $request->input('no_empleado'),
                        'nombre'       			    => $request->input('nombre'),
                        'calcular_bono'             => $request->input('calcular_bono'),
                        // 'dias_trabajados'           => $request->input('dias_trabajados'),
                        // 'horas_ex_dia'          	=> $request->input('horas_ex_dia'),
                        // 'horas_ex_noche'          	=> $request->input('horas_ex_noche'),
                        // 'sueldo_base'       		=> $request->input('sueldo_base'),
                        // 'sueldo_ex_dia'       		=> $request->input('sueldo_ex_dia'),
                        // 'sueldo_ex_noche'           => $request->input('sueldo_ex_noche'),
                        // 'total_ex'                  => $request->input('total_ex'),
                        // 'bon_legal'                 => $request->input('bon_legal'),
                        // 'bon_inc_base'       		=> $request->input('bon_inc_base'),
                        // 'incentivo_pn'       		=> $request->input('incentivo_pn'),
                        // 'incentivo_as'       		=> $request->input('incentivo_as'),
                        // 'incentivo_pn1'       		=> $request->input('incentivo_pn1'),
                        // 'incentivo_as1'       		=> $request->input('incentivo_as1'),
                        // 'total_bn_inc'       		=> $request->input('total_bn_inc'),
                        // 'total_ingresos'       		=> $request->input('total_ingresos'),
                        // 'igss'       		        => $request->input('igss'),
                        // 'isr'       		        => $request->input('isr'),
                        // 'otros_descuentos'       	=> $request->input('otros_descuentos'),
                        // 'total_descuentos'       	=> $request->input('total_descuentos'),
                        // 'total'       		        => $request->input('total'),
                        'sueldo_base'       		=> $request->input('sueldo_base'),
                        ]);
                    if ($record) {
                        $this->status_code  = 200;
                        $this->result       = true;
                        $this->message      = 'Registro de  planilla creado correctamente';
                        $this->records      = $record;
                    } else {
                        throw new \Exception('El registro no pudo ser creado');
                    }
                } else {
                    throw new \Exception('Ya existe un registro con ese número de empleado');
                }
            } catch (\Exception $e) {
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


    public function show($id){
        try {
            $record = DetallePlanilla::find($id);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Registro de planillo consultado correctamente.';
                $this->records      = $record;
            } else {
                throw new \Exception('Registro planilla no encontrado.');
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


    public function update(Request $request, $id){
        try {
            $validacion = Planilla::find($id);
            // dd($validacion);
            if ($validacion) {
                $new_record = (new DetallePlanilla)->create([
                        'sueldo_ordinario'          => $request->input('sueldo_ordinario'),
                        'id_planilla'               => $validacion->id,
                        'mes'                       => $request->input('mes'),
                        'quincena'                  => $request->input('quincena'),
                        'dias_trabajados'           => $request->input('dias_trabajados'),
                        'horas_ex_dia'              => $request->input('horas_ex_dia'),
                        'horas_ex_noche'            => $request->input('horas_ex_noche'),
                        // 'sueldo_base'               => $request->input('sueldo_base'),
                        'sueldo_ex_dia'             => $request->input('sueldo_ex_dia'),
                        'sueldo_ex_noche'           => $request->input('sueldo_ex_noche'),
                        'total_ex'                  => $request->input('total_ex'),
                        'bon_legal'                 => $request->input('bon_legal'),
                        'bon_inc_base'              => $request->input('bon_inc_base'),
                        'incentivo_pn'              => $request->input('incentivo_pn'),
                        'incentivo_as'              => $request->input('incentivo_as'),
                        'incentivo_pn1'             => $request->input('incentivo_pn1'),
                        'incentivo_as1'             => $request->input('incentivo_as1'),
                        'total_bn_inc'              => $request->input('total_bn_inc'),
                        'total_ingresos'            => $request->input('total_ingresos'),
                        'igss'                      => $request->input('igss'),
                        'isr'                       => $request->input('isr'),
                        'otros_descuentos'          => $request->input('otros_descuentos'),
                        'total_descuentos'          => $request->input('total_descuentos'),
                        'total'                     => $request->input('total'),
                    ]);
                    if ($new_record) {
                        $this->status_code  = 200;
                        $this->result       = true;
                        $this->message      = 'Registro de  planilla creado correctamente';
                        $this->records      = $new_record;
                    } else {
                        throw new \Exception('El registro no pudo ser creado');
                    }
            } else {
                throw new \Exception('El registro no pudo existe');
            }
        } catch (\Exception $e) {
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

    public function modificar(Request $request, $id){
        try {
            $validacion = Planilla::find($id);
            // dd($validacion);
            if ($validacion) {
                $new_record = (new DetallePlanilla)->create([
                        'sueldo_ordinario'          => $request->input('sueldo_ordinario'),
                        'id_planilla'               => $validacion->id,
                        'mes'                       => $request->input('mes'),
                        'quincena'                  => $request->input('quincena'),
                        'dias_trabajados'           => $request->input('dias_trabajados'),
                        'horas_ex_dia'              => $request->input('horas_ex_dia'),
                        'horas_ex_noche'            => $request->input('horas_ex_noche'),
                        // 'sueldo_base'               => $request->input('sueldo_base'),
                        'sueldo_ex_dia'             => $request->input('sueldo_ex_dia'),
                        'sueldo_ex_noche'           => $request->input('sueldo_ex_noche'),
                        'total_ex'                  => $request->input('total_ex'),
                        'bon_legal'                 => $request->input('bon_legal'),
                        'bon_inc_base'              => $request->input('bon_inc_base'),
                        'incentivo_pn'              => $request->input('incentivo_pn'),
                        'incentivo_as'              => $request->input('incentivo_as'),
                        'incentivo_pn1'             => $request->input('incentivo_pn1'),
                        'incentivo_as1'             => $request->input('incentivo_as1'),
                        'total_bn_inc'              => $request->input('total_bn_inc'),
                        'total_ingresos'            => $request->input('total_ingresos'),
                        'igss'                      => $request->input('igss'),
                        'isr'                       => $request->input('isr'),
                        'otros_descuentos'          => $request->input('otros_descuentos'),
                        'total_descuentos'          => $request->input('total_descuentos'),
                        'total'                     => $request->input('total'),
                    ]);
                    if ($new_record) {
                        $this->status_code  = 200;
                        $this->result       = true;
                        $this->message      = 'Registro de  planilla actualizadp';
                        $this->records      = $new_record;
                    } else {
                        throw new \Exception('El registro no pudo ser actualizado');
                    }
            } else {
                throw new \Exception('El registro no pudo existe');
            }
        } catch (\Exception $e) {
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

    public function destroy($id){
            try {
                $record = DetallePlanilla::find($id);
                if ($record) {
                    $record->delete();
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Planilla eliminada correctamente';
                } else {
                    throw new \Exception('La planills no pudo ser encontrada.');
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