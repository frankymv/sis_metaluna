<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class MaterialController extends Component
{
    //




    public $title='Material';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;


    public $nombre, $descripcion, $estado=true;
    public $materiales=null;
    public $estados=null;
    public $filtroNombre=null;
    public $filtroEstado=null;

    protected $rules = [
        'nombre' => 'required',
    ];

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        $this->estados=DataSistema::$estados;


        $this->materiales=Material::where('nombre','LIKE',"%{$this->filtroNombre}%")
        ->where('estado','LIKE',"%{$this->filtroEstado}%")
        ->get();
        return view('livewire.pages.material.index');
    }

    public function create(){
        $this->isCreate=true;
    }


    public function store(){

        $this->validate();

        Material::create(
            [
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado
            ]
        );


        $this->cancel();

    }

    public function edit($rowId){

        $data = Material::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado;
        $this->isEdit=true;
    }

    public function show($rowId){

        $data = Material::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->estado = $data->estado;

        $this->disabled=true;
        $this->isShow=true;
    }


    public function update($rowId){
        $this->validate();

        $data = Material::find($rowId);
        $data->update([

            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado
        ]);



        $this->cancel();
    }

    public function delete($rowId){
        $data = Material::find($rowId);

        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->isDelete = true;
    }

    public function destroy($rowId)
    {

        Material::find($rowId)->delete();

        $this->isDelete = false;
        //session()->flash('message', 'Post Deleted Successfully.');
        $this->cancel();
    }


    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfMaterialGeneral',['data' => $this->materiales]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $data=Material::find($id);
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfMaterial',['data'=>$data]);
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

        ////////////////////
    }


}
