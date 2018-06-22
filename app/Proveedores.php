<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table    = 'proveedores';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['nombre',
                           'nit', 
                           'descripcion', 
						   ];
}
