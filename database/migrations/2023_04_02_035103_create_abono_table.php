<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abonos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('no_abono');
            $table->date('fecha_abono');
            $table->float('total_abono')->comment('abono aplicado al saldo de credito');
            $table->string('observaciones')->nullable(true);
            $table->boolean('abono_anticipado')->default(false)->nullable(true);
            $table->boolean('abono_anticipado_asignado')->default(false)->nullable(true);
            $table->date('fecha_abono_anticipado_asignado')->nullable(true);
            $table->string('tipo_pago')->nullable(false)->comment('forma de pago el abono');
            $table->string('detalle_pago')->nullable(true);
            $table->integer('correlativo')->default('0')->comment('correlativo para el seguimiento de las operaciones de abono y notas de credito')->nullable(true);
            $table->unsignedBigInteger('venta_id')->nullable(true);
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->unsignedBigInteger('cliente_id')->nullable(true);
            $table->foreign('cliente_id')->references('id')->on('clientes');
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
        Schema::dropIfExists('abonos');
    }
};
