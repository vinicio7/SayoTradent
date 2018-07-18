<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaTenido extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tenido', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_orden');
            $table->Integer('cantidad');
            $table->text('receta');
            $table->Integer('estado_id');
            $table->Integer('etapa_id');
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
        Schema::dropIfExists('tenido');
    }
}
