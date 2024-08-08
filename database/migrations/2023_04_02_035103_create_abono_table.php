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
            $table->unsignedBigInteger('venta_id')->nullable(true);
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->float('saldo_credito')->comment('saldo del credito anterior antes del abono')->nullable(true);
            $table->date('fecha_abono');
            $table->date('fecha_abono_anticipado');
            $table->float('total_abono')->comment('abono aplicado al saldo de credito');
            $table->float('total_saldo')->comment('saldo de credito despues de aplicado el abono')->nullable(true);
            $table->integer('correlativo')->default('0')->comment('correlativo para el seguimiento de las operaciones de abono y notas de credito')->nullable(true);
            $table->string('observaciones')->nullable(true);

            $table->string('tipo_pago')->nullable(false);
            $table->string('detalle_pago')->nullable(true);

            $table->boolean('abono_anticipado')->default(false)->nullable(true);
            $table->unsignedBigInteger('cliente_id')->nullable(true);
            $table->foreign('cliente_id')->references('id')->on('clientes');
            $table->boolean('abono_anticipado_asignado')->default(false)->nullable(true);

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
