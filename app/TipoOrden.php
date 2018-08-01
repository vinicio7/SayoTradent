<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoOrden extends Model
{
    protected $table = 'tipo_orden';
    protected $fillable  = ['descripcion'];
}
