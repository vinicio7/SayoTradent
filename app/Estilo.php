<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estilo extends Model
{
    protected $table    = 'estilos';
    protected $fillable = ['descripcion'];
}
