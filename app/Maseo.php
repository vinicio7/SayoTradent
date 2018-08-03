<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Maseo extends Model
{
    protected $table    = 'maseo';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['id_orden', 
                           'cantidad',
                           'estado_id',
                           'etapa_id',
                           'tipo_calibre',
                           'peso',
                           'lote',
                           'conos_grandes',
                           'quesos',
                           'kilos',
                           ];
    public function orden()
    {
        return $this->hasOne('App\Orden', 'id', 'id_orden');
    }
}
