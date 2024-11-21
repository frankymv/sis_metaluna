<?php

namespace App\Livewire;

use App\Models\Asignacion;
use App\Models\AsignacionRuta;
use App\Models\Ruta;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Venta;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class AsignacionRutaController extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $title='Asignacion Ruta';
    public $data, $per_page=10,  $id_data,$id_last;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;
    public $rutas=[], $municipios=[],$ventas=[],$vehiculos=[];

    public $ruta_id=null;

    public $i = 0;
    public $j = 0;
    public $k = 0;
    public $venta_id=null;

    public $fecha;
    public $no_orden=0;
    public $estado=true;
    public $usuarios=[];

    public $user_id=null;
    public $vehiculo_id=null;

    public $inputs=[];
    public $ventaDetalle=[];
    public $idDetalle=[];

    public $inputsUsuario=[];
    public $usuarioDetalle=[];
    public $idDetalleUsuario=[];


    public $inputsVehiculo=[];
    public $vehiculoDetalle=[];
    public $idDetalleVehiculo=[];


    public function render()
    {
        return view('livewire.pages.asignacion_ruta.index');
    }

    public function create(){
        $this->id_last=Asignacion::latest('id')->first();
        if ( $this->id_last===null) {
            $this->no_orden=0;
        }else{
            $datas=Venta::latest('id')->first();
            $this->no_orden=$datas->id;
        }
        $this->usuarios=User::all();
        $this->ventas=Venta::where('envio',1)->get();
        $this->rutas=Ruta::all();
        $this->vehiculos=Vehiculo::all();
        $this->isCreate=true;
    }

    public function addDetalleRuta(){

        foreach ($this->ventas as $key => $value) {
            if($value['id']===intval($this->venta_id)){

                array_push($this->inputs,$this->i);
                array_push($this->ventaDetalle,$value['no_venta']);
                array_push($this->idDetalle,$value['id']);
                $this->i +=1;
            }
        }

    }


    public function addDetalleUsuario(){

        foreach ($this->usuarios as $key => $value) {
            if($value['id']===intval($this->user_id)){

                array_push($this->inputsUsuario,$this->j);
                array_push($this->usuarioDetalle,$value['nombres']);
                array_push($this->idDetalleUsuario,$value['id']);
                $this->j +=1;
            }
        }

    }

    public function addDetalleVehiculo(){


        foreach ($this->vehiculos as $key => $value) {
            if($value['id']===intval($this->vehiculo_id)){

                array_push($this->inputsVehiculo,$this->k);
                array_push($this->vehiculoDetalle,$value['alias']);
                array_push($this->idDetalleVehiculo,$value['id']);
                $this->k +=1;
            }
        }

    }


    public function store(){



    ////////////////////



    $data=Asignacion::create(
        [
        'no_orden'=>$this->no_orden,
        'fecha'=>$this->fecha,
        'estado'=>$this->estado,
        'ruta_id'=>$this->ruta_id,
        ]
        );

            $data->ventas()->attach($this->idDetalle);
            $data->users()->attach($this->idDetalleUsuario);
            $data->vehiculos()->attach($this->idDetalleVehiculo);
    ////////////////////

        $this->cancel();
    }



    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','created_at','updated_at']);
        ///////////////////
        $this->reset(['no_orden','fecha','estado','idDetalle','ventaDetalle','inputs','i','j']);
        ////////////////////
    }


}
