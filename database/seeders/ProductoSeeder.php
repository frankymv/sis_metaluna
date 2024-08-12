<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        DB::table('productos')->insert(['codigo'=>'Can0',	'nombre'=>'Canal Plástico Alutech Cuadrado Longitud:3 Metro',	'descripcion'=>'',	'calibre'=>'0',	'longitud'=>'3',	'tipo_longitud'=>'pie',	'diametro'=>'0',	'tipo_diametro'=>'0',	'peso'=>'0',	'tipo_peso'=>'0',	'divisible'=>'0',	'precio_compra'=>'0',	'precio_venta_producto'=>'150',		'existencia'=>'30',	'estado'=>'1',	'marca_id'=>'2',	'tipo_id'=>'2',	'material_id'=>'19',	'disenio_id'=>'3']);

        DB::table('productos')->insert(['codigo'=>'Lam1',	'nombre'=>'Lamina Lechosa Fibrasol Troquelada Calibre:16 Longitud:10 Pie',	'descripcion'=>'',	'calibre'=>'16',	'longitud'=>'10',	'tipo_longitud'=>'pie',	'diametro'=>'0',	'tipo_diametro'=>'0',	'peso'=>'0',	'tipo_peso'=>'0',	'divisible'=>'0',	'precio_compra'=>'0',	'precio_venta_producto'=>'250',	'existencia'=>'700',	'estado'=>'1',	'marca_id'=>'5',	'tipo_id'=>'9',	'material_id'=>'10',	'disenio_id'=>'23']);









    }
}
