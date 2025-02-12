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
                           'kilos',
                           'quesos'
                           ];

  public function tenido()
  {
      return $this->belongsTo('App\Tenido', 'id_tenido', 'id');
  }


  public function orden() {
    return $this->hasOne('App\ColoresOrden', 'estilo', 'color')->with('orden');
  }

  public function color()
  {
      return $this->hasOne('App\ColoresOrden', 'id', 'id_color');
  }


}
