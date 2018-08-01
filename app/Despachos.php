<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Despachos extends Model
{
    protected $table    = 'despachos';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['fecha',
                           'id_orden',
                           'envio', 
                           'cantidad', 
                           ];

   	public function orden()
	    {
	        return $this->hasOne('App\Orden', 'id', 'id_orden');
	    }                          
}
