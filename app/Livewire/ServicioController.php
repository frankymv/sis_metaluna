<?php

namespace App\Livewire;

use App\Models\Servicio;
use App\Models\User;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ServicioController extends Component
{
    use LivewireAlert;
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

    public $filtroNoServicio=null;
    Public $filtroFechaServicio=null;
    public $filtroVehiculo=null;
    public $filtroDescricion=null;
    public $servicios=[];
    public $users=[];


      //////DELETE///
      public $delete_no=null;
      public $delete_nombre=null;

    ////////////////////
    protected $rules = [
        'no_servicio'=>'required',
        'fecha_servicio'=>'required',
        'total_servicio'=>'required',
        'descripcion'=>'required',

    ];
    ////////////////////

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        //dd(Servicio::find(1));
        $this->users=User::all();
        $this->vehiculos=Vehiculo::all();
        $this->servicios=Servicio::with('vehiculo')
        ->where('no_servicio','LIkE',"%{$this->filtroNoServicio}%")
        ->where('vehiculo_id','LIkE',"%{$this->filtroVehiculo}%")
        ->where('fecha_servicio','LIkE',"%{$this->filtroFechaServicio}%")
        ->get();

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

        $this->alertaNotificacion("store");
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
            'fecha_servicio'=>$this->fecha_servicio,
            'total_servicio'=>$this->total_servicio,
            'vehiculo_id'=>$this->vehiculo_id,
            'descripcion'=>$this->descripcion,
            'observaciones'=>$this->observaciones,
            'estado'=>$this->estado
        ]);

        $this->alertaNotificacion("update");
        $this->cancel();
    }

    public function delete($id){
        $data = Servicio::find($id);
        $this->id_data=$data->id;
        $this->delete_no=$data->no_servicio;
        $this->delete_nombre=$data->total_servicio;
        $this->isDelete = true;

    }

    public function destroy($id)
    {
        Servicio::find($id)->delete();
        $this->isDelete = false;
        $this->alertaNotificacion("destroy");
        $this->cancel();
    }





    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfServicioGeneral',['servicios' => $this->servicios]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $dato=Servicio::with('vehiculo')
        ->find($id);
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfServicio',['dato'=>$dato]);
        /*return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");*/
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
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

    public function alertaNotificacion($tipo){
        $alerta="";
        $title="";
        $texto="";
        if($tipo==="store"){

            $title="Agregar";
            $texto="Registro agregado";
            $alerta="success";

        }elseif($tipo==="update"){
            $title="Editar";
            $texto="Registro editado";
            $alerta="success";

        }elseif($tipo==="destroy"){
            $title="Borrar";
            $texto="Registro borrado";
            $alerta="success";
        }elseif($tipo==="error"){
            $title="Error";
            $texto="No se completo la operación";
            $alerta="error";
        }
        return $this->alert("$alerta", "$title", [
            'position' => 'center',
            'timer' => '2000',
            'toast' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
            'timerProgressBar' => true,
            'text' => "$texto"
        ]);
    }



}
