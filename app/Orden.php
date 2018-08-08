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
                           'total_salida',
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

  public function tenido()
  {
      return $this->BelongsTo('App\Tenido','id');
  }

  public function secado()
  {
      return $this->BelongsTo('App\Secado','id');
  }

  public function enconado()
  {
      return $this->BelongsTo('App\Enconado','id');
  }

}
