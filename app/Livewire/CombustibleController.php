<?php

namespace App\Livewire;

use App\Models\Combustible;
use App\Models\User;
use App\Models\Vehiculo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;

use Jantinnerezo\LivewireAlert\LivewireAlert;
class CombustibleController extends Component

{
    use LivewireAlert;

    public $title='Combustible';
    public $data, $id_venta=null,$id=null,$no_abono=0;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false,$isCreateAnticipado = false,$isCreateAnticipadoAsignar = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;
    public $nuevo_saldo=0, $fecha_abono=null,$abono_anticipados=null;
    public $tipo_pago=null, $tipo_pago_id=null,$no_pago=0,$detalle_pago='',$clientes=null;
    public $estado=true;

    /////////filtros

    public $filtroCodigoCliente=null;
    Public $filtroFechaAbono=null;

    public $creditos=[];


    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0;
    public $abonos=[],$estado_cuentas=[],$total_abonos;


    public $no_combustible=0, $user_id=null, $fecha_combustible=null, $total_combustible=0, $observaciones=null;
    public $vehiculo_id=null;
    public $combustibles=[];
    public $vehiculos=[];
    public $users=[];
    public $id_data=null;




    public $filtroNoCombustible=null;
    public $filtroUsuario=null;
    public $filtroVehiculo=null;
    public $filtroFechaCombustible=null;
    public $filtroObservaciones=null;
    /////


    //////DELETE///
    public $delete_no=null;
    public $delete_nombre=null;




    protected $rules = [
        'user_id' => 'required',
        'vehiculo_id' => 'required',
        'total_combustible'=>"numeric|required|min:1",
        'fecha_combustible'=>'required',
        'user_id'=>'required',
        'vehiculo_id'=>'required',
    ];


    public function render()
    {

        $this->users=User::all();
        $this->vehiculos=Vehiculo::all();


    $this->combustibles=Combustible::with('user')
    ->with('vehiculo')
    ->where('no_combustible','LIkE',"%{$this->filtroNoCombustible}%")
    ->where('fecha_combustible','LIkE',"%{$this->filtroFechaCombustible}%")
    ->where('observaciones','LIkE',"%{$this->filtroObservaciones}%")
    ->whereRelation('user','id','LIKE',"%{$this->filtroUsuario}%")
    ->whereRelation('vehiculo','id','LIKE',"%{$this->filtroVehiculo}%")
    ->get();
        return view('livewire.pages.combustible.index');
    }

    public function create(){

        $this->vehiculos=Vehiculo::all();
        $this->users=User::all();

        if ($data=Combustible::latest()->first()) {
            $this->id=$data->id+1;
            $this->no_combustible=$this->id;
        }else{
            $this->id=1;
            $this->no_combustible=$this->id;
        }
        $this->fecha_combustible = Carbon::now()->toDateString();
        $this->isCreate=true;
    }

    public function store()
    {
        $this->validate();

        $da=Combustible::create(
            [
                'no_combustible'=>$this->no_combustible,
                'fecha_combustible'=>$this->fecha_combustible,
                'total_combustible'=>$this->total_combustible,
                'user_id'=>$this->user_id,
                'vehiculo_id'=>$this->vehiculo_id,
                'observaciones'=>$this->observaciones,
            ]
        );
        $this->alertaNotificacion("store");
        $this->cancel();
    }


    public function edit($id){
        $this->users=User::all();
        $this->vehiculos=Vehiculo::all();
        $data = Combustible::find($id);
        $this->id_data=$data->id;
        $this->no_combustible = $data->no_combustible;
        $this->fecha_combustible = $data->fecha_combustible;
        $this->total_combustible = $data->total_combustible;
        $this->user_id = $data->user_id;
        $this->vehiculo_id = $data->vehiculo_id;
        $this->observaciones = $data->observaciones;
        $this->isEdit=true;
    }

    public function update($id){
        $this->validate();
        $data = Combustible::find($id);
        $data->update([
            'fecha_combustible'=>$this->fecha_combustible,
            'total_combustible'=>$this->total_combustible,
            'user_id'=>$this->user_id,
            'vehiculo_id'=>$this->vehiculo_id,
            'observaciones'=>$this->observaciones,
        ]);
        $this->alertaNotificacion("update");
        $this->cancel();
    }

    public function delete($id){
        $data = Combustible::find($id);
        $this->delete_no=$data->no_combustible;
        $this->delete_nombre=$data->total_combustible;
        $this->id_data=$data->id;
        $this->isDelete = true;
    }

    public function destroy($id)
    {
        $data = Combustible::find($id);
        $data->delete();
        $this->alertaNotificacion("destroy");
        $this->cancel();
    }


    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCombustibleGeneral',['combustibles' => $this->combustibles]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $dato=Combustible::with('user')
        ->with('vehiculo')
        ->where('no_combustible','LIkE',"%{$this->filtroNoCombustible}%")
        ->where('fecha_combustible','LIkE',"%{$this->filtroFechaCombustible}%")
        ->where('observaciones','LIkE',"%{$this->filtroObservaciones}%")
        ->whereRelation('user','id','LIKE',"%{$this->filtroUsuario}%")
        ->whereRelation('vehiculo','id','LIKE',"%{$this->filtroVehiculo}%")
        ->first();
        //$abono=Viatico::where('no_abono','=',$id)->with('venta')->get()->first()->toArray();
        //$cliente=Cliente::find($abono['cliente_id'])->toArray();
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCombustible',['dato'=>$dato]);
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

