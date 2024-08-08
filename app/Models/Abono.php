<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Abono extends Model
{

    protected $fillable =[
        'no_abono',
        'venta_id',
        'fecha_abono',
        'saldo_credito',
        'total_saldo',
        'total_abono',
        'observaciones',
        'correlativo',
        'tipo_pago',
        'detalle_pago',
        'abono_anticipado',
        'fecha_abono_anticipado',
        'cliente_id',
        'abono_anticipado_asignado'];
    use HasFactory;


    public function Venta(){
        return $this->belongsTo(Venta::class);
    }

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }


}
