<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table    = 'ordenes';
    protected $fillable = ['orden',
                           'fecha_hora', 
                           'id_empresa',
                           'balance',
                           
                           'amount',
                           'precio_total',
                           'facturado',
                           'estado_prod',
                           'hora',
						   ];

   public function cliente()
   {
       return $this->hasOne('App\Clientes', 'id', 'id_empresa');
   }

   public function coloresOrden()
   {
       return $this->hasMany('App\ColoresOrden', 'id_orden', 'orden');
   }
   public function tenido()
   {
       return $this->hasOne('App\Tenido', 'id_orden', 'orden');
   }
}
