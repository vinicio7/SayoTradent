<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Enconado extends Model
{
    protected $table    = 'enconado';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['id_orden', 
                           'estado_id',
                           'etapa_id',
                           'linea',
                           'maquina',
                           'metros',
                           'fecha'
                           ];
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
    public function devanado()
    {
        return $this->hasOne('App\Devanado', 'id', 'id_orden');
    }  
}
