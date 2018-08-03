<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CalibreDescripcion extends Model
{
    public $table 		= 'CalibreDescripcion';
    protected $fillable	= ['calibre_id', 'descripcion'];
}
