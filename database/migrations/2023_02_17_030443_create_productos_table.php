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
        Schema::create('productos', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('codigo',150)->unique();
            $table->string('nombre',150);
            $table->string('descripcion',300)->nullable(true);
            $table->string('calibre')->nullable(true);

            $table->string('longitud')->nullable(true);
            $table->string('tipo_longitud')->nullable(true);
            $table->string('diametro')->nullable(true);
            $table->string('tipo_diametro')->nullable(true);
            $table->string('peso')->nullable(true);
            $table->string('tipo_peso')->nullable(true);

            $table->boolean('divisible')->nullable(true);




            $table->float('precio_compra')->default(0)->nullable(true);
            $table->float('precio_venta_producto')->default(0)->nullable(true);
            $table->integer('existencia')->default(0)->nullable(true);

            $table->boolean('estado')->default(true);

            $table->unsignedBigInteger('marca_id')->nullable(true);
            $table->foreign('marca_id')->references('id')->on('marcas');

            $table->unsignedBigInteger('tipo_id')->nullable(true);
            $table->foreign('tipo_id')->references('id')->on('tipos');

            $table->unsignedBigInteger('material_id')->nullable(true);
            $table->foreign('material_id')->references('id')->on('materials');

            $table->unsignedBigInteger('disenio_id')->nullable(true);
            $table->foreign('disenio_id')->references('id')->on('disenios');


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
        Schema::dropIfExists('productos');
    }
};
