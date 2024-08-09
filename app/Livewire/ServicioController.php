<?php

namespace App\Livewire;

use App\Models\Servicio;
use App\Models\Vehiculo;
use Livewire\Component;

class ServicioController extends Component
{
    public $title='Servicio';
    public $data, $id_data, $id=null;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    ////////////////////
    public $no_servicio=null,$fecha_servicio=null, $estado=true,$total_servicio=null,$descripcion=null,$observaciones=null;
    public $vehiculos,$vehiculo_id;


    public $disabledInput=false;
    ////////////////////


    public $servicios=[];

    ////////////////////
    protected $rules = [
        'no_servico'=>'required',
        'fecha_servicio'=>'required',
        'total_servicio'=>'required',
        'descripcion'=>'required',
        'nombre' => 'required',
    ];
    ////////////////////

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        //dd(Servicio::find(1));

        $this->servicios=Servicio::with('vehiculo')->get();
        return view('livewire.pages.servicio.index');

    }

    public function create(){
        $data=Servicio::latest()->first();
        if ( $data) {
            $this->id=$data->id+1;
            $this->no_servicio=$this->id;

        }else{
            $this->id=1;
            $this->no_servicio=$this->id;
        }
        $this->vehiculos=Vehiculo::all();
        $this->isCreate=true;
    }

    public function store(){
        $this->validate([ 'no_servicio'=>'required',
        'vehiculo_id'=>'required',
        'fecha_servicio'=>'required',
        'total_servicio'=>'required',
        'descripcion'=>'required']);

        Servicio::create(
            [
            'no_servicio'=>$this->no_servicio,
            'fecha_servicio'=>$this->fecha_servicio,
            'total_servicio'=>$this->total_servicio,
            'vehiculo_id'=>$this->vehiculo_id,
            'descripcion'=>$this->descripcion,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado]
        );


        $this->cancel();

    }

    public function edit($rowId){

        $data = Servicio::find($rowId);
        $this->id_data=$data->id;
        $this->no_servicio=$data->no_servicio;
        $this->fecha_servicio=$data->fecha_servicio;
        $this->total_servicio=$data->total_servicio;
        $this->vehiculo_id=$data->vehiculo_id;
        $this->descripcion=$data->descripcion;
        $this->observaciones=$data->observaciones;
        $this->estado=$data->estado;
        $this->isEdit=true;
    }

    public function show($rowId){

        $data = Servicio::find($rowId);
        $this->id_data=$data->id;
        $this->no_servicio=$data->no_servicio;
        $this->fecha_servicio=$data->fecha_servicio;
        $this->total_servicio=$data->total_servicio;
        $this->vehiculo_id=$data->vehiculo_id;
        $this->descripcion=$data->descripcion;
        $this->observaciones=$data->observaciones;
        $this->estado=$data->estado;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
    }


    public function update($rowId){
        $this->validate();

        $data = Servicio::find($rowId);
        $data->update([
            'no_servicio'=>$this->no_servicio,
            'fecha_servicio'=>$this->fecha_servicio,
            'total_servicio'=>$this->total_servicio,
            'vehiculo_id'=>$this->vehiculo_id,
            'descripcion'=>$this->descripcion,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado
        ]);


        $this->cancel();
    }

    public function delete($rowId){
        $data = Servicio::find($rowId);
        $this->id_data=$data->id;

        $this->isDelete = true;
    }

    public function destroy($rowId)
    {
        Servicio::find($rowId)->delete();

        $this->isDelete = false;
        $this->cancel();
    }

    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        ///////////////////
        $this->reset([        'no_servicio',
        'fecha_servicio',
        'total_servicio',
        'vehiculo_id',
        'descripcion',
        'observaciones',
        'estado']);
        ////////////////////
    }


}
