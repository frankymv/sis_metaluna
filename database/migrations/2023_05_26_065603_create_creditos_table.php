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
        Schema::create('creditos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('no_credito');
            $table->unsignedBigInteger('venta_id')->nullable();
            $table->foreign('venta_id')->references('id')->on('ventas');
            $table->date('fecha_credito');
            $table->date('fecha_limite_credito');
            $table->float('total_credito');
            $table->unsignedBigInteger('cliente_id')->nullable(true);
            $table->foreign('cliente_id')->references('id')->on('clientes');
             //registro de operaciones a una venta
             $table->integer('correlativo')->nullable(true)->default('0')->comment('correlativo para el seguimiento de las operaciones de abono y notas de credito');

            $table->string('observaciones');
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
        Schema::dropIfExists('creditos');
    }
};
