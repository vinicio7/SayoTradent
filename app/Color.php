<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Color extends Model
{
    protected $table    = 'colores';
    protected $fillable = ['descripcion'];
}
