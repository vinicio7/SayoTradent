<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Planillas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planillas', function (Blueprint $table) {
            $table->increments('id');
            $table->Integer('no_empleado');
            $table->String('nombre');
            $table->Float('sueldo_base');
            $table->Float('dias_trabajados')->nullable();
            $table->Float('horas_ex_dia')->nullable();
            $table->Float('horas_ex_noche')->nullable();
            $table->Float('sueldo_ex_dia')->nullable();
            $table->Float('sueldo_ex_noche')->nullable();
            $table->Float('total_ex')->nullable();
            $table->Float('bon_legal')->nullable();
            $table->Float('bon_inc_base')->nullable();
            $table->Float('incentivo_pn')->nullable();
            $table->Float('incentivo_as')->nullable();
            $table->Float('incentivo_pn1')->nullable();
            $table->Float('incentivo_as1')->nullable();
            $table->Float('total_bn_inc')->nullable();
            $table->Float('total_ingresos')->nullable();
            $table->Float('igss')->nullable();
            $table->Float('isr')->nullable();
            $table->Float('otros_descuentos')->nullable();
            $table->Float('total_descuentos')->nullable();
            $table->Float('total')->nullable();
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
        Schema::dropIfExists('planillas');
    }
}
