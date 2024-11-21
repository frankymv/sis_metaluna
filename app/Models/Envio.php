<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Envio extends Model
{
    use HasFactory;
    protected $fillable = [
    'envio_no',
    'envio_fecha',
    'ruta_id',
    'proceso_id',
    'proceso_nombre',
    'estado_envio',
    'estado_nombre',
    'estado_fecha',
    'estado_observacion',
    'user_id_created_at',
    'user_name_created_at',
    'observaciones_inicio_envio',
    'observaciones_fin_envio',
    'visible',
    'finalizado'];

    public function Ventas(){
        return $this->belongsToMany(Venta::class)
        ->withTimestamps()
        ->withPivot('entregado','observaciones');
    }



    public function Users(){
        return $this->belongsToMany(User::class);
    }

    public function Ruta(){
         return $this->belongsTo(Ruta::class);
     }


     public function Vehiculos(){
        // $this->belongsTo('App\Models\Rol');
        return $this->belongsToMany(Vehiculo::class);
     }

     public function EstadoEnvios(){
        // $this->belongsTo('App\Models\Rol');
        return $this->hasMany(EstadoEnvio::class);
     }


    protected function estado(): Attribute {
        return new Attribute(
            get: fn (string $value) => $value==='1' ? true:false,
            //  set: fn (string $value) => $value==='Activo'? true:false,

        );
    }




}
