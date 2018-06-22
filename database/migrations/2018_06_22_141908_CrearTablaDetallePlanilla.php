<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDetallePlanilla extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('planilla_detalle', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('id_planilla');
            $table->integer('mes');
            $table->integer('quincena');
            $table->Integer('no_empleado');
            $table->String('nombre');
            $table->Float('sueldo_ordinario');
            $table->Float('dias_trabajados');
            $table->Float('horas_ex_dia');
            $table->Float('horas_ex_noche');
            $table->Float('sueldo_ex_dia');
            $table->Float('sueldo_ex_noche');
            $table->Float('total_ex');
            $table->Float('bon_legal');
            $table->Float('bon_inc_base');
            $table->Float('incentivo_pn');
            $table->Float('incentivo_as');
            $table->Float('incentivo_pn1');
            $table->Float('incentivo_as1');
            $table->Float('total_bn_inc');
            $table->Float('total_ingresos');
            $table->Float('igss');
            $table->Float('isr');
            $table->Float('otros_descuentos');
            $table->Float('total_descuentos');
            $table->Float('total');
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
        Schema::dropIfExists('planilla_detalle');
    }
}
