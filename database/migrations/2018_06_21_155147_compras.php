<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Compras extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('no_factura');
            $table->String('producto');
            $table->Integer('cantidad');
            $table->unsignedInteger('id_proveedor');
            $table->foreign('id_proveedor')->references('id')->on('proveedores');
            $table->Float('precio');
            $table->date('fecha');
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
        Schema::dropIfExists('compras');
    }
}
