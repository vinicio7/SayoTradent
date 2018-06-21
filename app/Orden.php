<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table    = 'ordenes';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['orden',
                           'usuario', 
                           'fecha_hora', 
                           'empresa',
                           'po',
                           'estilo',
                           'empresa',
                           'descripcion', 
                           'calibre',
                           'metraje',
                           'tipo',
                           'color',
                           'cantidad',
                           'precio',
                           'fecha',
                           'referencias',
                           'lugar_entrega'
						   ];
}
