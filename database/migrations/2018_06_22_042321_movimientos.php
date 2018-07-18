<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Movimientos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->increments('id');
            $table->String('tipo_movimiento');
            $table->Float ('monto');
            $table->String('descripcion');
            $table->Date('fecha');
            $table->String('no_cheque');
            $table->String('nombre');
            $table->String('moneda');
            $table->tinyInteger('cobrado');
            $table->Float('balanceQ')->nullable();
            $table->Float('balance_D')->nullable();
            $table->integer('cuenta_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('movimientos');
    }
}
