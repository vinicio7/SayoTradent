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
                           'fecha',
                           'maquina',
                           'operario',
                           'contenedor',
                           'kilos',
                           'quesos',
                           'hora_ingreso',
                           'hora_salida',
                           'tipo'
                           ];
    
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
    public function secado()
    {
        return $this->hasOne('App\Secado', 'id_orden', 'id');
    }
    public function detalle_tenido()
    {
        return $this->hasMany('App\detalle_tenido', 'id_tenido', 'id');
    }         
}
