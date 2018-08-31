<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ColoresOrden extends Model
{
    protected $table    = 'colores_orden';
    protected $fillable = ['id_orden',
                          'color',
                           'po',
                           'estilo',
                           'descripcion', 
                           'id_calibre',
                           'id_metraje',
                           'tipo',
                           'color',
                           'cantidad',
                           'referencia',
                           'lugar',
                           'id_estado',
                           'sub_total',
                           'precio',
                           'total_salida',
						   ];


  public function orden(){
  	return $this->hasOne('App\Orden', 'orden','id_orden');
  }

  public function calibre()
  {
      return $this->hasOne('App\Calibre', 'id', 'id_calibre');
  }

  public function metraje()
  {
      return $this->hasOne('App\Metraje', 'id', 'id_metraje');
  }

  // public function tenido()
  // {
  //     return $this->belo('App\Tenido', 'id_orden', 'id_orden');
  // }

  public function detalle_tenido()
  {
      return $this->hasOne('App\detalle_tenido', 'color', 'estilo');
  }

  public function referencia()
  {
      return $this->hasOne('App\Referencia', 'id', 'id_referencias');
  }

  public function lugar()
  {
      return $this->hasOne('App\Lugar', 'id', 'id_lugar');
  }
  public function tipoOrden()
  {
      return $this->hasOne('App\TipoOrden', 'id', 'tipo');
  }
  public function estado()
  {
      return $this->hasOne('App\Estados', 'id', 'id_estado');
  }

}
