<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Usuarios;
use App\Proveedores;
use App\Clientes;
use App\Compras;

class ExcelController extends Controller
{
    public function index(Request $request){
        \Excel::create('Usuarios', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Usuarios::all();

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]  = $reporte->nombre;
                   $row ["Usuarios"] = $reporte->usuario;
                   $row ["Email"]    = $reporte->email;
              
                    if ($reporte->registro==1) {
                        $row ["Estado"] = "Con permisos";
                    } elseif ($reporte->registro==0){
                        $row ["Estado"] = "Sin permmisos"; 
                    }
                    
                    if ($reporte->administracion==1) {
                        $row ["Estado"] = "Con permisos";
                    } elseif ($reporte->administracion==0){
                        $row ["Estado"] = "Sin permmisos"; 
                    }
                    
                    if ($reporte->produccion==1) {
                        $row ["Produccion"] = "Con permisos";
                    } elseif ($reporte->produccion==0){
                        $row ["Produccion"] = "Sin permmisos"; 
                    }

                    if ($reporte->compras==1) {
                        $row ["Compras"] = "Con permisos";
                    } elseif ($reporte->compras==0){
                        $row ["Compras"] = "Sin permmisos"; 
                    }

                    if ($reporte->despachos==1) {
                        $row ["Despacho"] = "Con permisos";
                    } elseif ($reporte->despachos==0){
                        $row ["Despacho"] = "Sin permmisos"; 
                    }

                    if ($reporte->control==1) {
                        $row ["Control de calidad"] = "Con permisos";
                    } elseif ($reporte->control==0){
                        $row ["Control de calidad"] = "Sin permmisos"; 
                    }

                    if ($reporte->usuarios==1) {
                        $row ["Usuarios"] = "Con permisos";
                    } elseif ($reporte->usuarios==0){
                        $row ["Usuarios"] = "Sin permmisos"; 
                    }
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }


    public function reporteProveedores(Request $request){
        \Excel::create('Proveedores', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Proveedores::all();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]              = $reporte->nombre;
                   $row ["Nit"]                  = $reporte->nit;
                   $row ["Descripción"]          = $reporte->descripcion;
                   $row ["Fecha de Creación"]    = $reporte->created_at;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteClientes(Request $request){
        \Excel::create('Clientes', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Clientes::all();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["Nombres"]              = $reporte->nombre;
                   $row ["Nit"]                  = $reporte->nit;
                   $row ["Telefono"]             = $reporte->telefono;
                   $row ["Dirección"]            = $reporte->direccion;
                   $row ["Credito"]              = $reporte->credito;
                   $row ["Fecha de ingreso"]     = $reporte->created_at;
              
                   $data[] = $row;
                } 

          $sheet->fromArray($data);
      });
      })->export('xls');
    }

    public function reporteCompras(Request $request){
        \Excel::create('Compras', function($excel) use ($request){
             $excel->sheet('Datos', function($sheet) use ($request) {

                $reporte = Compras::with('proveedores')->get();
                // dd($reporte);

             $data = [];
                foreach ($reporte as $reporte) {
                   $row = [];
                   $row ["No. de factura"]          = $reporte->no_factura;
                   $row ["Nit"]                     = $reporte->producto;
                   $row ["Telefono"]                = $reporte->cantidad;
                   $row ["Proveedor"]               = $reporte->proveedores->nombre;
                   $row ["Precio"]                  = $reporte->precio;
                   $row ["Fecha de compra"]         = $reporte->fecha;
              
                   $data[] = $row;
                } 
                // dd($data);
          $sheet->fromArray($data);
      });
      })->export('xls');
    }
}

