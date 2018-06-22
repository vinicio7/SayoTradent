<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Planilla;
use DB;

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
    public function store(Request $request){
        // dd($request);
            try {
                $validacion = Planilla::where('no_empleado',$request->input('no_empleado'))->first();
                if (!$validacion) {
                    $record = Planilla::create([
                        'no_empleado'                   => $request->input('no_empleado'),
                        'nombre'       			        => $request->input('nombre'),
                        // 'dias_trabajados'       		=> $request->input('dias_trabajados'),
                        // 'horas_ex_dia'          		=> $request->input('horas_ex_dia'),
                        // 'horas_ex_noche'          		=> $request->input('horas_ex_noche'),
                        'sueldo_base'       		=> $request->input('sueldo_base'),
                        // 'sueldo_ex_dia'       		    => $request->input('sueldo_ex_dia'),
                        // 'sueldo_ex_noche'               => $request->input('sueldo_ex_noche'),
                        // 'total_ex'                      => $request->input('total_ex'),
                        // 'bon_legal'                     => $request->input('bon_legal'),
                        // 'bon_inc_base'       		    => $request->input('bon_inc_base'),
                        // 'incentivo_pn'       		    => $request->input('incentivo_pn'),
                        // 'incentivo_as'       		    => $request->input('incentivo_as'),
                        // 'incentivo_pn1'       		    => $request->input('incentivo_pn1'),
                        // 'incentivo_as1'       		    => $request->input('incentivo_as1'),
                        // 'total_bn_inc'       		    => $request->input('total_bn_inc'),
                        // 'total_ingresos'       		    => $request->input('total_ingresos'),
                        // 'igss'       		            => $request->input('igss'),
                        // 'isr'       		            => $request->input('isr'),
                        // 'otros_descuentos'       		=> $request->input('otros_descuentos'),
                        // 'total_descuentos'       		=> $request->input('total_descuentos'),
                        // 'total'       		            => $request->input('total'),
                        // 'sueldo_base'       		    => $request->input('sueldo_base'),
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
                    throw new \Exception('El registro ya existe');
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
            $record = Planilla::find($id);
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
            $record = Planilla::find($id);
            $record->no_empleado                = $request->input('no_empleado', $record->no_empleado);
            $record->nombre                     = $request->input('nombre', $record->nombre);
            $record->dias_trabajados            = $request->input('dias_trabajados', $record->dias_trabajados);
            $record->horas_ex_dia               = $request->input('horas_ex_dia', $record->horas_ex_dia);
            $record->horas_ex_noche             = $request->input('horas_ex_noche', $record->horas_ex_noche);
            $record->sueldo_ordinario           = $request->input('sueldo_ordinario', $record->sueldo_ordinario);
            $record->sueldo_ex_dia              = $request->input('sueldo_ex_dia', $record->sueldo_ex_dia);
            $record->bon_inc_base               = $request->input('bon_inc_base', $record->bon_inc_base);
            $record->incentivo_pn               = $request->input('incentivo_pn', $record->incentivo_pn);
            $record->total_bn_inc               = $request->input('total_bn_inc', $record->total_bn_inc);
            $record->igss                       = $request->input('igss', $record->igss);
            $record->isr                        = $request->input('isr', $record->isr);
            $record->otros_descuentos           = $request->input('otros_descuentos', $record->otros_descuentos);
            $record->total                      = $request->input('total', $record->total);
            $record->total_ex                   = $request->input('total_ex', $record->total_ex);
            $record->incentivo_as               = $request->input('incentivo_as', $record->incentivo_as);
            $record->sueldo_ex_noche            = $request->input('sueldo_ex_noche', $record->sueldo_ex_noche);
            $record->total_ingresos             = $request->input('total_ingresos', $record->total_ingresos);

            $record->save();
            if ($record->save()) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Evento publico actualizado correctamente';
                $this->records      = $record;
            } else {
                throw new \Exception('El evento publico no pudo ser actualizado');
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
                $record = Planilla::find($id);
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