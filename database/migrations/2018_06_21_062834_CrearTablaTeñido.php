<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTeñido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('teñido', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_orden');
            $table->Date('fecha_inicio');
            $table->Date('fecha_fin');
            $table->Integer('cantidad');
            $table->text('receta');
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
        Schema::dropIfExists('teñido');
    }
}
