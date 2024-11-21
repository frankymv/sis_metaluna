<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Sucursal;
use Constantes\DepartamentoMunicipio;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class SucursalController extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $title='Sucursal';
    public $data, $per_page=10,  $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    ////////////////////
    public $departamentos=[], $municipios=[];
    public $departamento_id, $municipio_id;
    public $departamento,$municipio;

    ////////////////////

    public $codigo='';
    public $nombre='';
    public $direccion_fisica='';
    public $direccion_departamento=null;
    public $direccion_municipio=null;
    public $telefono_principal='';
    public $telefono_secundario='';
    public $correo_electronico='';
    public $bodega=false;
    public $visible=true;
    public $estado=true;





    ////////////////////

    ////////////////////
    protected $rules = [
        'codigo' => 'required',
        'nombre' => 'required',
        'direccion_fisica' => 'required',
        'direccion_departamento' => 'required',
        'direccion_municipio' => 'required',
    ];
    ////////////////////

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {
        return view('livewire.pages.sucursal.index');
    }

    public function create(){

        $this->departamentos=Departamento::all();
        $this->isCreate=true;

    }

    public function updatedDireccionDepartamento($value){
        $this->reset(['municipios']);

        $this->municipios = Municipio::where('departamento_id',$value)->get();
        $this->reset('municipio_id');
    }






    public function store(){
        $this->validate();
        Sucursal::create(
            ['codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'correo_electronico'=>$this->correo_electronico,
            'bodega'=>$this->bodega,
            'visible'=>$this->visible,
            'estado'=>$this->estado,

            ]
        );

        //
        $this->cancel();

    }

    public function edit($rowId){

        $data = Sucursal::find($rowId);

        $this->departamentos=Departamento::all();
        $this->municipios = Municipio::where('departamento_id',$data->direccion_departamento)->get();


        $this->id_data=$data->id;
        $this->codigo=$data->codigo;
        $this->nombre=$data->nombre;
        $this->direccion_fisica=$data->direccion_fisica;
        $this->direccion_departamento=$data->direccion_departamento;
        $this->direccion_municipio=$data->direccion_municipio;
        $this->telefono_principal=$data->telefono_principal;
        $this->telefono_secundario=$data->telefono_secundario;
        $this->correo_electronico=$data->correo_electronico;

        $this->bodega=$data->bodega;
        $this->visible=$data->visible;
        $this->estado=$data->estado;


        $this->isEdit=true;

    }

    public function show($rowId){

        $data = Sucursal::find($rowId);
        $this->id_data=$data->id;
        $this->codigo=$data->codigo;
        $this->nombre=$data->nombre;
        $this->direccion_fisica=$data->direccion_fisica;
        $this->direccion_departamento=$data->direccion_departamento;
        $this->direccion_municipio=$data->direccion_municipio;
        $this->telefono_principal=$data->telefono_principal;
        $this->telefono_secundario=$data->telefono_secundario;
        $this->correo_electronico=$data->correo_electronico;
        $this->bodega=$data->bodega;
        $this->visible=$data->visible;
        $this->estado=$data->estado;

        $this->disabled=true;
        $this->isShow=true;
    }


    public function update($rowId){
        $this->validate();

        $data = Sucursal::find($rowId);


        $data->update(
            ['codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'correo_electronico'=>$this->correo_electronico,
            'bodega'=>$this->bodega,
            'visible'=>$this->visible,
            'estado'=>$this->estado,

            ]
        );

        //
        $this->cancel();
    }

    public function delete($rowId){
        $data = Sucursal::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->nombre;
        $this->isDelete = true;
    }

    public function destroy($rowId)
    {
        Sucursal::find($rowId)->delete();

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
        $this->reset(['codigo',
        'nombre',
        'direccion_fisica',
        'direccion_departamento',
        'direccion_municipio',
        'telefono_principal',
        'telefono_secundario',
        'correo_electronico',
        'bodega',
        'visible',
        'estado']);
        ////////////////////
    }
}
