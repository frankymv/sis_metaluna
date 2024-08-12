<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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


/*
        DB::unprepared('DROP TRIGGER IF EXISTS `agregar_nota_creditos`');
        DB::unprepared('CREATE TRIGGER agregar_nota_creditos AFTER INSERT ON nota_creditos
        FOR EACH ROW
        BEGIN

        DECLARE cancel INT DEFAULT 0;
        DECLARE cliente INT DEFAULT 0;
        DECLARE t_credito INT DEFAULT 0;
        DECLARE t_total_nota_credito INT DEFAULT 0;
        DECLARE t_saldo_total_venta INT DEFAULT 0;
        DECLARE t_total_venta INT DEFAULT 0;

        DECLARE t_nuevo_saldo_nota_credito INT DEFAULT 0;
        DECLARE t_nuevo_saldo_total_venta INT DEFAULT 0;

        SET cliente = (SELECT cliente_id FROM ventas WHERE id=NEW.venta_id);
        SET cancel = (SELECT saldo_cancelado FROM ventas WHERE id=NEW.venta_id);
        SET t_total_nota_credito = (SELECT total_nota_credito FROM ventas WHERE id=NEW.venta_id);





        IF (cancel="0") THEN

            SET t_saldo_total_venta = (SELECT saldo_total_venta FROM ventas WHERE id=NEW.venta_id);
            SET t_nuevo_saldo_nota_credito=t_total_nota_credito+NEW.total_nota_credito;
            SET t_nuevo_saldo_total_venta=t_saldo_total_venta-NEW.total_nota_credito;
        ELSE
            SET t_nuevo_saldo_nota_credito=t_total_nota_credito+NEW.total_nota_credito;
            SET t_nuevo_saldo_total_venta=0;
        END IF;


        SET t_credito = (SELECT total_credito FROM estado_cuentas WHERE cliente_id=cliente);

        IF (NEW.anulacion_venta = TRUE) THEN
            UPDATE ventas SET nota_credito=NEW.no_nota_credito, fecha_nota_credito=NEW.fecha_nota_credito,total_nota_credito=t_nuevo_saldo_nota_credito,anulado=NEW.anulacion_venta,saldo_cancelado=TRUE, fecha_anulado=NEW.fecha_nota_credito, observaciones_anulado=NEW.observaciones, correlativo=NEW.correlativo WHERE id=NEW.venta_id;
            UPDATE estado_cuentas  SET total_credito=t_credito-NEW.total_nota_credito WHERE cliente_id=cliente;
        ELSE
            UPDATE ventas SET nota_credito=NEW.no_nota_credito, fecha_nota_credito=NEW.fecha_nota_credito,total_nota_credito=t_nuevo_saldo_nota_credito,saldo_total_venta=t_nuevo_saldo_total_venta, correlativo=NEW.correlativo WHERE id=NEW.venta_id;
            UPDATE estado_cuentas  SET total_credito=t_credito-NEW.total_nota_credito WHERE cliente_id=cliente;

        END IF;
            END');

*/

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
