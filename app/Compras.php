<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compras extends Model
{
    protected $table    = 'compras';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['no_factura','producto',
                            'cantidad', 'id_proveedor',
                           'precio','fecha'
                           ];
                           
    public function proveedores() {
        return $this->hasOne('App\Proveedores', 'id', 'id_proveedor');
    }
}