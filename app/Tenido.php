<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tenido extends Model
{
    protected $table    = 'tenido';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['id_orden', 
                           'cantidad', 
                           'receta',
                           'estado_id',
                           'etapa_id',
                           ];
    
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
    public function secado()
    {
        return $this->hasOne('App\Secado', 'id_orden', 'id');
    }         
}
