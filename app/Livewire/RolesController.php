<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class RolesController extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $title='Roles';
    public $data, $per_page=10,  $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    ////////////////////
    public $nombre, $descripcion, $estado=true;
    ////////////////////

    public $permisos=[],$roles=[];
    ////////////////////
    protected $rules = [
        'nombre' => 'required',
    ];
    ////////////////////

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {

        $this->roles=Role::all();

        return view('livewire.pages.roles.index');
    }

    public function create(){
        $this->isCreate=true;
        $this->permisos=Permission::all();
    }


    public function borrarFiltros()
    {
        $this->reset();

    }

    public function store(){
        $this->validate();
        Marca::create(
            ['nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado]
        );


        $this->cancel();

    }

    public function edit($rowId){

        $data = Marca::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado;
        $this->isEdit=true;
    }

    public function show($rowId){

        $data = Marca::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->estado = $data->estado;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
    }


    public function update($rowId){
        $this->validate();

        $data = Marca::find($rowId);
        $data->update([
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'estado'=>$this->estado
        ]);


        $this->cancel();
    }

    public function delete($rowId){
        $data = Marca::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->isDelete = true;
    }

    public function destroy($rowId)
    {
        Marca::find($rowId)->delete();

        $this->isDelete = false;
        $this->cancel();
    }


    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfMarcaGeneral',['data' => $this->marcas]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $data=Marca::find($id);
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfMarca',['data'=>$data]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }


    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    public function export_pdf(){



    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        ///////////////////
        $this->reset(['nombre', 'descripcion']);
        ////////////////////
    }


}
