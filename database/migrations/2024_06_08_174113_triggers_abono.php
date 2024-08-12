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
    {/*
        DB::unprepared('DROP TRIGGER IF EXISTS `agregar_estado_cuenta_abono`');
        DB::unprepared('CREATE TRIGGER agregar_estado_cuenta_abono AFTER INSERT ON abonos
            FOR EACH ROW
            BEGIN
            DECLARE t_abono INT DEFAULT 0;

            IF (SELECT EXISTS (SELECT id FROM estado_cuentas WHERE  cliente_id=NEW.cliente_id)) THEN
                SET t_abono = (SELECT total_abono FROM estado_cuentas WHERE cliente_id=NEW.cliente_id);
                UPDATE estado_cuentas SET total_abono = (NEW.total_abono+t_abono) WHERE cliente_id=NEW.cliente_id;
            ELSE
                INSERT INTO estado_cuentas (cliente_id,total_abono)
                VALUES (NEW.cliente_id,NEW.total_abono);
            END IF;
        END');


        DB::unprepared('DROP TRIGGER IF EXISTS `agregar_estado_cuenta_abono`');
        DB::unprepared('CREATE TRIGGER agregar_estado_cuenta_abono AFTER INSERT ON abonos
            FOR EACH ROW
            BEGIN

            DECLARE correl INT DEFAULT 0;

            DECLARE t_abono INT DEFAULT 0;
            DECLARE nuevo_saldo INT DEFAULT 0;
            DECLARE t_saldo_venta INT DEFAULT 0;
            DECLARE cliente INT DEFAULT 0;

            IF(NEW.abono_anticipado=FALSE) THEN

                SET t_saldo_venta = (SELECT saldo_venta FROM ventas WHERE id=NEW.venta_id);
                SET cliente = (SELECT cliente_id FROM ventas WHERE id=NEW.venta_id);
                SET t_abono= (SELECT total_abono FROM estado_cuentas WHERE cliente_id=cliente);


                SET nuevo_saldo=t_saldo_venta-NEW.total_abono;

                IF(nuevo_saldo!=0) THEN
                    UPDATE ventas SET saldo_venta = nuevo_saldo, correlativo=NEW.correlativo WHERE id=NEW.venta_id;
                ELSE
                    UPDATE ventas SET saldo_venta = nuevo_saldo, cancelado=1, fecha_cancelado= NEW.fecha_abono,correlativo=NEW.correlativo WHERE id=NEW.venta_id;
                END IF;

                IF (SELECT EXISTS (SELECT id FROM estado_cuentas WHERE  cliente_id=cliente)) THEN
                    UPDATE estado_cuentas SET total_abono = (NEW.total_abono+t_abono) WHERE cliente_id=cliente;
                ELSE
                    INSERT INTO estado_cuentas (cliente_id,total_abono,total_credito)
                    VALUES (cliente,NEW.total_abono,0);

                END IF;
            END IF;
        END');
*/
    /*
        while total > 0 do
                SET sucursal_origen =(SELECT id FROM sucursals WHERE  prioridad=prioridad_contador);
                IF (SELECT EXISTS (SELECT * FROM producto_sucursal WHERE  producto_id=NEW.producto_id AND sucursal_id=sucursal_origen)) THEN
                    SET cantidad_temp =(SELECT cantidad FRtotal_creditoOM producto_sucursal WHERE  producto_id=NEW.producto_id AND sucursal_id=sucursal_origen);
                    IF (TOTAL>cantidad_temp) THEN
                        INSERT INTO salidas (venta_id,producto_venta_id,sucursal_id,cantidad) VALUES (NEW.venta_id, NEW.producto_id,sucursal_origen,cantidad_temp);
                        UPDATE producto_sucursal SET cantidad = 0 WHERE producto_id = NEW.producto_id AND sucursal_id = sucursal_id;
                        SET TOTAL=TOTAL-cantidad_temp;
                        ELSE IF (TOTAL<cantidad_temp) THEN
                            INSERT INTO salidas (venta_id,producto_venta_id,sucursal_id,cantidad) VALUES (NEW.venta_id, NEW.producto_id,sucursal_origen,total);
                            UPDATE producto_sucursal SET cantidad = (cantidad_temp-TOTAL) WHERE producto_id = NEW.producto_id AND sucursal_id = sucursal_id;
                            SET TOTAL=0;
                            ELSE IF (TOTAL=cantidad_temp) THEN
                                INSERT INTO salidas (venta_id,producto_venta_id,sucursal_id,cantidad) VALUES (NEW.venta_id, NEW.producto_id,sucursal_origen,cantidad_temp);
                                UPDATE producto_sucursal SET cantidad = (cantidad_temp-TOTAL) WHERE producto_id = NEW.producto_id AND sucursal_id = sucursal_id;
                                SET TOTAL=0;
                            END IF;
                ELSE
                    SET prioridad_contador=prioridad_contador+1;
                END IF;
        end while ;
    */


    /*
        DB::unprepared('DROP TRIGGER IF EXISTS `add_venta_inventario`');
        DB::unprepared('CREATE TRIGGER add_venta_inventario AFTER INSERT ON producto_venta
            FOR EACH ROW
            BEGIN
            DECLARE exist INT;
            DECLARE sucur_id INT;
            DECLARE invent_id INT DEFAULT 0;
            DECLARE invent_cantidad INT DEFAULT 0;

            SET sucur_id = (SELECT sucursal_id FROM venta WHERE id=NEW.venta_id);

            IF (SELECT EXISTS (SELECT * FROM producto_sucursal WHERE producto_id = NEW.producto_id AND sucursal_id = sucur_id)) THEN
                SET invent_cantidad = (SELECT cantidad from producto_sucursal where producto_id = NEW.producto_id and sucursal_id = sucur_id);
                UPDATE producto_sucursal SET cantidad = (invent_cantidad+NEW.cantidad) WHERE producto_id = NEW.producto_id AND sucursal_id = sucur_id;
            ELSE
                INSERT INTO producto_sucursal (producto_id, sucursal_id, cantidad) VALUES (NEW.producto_id, sucur_id,NEW.cantidad);
            END IF;
        END
        ');

        //funcionanod bastante bien
        DB::unprepared('DROP TRIGGER IF EXISTS `add_traslado_inventario`');
        DB::unprepared('CREATE TRIGGER add_traslado_inventario AFTER INSERT ON compra_producto
        FOR EACH ROW
        BEGIN

        DECLARE exist INT;
        DECLARE sucur_id INT;
        DECLARE invent_id INT DEFAULT 0;
        DECLARE invent_cantidad_origen INT DEFAULT 0;

        SET sucur_id = (SELECT sucursal_id FROM compras WHERE id=NEW.compra_id);
        IF (SELECT EXISTS (SELECT * FROM inventarios WHERE producto_id = NEW.producto_id AND sucursal_id = sucur_id)) THEN
            SET invent_id = (SELECT id FROM inventarios WHERE producto_id = NEW.producto_id AND sucursal_id = sucur_id);
            SET invent_cantidad_origen = (SELECT cantidad from inventarios where producto_id = NEW.producto_id and sucursal_id = sucur_id);
            UPDATE inventarios SET cantidad = (invent_cantidad_origen+NEW.cantidad) WHERE id=invent_id;
        ELSE
            INSERT INTO inventarios (producto_id, sucursal_id, cantidad) VALUES (NEW.producto_id, sucur_id,NEW.cantidad);
        END IF;
        END
                ');
        DB::unprepared('DROP TRIGGER IF EXISTS `add_traslado_inventario`');
            DB::unprepared('CREATE TRIGGER add_traslado_inventario AFTER INSERT ON compra_producto
                FOR EACH ROW
                BEGIN
                    DECLARE exist INT;
                    DECLARE sucur INT;
                    DECLARE inven INT;
                    SET sucur = (SELECT sucursal_id FROM compras WHERE id=NEW.compra_id);
                    SET exist = (SELECT existencia FROM productos WHERE id=NEW.producto_id);
                    INSERT INTO inventarios (id,producto_id, sucursal_id, cantidad) VALUES (NEW.id,NEW.producto_id, sucur, NEW.cantidad) ON DUPLICATE KEY UPDATE producto_id = NEW.producto_id, sucursal_id = sucur, cantidad = NEW.cantidad;
                END
            ');
            DB::unprepared('DROP TRIGGER IF EXISTS `add_traslado_inventario`');
            DB::unprepared('CREATE TRIGGER add_traslado_inventario AFTER INSERT ON compra_producto
                FOR EACH ROW
                BEGIN
                DECLARE exist INT;
                    SET exist = (SELECT existencia FROM productos WHERE id=NEW.producto_id);
                    UPDATE productos SET existencia = (exist+NEW.cantidad) WHERE id=NEW.producto_id;
                END
            ');
            DB::unprepared('DROP TRIGGER IF EXISTS `delete_traslado_inventario`');
            DB::unprepared('CREATE TRIGGER delete_traslado_inventario AFTER DELETE ON compra_producto
            FOR EACH ROW
            BEGIN
                DECLARE exist INT;
                    SET exist = (SELECT existencia FROM productos WHERE id=OLD.producto_id);
                    UPDATE productos SET existencia = existencia-OLD.cantidad WHERE id=OLD.producto_id;
                END
            ');
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
