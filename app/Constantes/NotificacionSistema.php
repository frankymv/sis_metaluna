<?php

namespace App\Constantes;




class DataSistema
{

    public static $tipo_documento = [
        ['id'=>'1','nombre'=>'Cotizacion','valor'=>'COTIZAC'],
        ['id'=>'2','nombre'=>'Venta','valor'=>'VENTA'],
    ];

public static $envio = [
    ['id'=>'1','nombre'=>'Envio','valor'=>'ENVIO'],
    ['id'=>'2','nombre'=>'Sin Envio','valor'=>'SINENVIO'],
];

public static $tipo_ajuste_invetario = [
    ['nombre'=>'Ingreso','valor'=>'ingreso'],
    ['nombre'=>'Egreso','valor'=>'egreso'],
];

public static $estados_envio = [
    ['id'=>'1','nombre'=>'No Aplica','valor'=>'NO/APLICA'],
    ['id'=>'2','nombre'=>'Sin asignar','valor'=>'SIN ASIGNAR'],
    ['id'=>'3','nombre'=>'En proceso','valor'=>'PROCESO'],
    ['id'=>'4','nombre'=>'Finalizado','valor'=>'FINALIZADO'],
    ['id'=>'5','nombre'=>'Rechazado','valor'=>'RECHAZADO'],

];



public static $forma_pago = [
    ['id'=>'1','nombre'=>'Efectivo','valor'=>'EFECT'],
    ['id'=>'2','nombre'=>'Credito','valor'=>'CREDI'],
    ['id'=>'3','nombre'=>'Cheque','valor'=>'CHEQ'],
    ['id'=>'4','nombre'=>'Tarjeta de Credito','valor'=>'TCREDI'],
    ['id'=>'5','nombre'=>'Tarjeta de Debito','valor'=>'TDEBITO'],
    ['id'=>'6','nombre'=>'Transferencia','valor'=>'TRANSFER'],
    ['id'=>'6','nombre'=>'Deposito','valor'=>'DEPOSIT'],
];


public static $tipo_cliente = [
    ['id'=>'1','nombre'=>'MINORISTA','valor'=>'MINO'],
    ['id'=>'2','nombre'=>'MAYORISTA','valor'=>'MAYO'],
];



}
