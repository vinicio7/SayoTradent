<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Colorante extends Model
{
    protected $table    = 'colorantes';
    protected $fillable = ['codigo','colorante'];
}
