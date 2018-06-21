<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaOrdenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ordenes', function (Blueprint $table) {
            $table->increments('id');
            $table->String('orden');
            $table->Datetime('fecha_hora');
            $table->String('empresa');
            $table->String('po');
            $table->String('estilo');
            $table->String('descripcion');
            $table->String('calibre');
            $table->String('metraje');
            $table->String('tipo');
            $table->String('color');
            $table->Integer('cantidad');
            $table->Integer('estado');
            $table->decimal('precio', 8, 2);
            $table->Date('fecha_entrega');
            $table->Date('fecha_aprobacion');
            $table->String('referencias');
            $table->String('lugar_entrega');
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
        Schema::dropIfExists('ordenes');
    }
}
