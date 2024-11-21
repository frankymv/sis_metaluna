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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('codigo_interno')->unique()->nullable(false);
            $table->string('codigo_mayorista')->default('N/A')->nullable(false);
            $table->string('nombre_empresa',150)->nullable(true);
            $table->string('nombres_cliente',150);
            $table->string('apellidos_cliente',150)->nullable();
            $table->string('cui',150)->nullable(true);
            $table->string('numero_patente',150)->nullable(true);
            $table->string('nit',9)->nullable(true);
            $table->string('telefono_principal',12)->nullable(true);
            $table->string('telefono_secundario',12)->nullable(true);
            $table->string('direccion_fisica',200)->nullable(true);
            $table->string('ubicacion_latitud')->nullable(true);
            $table->string('ubicacion_longitud')->nullable(true);
            $table->string('correo_electronico',200)->nullable(true);
            $table->boolean('estado');

            $table->double('limite_credito',8,2)->default('0.0')->nullable();
            $table->double('credito_actual',8,2)->default('0.0')->nullable();
            $table->integer('dias_limite_credito')->default('0')->nullable();
            $table->string('tipo_cliente')->default('MINO')->nullable(false);


            $table->unsignedBigInteger('direccion_departamento')->nullable();
            $table->foreign('direccion_departamento')->references('id')->on('departamentos');
            $table->unsignedBigInteger('direccion_municipio')->nullable();
            $table->foreign('direccion_municipio')->references('id')->on('municipios');


            $table->unsignedBigInteger('ruta_id')->nullable(true);
            $table->foreign('ruta_id')->references('id')->on('rutas');

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
        Schema::dropIfExists('clientes');
    }
};
