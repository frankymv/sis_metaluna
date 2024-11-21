<?php

namespace App\Livewire;

use Livewire\Component;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;



class RoleController extends Component
{
    use LivewireAlert;
    use WithPagination;
    //use LivewireAlert;
    public $nombre, $estado=1,$created_at,$updated_at,$roles;
    //
    public $permisson;
    public $data, $per_page=10,  $id_data;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $isDelete = false;
    public $role_selected=[];
    public $role_selec;

    public $title='Rol';


    protected $rules = [
        'nombre' => 'required',
    ];

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {

        $this->permisson=Permission::all();

        $this->roles=Role::all();
        return view('livewire.pages.role.index');
    }

    public function create(){
        $this->isCreate=true;
    }


    public function store(){

        $this->validate();

        $role=Role::create(
            [
            'name'=>$this->nombre,
            ]
        );

        $role->permissions()->sync($this->role_selected);

       // $this->alert('success', 'Registro completo');

        $this->cancel();

    }

    public function edit($rowId){
        $this->permisson=Permission::all();

        $data = Role::find($rowId);
        $this->role_selec=$data->permissions;
        //dd($this->role_selected);

        //$data->permissions()->sync($this->role_selected);
        $this->id_data=$data->id;
        $this->nombre = $data->name;
        $this->estado = $data->estado;
        $this->isEdit=true;
    }

    public function show($rowId){




        $data = Role::find($rowId);
        $this->role_selec=$data->permissions;
        $this->id_data=$data->id;
        $this->nombre = $data->name;
        $this->estado = $data->estado;
        $this->created_at=$data->created_at;
        $this->updated_at=$data->updated_at;
        $this->isShow=true;
    }


    public function update($rowId){


        $data = Role::find($rowId);
        $data->update([
            'name'=>$this->nombre,
            'estado'=>$this->estado
        ]);

        $data->permissions()->sync($this->role_selected);

        $this->alert('success', 'Registro completo');

        $this->cancel();
    }

    public function delete($rowId){
        $data = Role::find($rowId);
        $this->id_data=$data->id;
        $this->nombre = $data->name;
        $this->isDelete = true;
    }

    public function destroy($rowId)
    {

        Role::find($rowId)->delete();

        //$this->alert('error', 'Registro eliminado');
        $this->isDelete = false;
        $this->cancel();
    }

    public function cancel(){
        $this->isCreate = false;
        $this->isEdit = false;
        $this->isShow = false;
        $this->isDelete = false;
        $this->resetInputFields();
    }

    private function resetInputFields(){
        $this->reset(['nombre','estado','role_selected']);
    }


}
