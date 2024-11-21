<?php

namespace App\Livewire;

use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Proveedor;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class ProveedorController extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $title='Proveedor';
    public $data, $per_page=10,  $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    public $id_last,$nombre,$departamento,$municipio, $descripcion, $nit, $nombre_representante, $telefono_principal, $telefono_secundario, $direccion_fisica, $direccion_departamento, $direccion_municipio, $correo_electronico,$estado=true;
    public $departamentos, $municipios=[], $departamento_id, $municipio_id;



    protected $rules = [

        'nombre' => 'required',
        'nombre_representante' => 'required',
        'telefono_principal' => 'required',
        'direccion_fisica' => 'required',
        'direccion_departamento' => 'required',
        'direccion_municipio' => 'required',

    ];
    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        $this->departamentos=Departamento::all();
        return view('livewire.pages.proveedor.index');
    }
    public function create(){
        $this->isCreate=true;
        $this->departamentos=Departamento::all();
    }

    public function store(){

        $this->validate();
        Proveedor::create(
            [
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'nit'=>$this->nit,
            'nombre_representante'=>$this->nombre_representante,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'correo_electronico'=>$this->correo_electronico,
            'estado'=>$this->estado
            ]
        );


        $this->cancel();

    }

    public function edit($rowId){

        $data = Proveedor::find($rowId);

        $this->departamentos=Departamento::all();
        $this->municipios = Municipio::where('departamento_id',$data->direccion_departamento)->get();
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->nit = $data->nit;
        $this->nombre_representante = $data->nombre_representante;
        $this->telefono_principal = $data->telefono_principal;
        $this->telefono_secundario = $data->telefono_secundario;
        $this->direccion_fisica = $data->direccion_fisica;
        $this->direccion_departamento = $data->direccion_departamento;
        $this->direccion_municipio = $data->direccion_municipio;
        $this->correo_electronico = $data->correo_electronico;
        $this->estado = $data->estado;
        $this->isEdit = true;
    }

    public function show($rowId){

        $data = Proveedor::find($rowId);
        $dep=Departamento::find($data->direccion_departamento);
        $mun=Municipio::find($data->direccion_municipio);

        $this->nombre = $data->nombre;
        $this->descripcion = $data->descripcion;
        $this->nit = $data->nit;
        $this->nombre_representante = $data->nombre_representante;
        $this->telefono_principal = $data->telefono_principal;
        $this->telefono_secundario = $data->telefono_secundario;
        $this->direccion_fisica = $data->direccion_fisica;
        $this->departamento = $dep->nombre;
        $this->municipio = $mun->nombre;
        $this->correo_electronico = $data->correo_electronico;
        $this->estado = $data->estado===1?"$this->estadoTrue":"$this->estadoFalse";
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
    }

    public function update(){
        $this->validate();

        $data = Proveedor::find($this->id_data);
        $data->update([
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'nit'=>$this->nit,
            'nombre_representante'=>$this->nombre_representante,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'municipio_id'=>$this->municipio_id,
            'correo_electronico'=>$this->correo_electronico,
            'estado'=>$this->estado
        ]);

        $this->cancel();

        $this->resetInputFields();


    }

    public function delete($rowId){

        $data = Proveedor::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->isDelete = true;
    }

    public function destroy($rowId)
    {

        Proveedor::find($rowId)->delete();

        $this->cancel();
    }

    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();

    }
    private function resetInputFields(){

        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        $this->reset(['nombre', 'descripcion','nit','nombre_representante','telefono_principal','telefono_secundario','direccion_fisica','direccion_departamento','direccion_municipio','correo_electronico','estado','departamento_id','municipio_id']);
    }

    public function updatedDireccionDepartamento($value){
        $this->municipios = Municipio::where('departamento_id',$value)->get();
        $this->reset('municipio_id');
    }






}
