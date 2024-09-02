<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Disenio;
use App\Models\Material;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

class DisenioController extends Component
{

    public $title='Diseño';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    ////////////////////
    public $nombre, $descripcion, $estado=true;
    ////////////////////


    public $estados=null;
    public $disenios=null;
    public $filtroNombre=null;
    public $filtroEstado=null;


    ////////////////////
    protected $rules = [
        'nombre' => 'required',
    ];
    ////////////////////

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        $this->estados=DataSistema::$estados;


        $this->disenios=Disenio::where('nombre','LIKE',"%{$this->filtroNombre}%")
        ->where('estado','LIKE',"%{$this->filtroEstado}%")
        ->get();
        return view('livewire.pages.disenio.index');
    ////////////////////
    }

    public function create(){
        $this->isCreate=true;
    }

    public function store(){
        $this->validate();
    ////////////////////
        Disenio::create(
            [
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado
            ]
        );
    ////////////////////

        $this->cancel();
    }

    public function edit($rowId){
    ////////////////////
        $data = Disenio::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado;
        $this->isEdit=true;
    ////////////////////
    }

    public function show($rowId){
    ////////////////////
        $data = Disenio::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
    ////////////////////
    }


    public function update($rowId){
        $this->validate();
    ////////////////////
        $data = Disenio::find($rowId);
        $data->update([
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado
        ]);
    ////////////////////

        $this->cancel();
    }

    public function delete($rowId){
    ////////////////////
        $data = Disenio::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->isDelete = true;
    ////////////////////
    }

    public function destroy($rowId)
    {
    ////////////////////
       Disenio::find($rowId)->delete();
    ////////////////////


        $this->cancel();

    }



    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfDisenioGeneral',['data' => $this->disenios]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }



    public function exportarFila($id)
    {


        $data=Disenio::find($id);

            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfDisenio',['data'=>$data]);
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
