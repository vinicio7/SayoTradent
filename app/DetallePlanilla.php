<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetallePlanilla extends Model
{
    protected $table    = 'planilla_detalle';
    protected $fillable = ['mes',
                           'quincena', 
                           'dias_trabajados', 
                           'horas_ex_dia', 
                           'horas_ex_noche', 'id_planilla', 'sueldo_ex_dia',
                           'sueldo_ex_noche', 'total_ex', 'bon_legal' ,'bon_inc_base',
                           'incentivo_pn','incentivo_as','incentivo_pn1','incentivo_as1',
                           'total_bn_inc','total_ingresos','igss',
                           'isr','otros_descuentos','total_descuentos','total', 'sueldo_ordinario',
                           ];
    public function planilla()
    {
        return $this->hasOne('App\Planilla', 'id', 'id_planilla');
    }
}
