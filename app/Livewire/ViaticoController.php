<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\User;
use App\Models\Viatico;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ViaticoController extends Component

{
    use LivewireAlert;
    public $title='Viatico';
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

    public $no_viatico=0, $user_id=null, $fecha_viatico=null, $total_viatico=0, $observaciones=null;

    public $viaticos="";
    public $users=[];
    public $id_data=null;

    public $filtroNoViatico=null;
    public $filtroCodigoUsuario=null;
    public $filtroNombreUsuario=null;
    public $filtroApellidoUsuario=null;
    Public $filtroFechaViatico=null;
    /////

    //////DELETE///
    public $delete_no=null;
    public $delete_nombre=null;

    protected $rules = [
        'fecha_viatico'=>'required',
        'total_viatico'=>'numeric|required|min:1',
        'user_id'=>'required',
    ];

    public function render()
    {

    $this->viaticos=Viatico::with('user')
    ->where('no_viatico','LIkE',"%{$this->filtroNoViatico}%")
    ->where('fecha_viatico','LIkE',"%{$this->filtroFechaViatico}%")
    ->whereRelation('user','codigo','LIKE',"%{$this->filtroCodigoUsuario}%")
    ->whereRelation('user','nombres','LIKE',"%{$this->filtroNombreUsuario}%")
    ->whereRelation('user','apellidos','LIKE',"%{$this->filtroApellidoUsuario}%")
    ->get();

        return view('livewire.pages.viatico.index');

    }

    public function create(){
        $this->users=User::all();
        if ($data=Viatico::latest()->first()) {
            $this->id=$data->id+1;
            $this->no_viatico=$this->id;
        }else{
            $this->id=1;
            $this->no_viatico=$this->id;
        }
        $this->fecha_viatico = Carbon::now()->toDateString();
        $this->isCreate=true;
    }

    public function store()
    {
        $this->validate();
        $da=Viatico::create(
            [
                'no_viatico'=>$this->no_viatico,
                'fecha_viatico'=>$this->fecha_viatico,
                'total_viatico'=>$this->total_viatico,
                'user_id'=>$this->user_id,
                'observaciones'=>$this->observaciones,
            ]
        );

        $this->alertaNotificacion("store");
        $this->cancel();
    }

    public function edit($id){
        $this->users=User::all();
        $data = Viatico::find($id);
        $this->id_data=$data->id;
        $this->no_viatico = $data->no_viatico;
        $this->fecha_viatico = $data->fecha_viatico;
        $this->total_viatico = $data->total_viatico;
        $this->user_id = $data->user_id;
        $this->observaciones = $data->observaciones;
        $this->isEdit=true;
    }

    public function update($id){
        $this->validate();
        Viatico::find($id)
        ->update([
            'fecha_viatico'=>$this->fecha_viatico,
            'total_viatico'=>$this->total_viatico,
            'user_id'=>$this->user_id,
            'observaciones'=>$this->observaciones,
        ]);
        $this->alertaNotificacion("update");
        $this->cancel();
    }

    public function delete($id){
        $data = Viatico::find($id);
        $this->id_data=$data->id;
        $this->delete_no=$data->no_viatico;
        $this->delete_nombre=$data->total_viatico;
        $this->isDelete = true;
    }

    public function destroy($id)
    {
        Viatico::find($id)->delete();
        $this->alertaNotificacion("destroy");
        $this->cancel();
    }



    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfViaticoGeneral',['viaticos' => $this->viaticos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {

        $dato=Viatico::with('user')
        ->where('no_viatico',1)

        ->first();

        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfViatico',['dato'=>$dato]);
        /*return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");*/
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter', 'landscape')->stream();
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

