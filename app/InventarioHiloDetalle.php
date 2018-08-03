<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioHiloDetalle extends Model
{
    public $table		=	'inventarioHilosDetalles';
    protected $fillable =	['inventarioHilo_id', 'calibreDescripcion_id', 'BalanceSemanaAnterior', 'cantidad', 'balance', 'fecha_dia'];  
}
