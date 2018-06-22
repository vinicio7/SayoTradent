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
            if ($request->input('registro')) {
                $registro = 1;
            }else {
                $registro = 0;
            }

            if ($request->input('administracion')) {
                $administracion = 1;
            }else {
                $administracion = 0;
            }
            
            if ($request->input('produccion')) {
                $produccion = 1;
            }else {
                $produccion = 0;
            }  
                
            if ($request->input('compras')) {
                $compras = 1;
            }else {
                $compras = 0;
            } 

            if ($request->input('despachos')) {
                $despachos = 1;
            }else {
                $despachos = 0;
            }

            if ($request->input('control')) {
                $control = 1;
            }else {
                $control = 0;
            } 

            if ($request->input('usuarios')) {
                $usuarios = 1;
            }else {
                $usuarios = 0;
            }
            $validacion = Usuarios::where('usuario',$request->input('usuario'))->first();
            if ($validacion) {
                throw new \Exception('Ya existe un registro con el mismo usuario.');
            } else {
                    $record = Usuarios::create([
                        'nombre'               => $request->input('nombre'),                           
                        'usuario'              => $request->input('usuario'),
                        'password'             => \Hash::make($request->input('password')),
                        'email'                => $request->input('email'),
                        'registro'             => $registro,
                        'administracion'       => $administracion,
                        'produccion'           => $produccion,
                        'compras'              => $compras,
                        'despachos'            => $despachos,
                        'control'              => $control,
                        'usuarios'             => $usuarios,                          
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

    public function login(Request $request){
		try {
            $validacion = Usuarios::where('usuario',$request->input('usuario'))->first();
			if ($validacion) {
				if (\Hash::check($request->input('password'), $validacion->password)) {
					
					$validacion->registro 				= $validacion->registro;
					$validacion->administracion 		= $validacion->administracion;
					$validacion->produccion 			= $validacion->produccion;
					$validacion->compras 				= $validacion->compras;
					$validacion->despachos 				= $validacion->despachos;
					$validacion->control 				= $validacion->control;
					$validacion->usuarios 				= $validacion->usuarios;
																							
					$this->status_code = 200;
					$this->result      = true;
					$this->message     = 'Sesión iniciada correctamente';
					$this->records     = $validacion;
				} else {
					throw new \Exception('Contraseña incorrecta');
				}
			} else {
				throw new \Exception('Usuario no encontrado');
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
            $validacion = Usuarios::where('usuario',$request->input('usuario'))->first();                   
            if ($validacion == true && $validacion->id != $id) {
                throw new \Exception('Ya existe este usuario.');
            } else {
            $record = Usuarios::find($id);
            if ($record) {
                $record->nombre         = $request->input('nombre', $record->nombre);
                $record->usuario        = $request->input('usuario', $record->usuario);
                $record->password  	    = $request->input('password', $record->password);
                $record->email  	    = $request->input('email', $record->email);
                $record->registro       = $request->input('registro', $record->registro);
                $record->administracion = $request->input('administracion', $record->administracion);
                $record->produccion     = $request->input('produccion', $record->produccion);
                $record->compras        = $request->input('compras', $record->compras);
                $record->despachos      = $request->input('despachos', $record->despachos);
                $record->control        = $request->input('control', $record->control);
                $record->usuarios       = $request->input('usuarios', $record->usuarios);
                $record->save();
                if ($record->save()) {
                    $this->status_code  = 200;
                    $this->result       = true;
                    $this->message      = 'Usuario actualizado correctamente';
                    $this->records      = $record;
                } else {
                    throw new \Exception('Usuario no pudo ser actualizado');
                }
                } else {
                        $this->message = 'El usuario no existe';
                        throw new \Exception('El usuario no existe');
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
