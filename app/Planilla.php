<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table    = 'planillas';
    protected $fillable = ['no_empleado',
                           'nombre', 
                           'sueldo_base',
                           'calcular_bono'
						   ];

	public function detalle()
  	{
    	return $this->hasOne('App\DetallePlanilla', 'id', 'id_planilla');
  	}
}
