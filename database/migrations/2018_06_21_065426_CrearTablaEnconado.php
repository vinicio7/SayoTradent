<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEnconado extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enconado', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('id_orden');
            $table->Integer('cantidad');
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
        Schema::dropIfExists('enconado');
    }
}
