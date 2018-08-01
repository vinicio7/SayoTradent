<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    protected $table    = 'ordenes';
	// protected $fillable = ['usuario', 'clave', 'activado'];
    protected $fillable = ['orden',
                           'fecha_hora', 
                           'id_empresa',
                           'po',
                           'id_estilo',
                           'descripcion', 
                           'id_calibre',
                           'id_metraje',
                           'tipo',
                           'id_color',
                           'cantidad',
                           'balance',
                           'total_salida',
                           'amount',
                           'precio',
                           'fecha_entrega',
                           'id_referencias',
                           'id_lugar',
                           'facturado',
                           'estado_prod'
						   ];

  public function cliente()
  {
      return $this->hasOne('App\Clientes', 'id', 'id_empresa');
  }

  public function estilo()
  {
      return $this->hasOne('App\Estilo', 'id', 'id_estilo');
  }

  public function calibre()
  {
      return $this->hasOne('App\Calibre', 'id', 'id_calibre');
  }

  public function metraje()
  {
      return $this->hasOne('App\Metraje', 'id', 'id_metraje');
  }

  public function color()
  {
      return $this->hasOne('App\Color', 'id', 'id_color');
  }

  public function referencia()
  {
      return $this->hasOne('App\Referencia', 'id', 'id_referencias');
  }

  public function lugar()
  {
      return $this->hasOne('App\Lugar', 'id', 'id_lugar');
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
  public function tipoOrden()
  {
      return $this->hasOne('App\TipoOrden', 'id', 'tipo');
  }


}
