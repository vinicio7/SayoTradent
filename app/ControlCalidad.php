<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ControlCalidad extends Model
{
    protected $table    = 'control_calidad';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = [ 'id_orden',
                            'inspector','supervisor',
                            'cantidad_cajas','lote',
                            'cantidad_revisada','aceptada',
                            'rechazada',
                            'solucion','observaciones',
                           ];

    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
}
