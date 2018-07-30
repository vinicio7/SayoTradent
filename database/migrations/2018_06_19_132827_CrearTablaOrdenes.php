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
            $table->Integer('id_empresa');
            $table->String('po');
            $table->Integer('id_estilo');
            $table->String('descripcion');
            $table->Integer('id_calibre');
            $table->Integer('id_metraje');
            $table->Integer('tipo');
            $table->Integer('id_color');
            $table->Integer('cantidad');
            $table->Integer('balance')->nullable();
            $table->Integer('total_salida')->nullable();
            $table->Integer('amount')->nullable();
            $table->decimal('precio', 8, 2);
            $table->Date('fecha_entrega');
            $table->Integer('id_referencias');
            $table->Integer('id_lugar');
            $table->boolean('facturado');
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
