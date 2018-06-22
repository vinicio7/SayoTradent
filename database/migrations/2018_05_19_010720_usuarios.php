<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Usuarios extends Migration
{
    
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->increments('id');
            $table->String('nombre');
            $table->String('usuario');
            $table->String('password');
            $table->String('email');
            $table->tinyInteger('registro');
            $table->tinyInteger('administracion');
            $table->tinyInteger('produccion');
            $table->tinyInteger('compras');
            $table->tinyInteger('despachos');
            $table->tinyInteger('control');
            $table->tinyInteger('usuarios');
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
        Schema::dropIfExists('usuarios');
    }
}
