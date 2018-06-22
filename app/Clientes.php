<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $table    = 'clientes';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['nombre','nit', 
                           'telefono','direccion',
                           'credito', 
						   ];
}
