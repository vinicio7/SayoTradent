<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Metraje extends Model
{
    protected $table    = 'metrajes';
    protected $fillable = ['descripcion'];
}
