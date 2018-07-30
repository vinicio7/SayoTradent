<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioHilo extends Model
{
    protected $table	= 'inventarioHilos';
    protected $fillable = ['hilo_id', 'fechaSemana_inicio','fechaSemana_fin'];
}
