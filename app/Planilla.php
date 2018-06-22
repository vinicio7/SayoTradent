<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Planilla extends Model
{
    protected $table    = 'planillas';
    protected $fillable = ['no_empleado',
                           'nombre', 
                           'dias_trabajados', 
                           'horas_ex_dia', 
                           'horas_ex_noche', 'sueldo_ordinario', 'sueldo_ex_dia',
                           'sueldo_ex_noche', 'total_ex', 'bon_legal' ,'bon_inc_base',
                           'incentivo_pn','incentivo_as','incentivo_pn1','incentivo_as1',
                           'total_bn_inc','total_ingresos','igss',
                           'isr','otros_descuentos','total_descuentos','total', 'sueldo_base',
						   ];
}
