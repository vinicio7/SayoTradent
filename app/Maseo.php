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
                           ];
}
