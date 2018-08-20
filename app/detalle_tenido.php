<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class detalle_tenido extends Model
{
    protected $table    = 'detalle_tenido';
    protected $fillable = ['id_tenido',
                           'estado', 
                           'cantidad_tenida', 
                           'color',
                           'etapa', 
                           'quesos',
                           ];

  public function tenido()
  {
      return $this->belongsTo('App\Tenido', 'id_tenido', 'id');
  }
}
