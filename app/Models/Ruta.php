<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ruta extends Model
{
    use HasFactory;

    protected $fillable = [
    'codigo',
    'nombre',
    'descripcion',





'estado'];

public function Asignaciones(){
    return $this->hasMany(Asignacion::class);
}

public function Envio(){
    return $this->hasMany(Envio::class);
}

public function Clientes(){
    // $this->belongsTo('App\Models\Rol');
     return $this->hasMany(Cliente::class);
 }


public function Departamentos(){
    return $this->belongsToMany(Departamento::class)
    ->withPivot('observaciones');
}


public function Municipios(){
    return $this->belongsToMany(Municipio::class)
    ->withPivot('observaciones');
}

protected function estado(): Attribute {
    return new Attribute(
        get: fn (string $value) => $value==='1' ? true:false,
        //  set: fn (string $value) => $value==='Activo'? true:false,

    );
}





}
