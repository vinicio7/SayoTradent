<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaControl extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('control_calidad', function (Blueprint $table) {
            $table->increments('id');
            $table->text('id_orden');
            $table->text('inspector');
            $table->text('supervisor');
            $table->text('cantidad_cajas');
            $table->text('lote');
            $table->text('cantidad_revisada');
            $table->text('aceptada');
            $table->text('rechazada');
            $table->text('solucion');
            $table->text('observaciones');
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
        Schema::dropIfExists('control_calidad');
    }
}
