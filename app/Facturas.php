<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    protected $table    = 'facturas';
    protected $fillable = ['orden_id','serie','no_factura','cliente_id','emision_dolares', 'tipo_cambio', 'factura_quetzales', 'fecha'];

    public function cliente()
	    {
	        return $this->hasOne('App\Clientes', 'id', 'cliente_id');
	    }

	public function orden()
	    {
	        return $this->hasOne('App\Orden', 'id', 'orden_id');
	    }      
}
