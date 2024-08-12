<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    use HasFactory;

    protected $fillable = [
        'no_venta',
        'fecha_venta',
        'total_venta',
        'observaciones_venta',
        'forma_pago_venta',
        /////cancelado el total de la venta///////////
        'cancelado_total_venta',
        'fecha_cancelado_total_venta',
        /////credito///////////
        'credito',
        'total_credito',
        /////anulado///////////
        'anulado',
        'fecha_anulado',
        /////notacredito///////////
        'nota_credito',
        'total_nota_credito',
        /////abono///////////
        'abono',
        'total_abono',
        /////si requiere envio o traslado a la ubicacion del cliente
        'envio',
        'estado_envio',

        //registro de operaciones a una venta
        'correlativo',
        ////visible ante los registros y operaciones
        'visible',

        //////CLIENTE////////
        'cliente_id',
        'sucursal_id',
    ];

    public function Abonos(){
        // $this->belongsTo('App\Models\Rol');
         return $this->hasMany(Abono::class);
     }

     public function NotaCreditos(){
        // $this->belongsTo('App\Models\Rol');
         return $this->hasMany(NotaCredito::class);
     }



    public function EstadoCuentas(){
        return $this->hasMany(EstadoCuenta::class);
    }

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function Productos(){
        return $this->belongsToMany(Producto::class)
        ->as('producto_venta')
        ->withTimestamps()
        ->withPivot('cantidad','sub_total','precio_venta');
    }

    public function Asignacion(){
        return $this->belongsToMany(Asignacion::class);
    }

    public function Envios(){
        return $this->belongsToMany(Envio::class)
        ->withTimestamps()
        ->withPivot('entregado','observaciones');
    }

    public function Creditos(){
        return $this->hasMany(Credito::class);
    }


    public function Departamentos(){
        return $this->belongsToMany(Departamento::class)
        ->withPivot('observaciones');
    }

/*
  protected function anulado(): Attribute
  {
      return Attribute::make(

          get: fn (string $value) => $value==false ? $value="no anulado" : $value="anulado"


      );
  }
*/


}
