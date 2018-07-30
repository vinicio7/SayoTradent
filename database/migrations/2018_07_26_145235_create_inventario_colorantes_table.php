<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInventarioColorantesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inventario_colorantes', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('colorante_id');
            $table->float('bodega');
            $table->float('despacho');
            $table->float('total');
            $table->Date('fecha');
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
        Schema::dropIfExists('inventario_colorantes');
    }
}
