<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMaseo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maseo', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_orden');
            $table->Integer('fecha');
            $table->Integer('maseador');
            $table->Integer('estado_id');
            $table->Integer('tipo_calibre');
            $table->Integer('peso');
            $table->Integer('lote');
            $table->Integer('conos_grandes');
            $table->Integer('quesos');
            $table->Integer('kilos');
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
        Schema::dropIfExists('maseo');
    }
}
