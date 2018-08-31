<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_tenido extends Model
{
    protected $table    = 'detalle_tenido';
    protected $fillable = ['id_color',
                           'estado', 
                           'cantidad_tenida', 
                           'color',
                           'etapa', 
                           'quesos',
                           'total_tenido',
                           ];

  public function tenido()
  {
      return $this->belongsTo('App\Tenido', 'id_tenido', 'id');
  }

  public function color()
  {
      return $this->hasOne('App\ColoresOrden', 'id', 'id_color');
  }

}
