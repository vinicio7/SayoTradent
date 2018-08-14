<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Muestra extends Model
{
    protected $table    = 'muestras';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['fecha_hora',
                           'id_orden',
                           'envio', 
                           'rechazo', 
                           'fecha_ok',
                           ];
                           
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
}
