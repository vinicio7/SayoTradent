<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioColorante extends Model
{
    protected $table    = 'inventario_colorantes';
    protected $fillable = ['colorante_id', 'bodega', 'despacho', 'total', 'fecha'];
    
	public function colorante()
	    {
	        return $this->hasOne('App\Colorante', 'id', 'colorante_id');
	    }  
}
