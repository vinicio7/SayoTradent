<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devanado extends Model
{
    protected $table    = 'devanado';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['id_orden', 
                           'cantidad',
                           'estado_id',
                           'etapa_id',
                           ];
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
    public function maseo()
    {
        return $this->hasOne('App\Maseo', 'id', 'id_orden');
    } 
}
