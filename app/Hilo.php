<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Hilo extends Model
{
    protected $table    = 'hilos';
    protected $fillable = ['calibre'];
}
