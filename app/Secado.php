<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Secado extends Model
{
    protected $table    = 'secado';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['id_orden', 
                           'secador',
                           'no_lote',
                           'no_maquina',
                           'hora_salida',
                           'observaciones',
                           'etapa_id',
                           'estado_id',
                           'fecha',
                           ];
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }  
    // public function enconado()
    // {
    //     return $this->hasOne('App\Enconado', 'id', 'id_orden');
    // }                       
}
