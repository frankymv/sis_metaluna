<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credito extends Model
{
    use HasFactory;

    protected $fillable = ['no_credito','fecha_credito','venta_id','total_credito','fecha_limite_credito','cliente_id','observaciones','correlativo','activo'];

    public function Cliente(){
        return $this->belongsTo(Cliente::class);
    }

    public function Venta(){
        return $this->belongsTo(Venta::class);
    }


}
