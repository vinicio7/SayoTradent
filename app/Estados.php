<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estados extends Model
{
    protected $table    = 'estados';
    protected $fillable = ['descripcion'];
}
