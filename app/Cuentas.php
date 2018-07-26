<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cuentas extends Model
{
    //
      protected $table    = 'cuentas';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['nombre' 
                           ];
}
