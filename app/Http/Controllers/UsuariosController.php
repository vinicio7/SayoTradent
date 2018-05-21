<?php

namespace App\Http\Controllers;

use App\Usuarios;
use Illuminate\Http\Request;
use DB;

class UsuariosController extends Controller {
    
    protected $result      = false;
	protected $message     = 'Ocurrió un problema al procesar su solicitud';
	protected $records     = array();
	protected $status_code = 400;

    public function index(){
        try {
            $records = Usuarios::all();
            $this->status_code  = 200;
            $this->result       = true;
            $this->message      = 'Registros de usuarios consultados correctamente.';
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
        try {
            $validacion = Usuarios::where('usuario',$request->input('usuario'))->first();
            if ($validacion) {
                throw new \Exception('Ya existe un registro con el mismo usuario.');
            } else {
                    $record = Usuarios::create([
                        'nombre'               => $request->input('nombre'),                           
                        'usuario'              => $request->input('usuario'),
                        'password'             => $request->input('password'),
                        'email'                => $request->input('email'),                          
                    ]);

                    if ($record) {
                        $this->status_code  = 200;
                        $this->result       = true;
                        $this->message      = 'Registro de usuario creada correctamente.';
                        $this->records      = $record;
                    } else {
                        throw new \Exception('Registro de usuario no pudo ser creado.');
                    }

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
            $record = Usuarios::find($id);
            if ($record) {
                $this->status_code  = 200;
                $this->result       = true;
                $this->message      = 'Registro de usuario consultado correctamente.';
                $this->records      = $record;
            } else {
                throw new \Exception('Registro usuario no encontrado.');
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
			$record = Usuarios::find($id);
            
			$validacion = Usuarios::where("usuario", $request->input('usuario'))->first();
			
			if (!$validacion) {
				if ($record) {
					$record->nombre         = $request->input('nombre', $record->nombre);
					$record->usuario        = $request->input('usuario', $record->usuario);
                    $record->password  	    = $request->input('password', $record->password);
                    $record->email  	    = $request->input('email', $record->email);
                    $record->save();
					if ($record->save()) {
						$this->status_code = 200;
						$this->result      = true;
						$this->message     = 'Usuario actualizado correctamente';
						$this->records     = $record;
					} else {
						throw new \Exception('El usuario no pudo ser actualizado');
					}
				} else {
					$this->message = 'El usuario no existe';
					throw new \Exception('El usuario no existe');
				}	
			} else {
				throw new \Exception('Ya existe este usuario.');
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


    public function destroy($id){
            try {
                $record = Usuarios::find($id);
                if ($record) {
                    $record->delete();
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Usuario eliminada correctamente';
                } else {
                    throw new \Exception('El usuario no pudo ser encontrado');
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
