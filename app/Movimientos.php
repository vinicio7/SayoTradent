<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimientos extends Model
{
    protected $table    = 'movimientos';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['tipo_movimiento',
    						'monto', 
                           'descripcion',
                           
                            'fecha',
    						'no_cheque', 
                           'nombre',
                            'moneda',
                            'cobrado',
    						'balanceQ', 
                           'balance_D',
                            'cuenta_id',
						   ];
}
