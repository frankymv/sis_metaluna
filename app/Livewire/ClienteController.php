<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Cliente;
use App\Models\Departamento;
use App\Models\Municipio;
use App\Models\Ruta;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClienteController extends Component
{
    use LivewireAlert;
    public $title='Cliente';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;
    public $last_dep=false;
    public $codigotemp_dep,$codigotemp_mun,$codigotemp;


    public $isDisabledMinorista=true;

    public $disabledCodigo=true,
    $codigo_interno=null,
    $codigo_mayorista=null,
    $nombre_empresa='',
    $nombres_cliente='',
    $tipo_cliente_id=null,
    $apellidos_cliente='',
    $cui='',
    $numero_patente='',
    $nit='',
    $telefono_principal='',
    $telefono_secundario='',
    $direccion_fisica='',
    $direccion_departamento=null,
    $direccion_municipio=null,
    $ubicacion_latitud=0,
    $ubicacion_longitud=0,
    $correo_electronico,
    $limite_credito=0,
    $dias_limite_credito=30,
    $estado=true,
    $id=0;

    public $clientes;
    public $rutas;
    public $tipo_clientes=[];

    ////disabled////////
    public $disabled_codigo_interno=false;

    public $departamentos=[], $municipios=[];
    public $departamento_id, $municipio_id;
    public $departamento,$municipio;




    public $filtroCodigoInterno=null;
    public $filtroCodigMayorista=null;
    public $filtroTipoCliente=null;
    public $filtroNombresCliente=null;
    public $filtroApellidosCliente=null;
    public $filtroRuta=null;

      //////DELETE///
      public $delete_no=null;
      public $delete_nombre=null;

    protected $rules = [
        'nit' => 'required',
        'tipo_cliente_id' => 'required',
        'nombres_cliente' => 'required',
        'apellidos_cliente' => 'required',
        'telefono_principal' => 'required',
        'direccion_fisica' => 'required',
        'direccion_departamento' => 'required',
        'direccion_municipio' => 'required',
    ];

    protected $listeners=['edit', 'delete','show'];

    public function render()
    {

        $this->clientes=Cliente::with('ruta')
        ->where('codigo_interno','LIkE',"%{$this->filtroCodigoInterno}%")
        ->where('codigo_mayorista','LIkE',"%{$this->filtroCodigMayorista}%")
        ->where('tipo_cliente','LIkE',"%{$this->filtroTipoCliente}%")
        ->where('nombres_cliente','LIkE',"%{$this->filtroNombresCliente}%")
        ->where('apellidos_cliente','LIkE',"%{$this->filtroApellidosCliente}%")
        ->whereRelation('ruta','id','LIKE',"%{$this->filtroRuta}%")
        ->get();


        $this->rutas=Ruta::all();
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        return view('livewire.pages.cliente.index');
    }

    public function create(){

        if ($data=Cliente::latest()->first()) {
            $this->id=$data->id+1;
            $this->codigo_interno=$this->id;

        }else{
            $this->id=1;
            $this->codigo_interno=$this->id;
        }

        $this->isCreate=true;
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        $this->departamentos=Departamento::all();
        $this->disabled_codigo_interno=true;
    }


    public function updatedTipoClienteId ($value){
        if($value!='MAYO')
        {
            $this->isDisabledMinorista=true;
            $this->reset(['numero_patente','cui','ubicacion_latitud' ,'ubicacion_longitud','limite_credito','dias_limite_credito']);
        }else{
            $this->isDisabledMinorista=false;
            $data=Cliente::where('tipo_cliente','MAYO')->latest()->first();
            $this->codigo_mayorista=$data->codigo_mayorista+1;
        }
    }

    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfClienteGeneral',['clientes' => $this->clientes]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }



    public function exportarFila($id)
    {
        $dato=Cliente::with('ruta')
        ->where('id','=',$id)
        ->first();
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCliente',['dato' => $dato]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function store(){
        $this->validate();

            if($this->tipo_cliente_id!='MAYO')
            {
                $this->isDisabledMinorista=true;
                $this->limite_credito=0;
            }else{
                $this->isDisabledMinorista=false;

            }


        Cliente::create(
            [
            'codigo_interno'=> $this->codigo_interno,
            'codigo_mayorista'=> $this->codigo_mayorista,
            'nombre_empresa'=> $this->nombre_empresa,
            'nombres_cliente'=>$this->nombres_cliente,
            'apellidos_cliente'=>$this->apellidos_cliente,
            'cui'=>$this->cui,
            'numero_patente'=>$this->numero_patente,
            'nit'=>$this->nit,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'ubicacion_latitud'=>$this->ubicacion_latitud,
            'ubicacion_longitud'=>$this->ubicacion_longitud,
            'correo_electronico'=>$this->correo_electronico,
            'limite_credito'=>$this->limite_credito,
            'dias_limite_credito'=>$this->dias_limite_credito,
            'tipo_cliente'=>$this->tipo_cliente_id,
            'estado'=>$this->estado
            ]
        );
        $this->alertaNotificacion("store");
        $this->cancel();
    }




    public function edit($rowId){
        $data = Cliente::find($rowId);
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        $this->departamentos=Departamento::all();
        $this->municipios = Municipio::where('departamento_id',$data->direccion_departamento)->get();

        $this->id_data=$data->id;
        $this->codigo_interno = $data->codigo_interno;
        $this->codigo_mayorista = $data->codigo_mayorista;
        $this->nombre_empresa = $data->nombre_empresa;
        $this->nombres_cliente = $data->nombres_cliente;
        $this->apellidos_cliente = $data->apellidos_cliente;
        $this->cui = $data->cui;
        $this->numero_patente = $data->numero_patente;
        $this->nit = $data->nit;
        $this->telefono_principal = $data->telefono_principal;
        $this->telefono_secundario = $data->telefono_secundario;
        $this->direccion_fisica = $data->direccion_fisica;
        $this->direccion_departamento = $data->direccion_departamento;
        $this->direccion_municipio = $data->direccion_municipio;
        $this->ubicacion_latitud = $data->ubicacion_latitud;
        $this->ubicacion_longitud = $data->ubicacion_longitud;
        $this->correo_electronico = $data->correo_electronico;
        $this->estado = $data->estado;
        $this->limite_credito=$data->limite_credito;
        $this->dias_limite_credito=$data->dias_limite_credito;

        $this->tipo_cliente_id=$data->tipo_cliente;


        if($data->tipo_cliente!='MAYO')
        {
            $this->isDisabledMinorista=true;
        }else{
            $this->isDisabledMinorista=false;

        }


        $this->isEdit = true;
    }


    public function update($id){
        $this->validate();
        Cliente::find($id)->update([
            'codigo_interno'=> $this->codigo_interno,
            'codigo_mayorista'=> $this->codigo_mayorista,
            'nombre_empresa'=> $this->nombre_empresa,
            'nombres_cliente'=>$this->nombres_cliente,
            'apellidos_cliente'=>$this->apellidos_cliente,
            'cui'=>$this->cui,
            'numero_patente'=>$this->numero_patente,
            'nit'=>$this->nit,
            'telefono_principal'=>$this->telefono_principal,
            'telefono_secundario'=>$this->telefono_secundario,
            'direccion_fisica'=>$this->direccion_fisica,
            'direccion_departamento'=>$this->direccion_departamento,
            'direccion_municipio'=>$this->direccion_municipio,
            'ubicacion_latitud'=>$this->ubicacion_latitud,
            'ubicacion_longitud'=>$this->ubicacion_longitud,
            'correo_electronico'=>$this->correo_electronico,
            'limite_credito'=>$this->limite_credito,
            'dias_limite_credito'=>$this->dias_limite_credito,
            'tipo_cliente'=>$this->tipo_cliente_id,
            'estado'=>$this->estado
        ]);
        $this->alertaNotificacion("update");
        $this->cancel();
    }

    public function delete($id){
        $data = Cliente::find($id);
        $this->id_data=$data->id;
        $this->delete_no= $data->codigo_interno;
        $this->delete_nombre= $data->nombres_cliente;
        $this->isDelete = true;
    }


    public function destroy($id)
    {
        Cliente::find($id)->delete();
        $this->alertaNotificacion("destroy");
        $this->cancel();
    }

    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){

        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        $this->reset(['codigo_interno','nombre_empresa','isDisabledMinorista' ,'tipo_cliente_id','nombres_cliente', 'apellidos_cliente','cui', 'numero_patente','nit','telefono_principal' ,'telefono_secundario', 'direccion_fisica','direccion_departamento','direccion_municipio','ubicacion_latitud' ,'ubicacion_longitud', 'correo_electronico','departamento_id','municipio_id','departamentos','municipios','limite_credito','dias_limite_credito']);

    }



    public function updatedDireccionDepartamento($value){
        $codigo=Departamento::find($value);
        $this->municipios = Municipio::where('departamento_id',$value)->get();
        $this->last_dep=true;
        $this->reset('municipio_id');
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
