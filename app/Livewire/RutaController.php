<?php

namespace App\Livewire;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Ruta;


use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RutaController extends Component
{
    use LivewireAlert;
    public $title='Ruta';
    public $data, $id_data,$id_last;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;
    //
    public $departamentos=[],$municipiosprimero=[],$municipiossegundo=[],$municipiostercero=[],$municipioscuarto=[],$municipiosquinto=[],$municipios=[];
    public $codigotemp_dep,$codigotemp_mun,$codigotemp,$last_dep;
    public $direccion_departamento,$direccion_municipio;
    public $codigo;
    public $nombre,$descripcion;
    public $estado=true;

    public $departamento_id=null;
    public $municipio_id=null;
    public $observaciones=null;



    public $inputs = [];
    public $nombresDetalle= [],$municipioDetalle= [], $observacionDetalle= [];

    public $nombreDepartamento= [], $idDepartamento= [];
    public $nombreMunicipio= [], $idMunicipio= [];

    public $disabled_departamento=false;
    public $disabled_municipio=false;
    public $i=0;
    public $rutas=[];

            /////

            public $delete_no=null,$delete_nombre=null;

    public $filtroCodigo=null, $filtroNombre=null;

    protected $listeners=['edit', 'delete','show','pdfExportar'];

    public function render()
    {
        $this->rutas=Ruta::with('municipios')->with('departamentos')->get();
        return view('livewire.pages.ruta.index');
    }

    public function create(){
        $this->departamentos=Departamento::all();
        $this->isCreate=true;
    }

    public function updatedDepartamentoId($value){
        $this->reset('municipio_id');
            $this->municipios = Municipio::where('departamento_id',$value)->get();
    }

    public function addDetalle(){
        $this->disabled_departamento=true;
        $this->disabled_municipio=true;
        foreach ($this->departamentos as $key => $value) {
            if($value['id']===intval($this->departamento_id)){
                array_push($this->inputs,$this->i);
                array_push($this->idDepartamento ,$value['id']);
                array_push($this->nombreDepartamento ,$value['nombre']);
                array_push($this->observacionDetalle ,$this->observaciones);
            }
        }

        foreach ($this->municipios as $key => $value) {
            if($value['id']===intval($this->municipio_id)){
                array_push($this->idMunicipio ,$value['id']);
                array_push($this->nombreMunicipio ,$value['nombre']);
            }
        }
        $this->i+=1;
        $this->reset(['observaciones','departamento_id','municipio_id']);
    }


    public function removeDetalle($i)
    {
        unset($this->inputs[$i]);
        unset($this->idDepartamento[$i]);
        unset($this->nombreDepartamento[$i]);
        unset($this->observacionDetalle[$i]);
        unset($this->idMunicipio[$i]);
        unset($this->nombreMunicipio[$i]);
    }



    public function store(){


        $this->validate(['codigo'=>'required','nombre'=>'required','inputs'=>'required']);

        $data=Ruta::create(
            [
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,

            'estado'=>$this->estado
        ]
        );
        foreach ($this->inputs as $key => $value) {
            $data->departamentos()->attach($value,['departamento_id' => $this->idDepartamento[$key]]);
            $data->municipios()->attach($value,['municipio_id' => $this->idMunicipio[$key],'observaciones' => 'obbbbbbbbbb']);
        }

        $this->alertaNotificacion("store");
        $this->cancel();


    }

    public function edit($rowId){

        $this->departamentos=Departamento::all();
        $this->municipios=Municipio::all();

        $data = Ruta::find($rowId);
        $this->id_data=$data->id;
        $this->codigo=$data->codigo;
        $this->nombre=$data->nombre;
        $this->descripcion=$data->descripcion;
        $departamentos_temp=$data->departamentos()->get();
        $municipios_temp=$data->municipios()->get();

        foreach ($departamentos_temp as $key => $value) {
            array_push($this->inputs ,$key);
            array_push($this->idDepartamento ,$value->id);
            array_push($this->nombreDepartamento ,$value->nombre);
            array_push($this->idMunicipio ,$municipios_temp[$key]['id']);
            array_push($this->nombreMunicipio ,$municipios_temp[$key]['nombre']);
            array_push($this->observacionDetalle ,$value->id);
        }
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->isEdit=true;
    }

    public function update($id){

        $data = Ruta::find($id);
        $data->update([
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,

            'estado'=>$this->estado
        ]);

        $data->departamentos()->detach();
        $data->municipios()->detach();
        foreach ($this->inputs as $key => $value) {
            $data->departamentos()->attach(['departamento_id' => $this->idDepartamento[$key]]);
            $data->municipios()->attach(['municipio_id' => $this->idMunicipio[$key]]);
        }
        $this->alertaNotificacion("store");
        $this->cancel();
    }

    public function delete($id){
        $data = Ruta::find($id);
        $this->isDelete = true;
        $this->delete_no=$data->codigo;
        $this->delete_nombre=$data->nombre;
        $this->id_data=$data->id;
    }

    public function destroy($id)
    {
        $data = Ruta::find($id);
        $data->delete();
        $this->alertaNotificacion("destroy");
        $this->cancel();
    }

    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfRutaGeneral',['rutas' => $this->rutas]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $data=Ruta::find($id);

        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfRuta',['data'=>$data]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
    }



    public function cancel(){
        $this->reset();
        $this->resetValidation();
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
