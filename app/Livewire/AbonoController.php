<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Constantes\VehiculoData as Notifi;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\EstadoCuenta;
use App\Models\Venta;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class AbonoController extends Component
{
    use LivewireAlert;

    public $title='Abono';
    public $data, $id_venta=null,$id=null,$no_abono=0;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false,$isCreateAnticipado = false,$isCreateAnticipadoAsignar = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false,$disabledAsignarAbonoAnticipado=false;
    public $nuevo_saldo=0, $fecha_abono=null,$abono_anticipados=null;
    public $tipo_pago=null, $tipo_pago_id=null,$no_pago=0,$detalle_pago='',$clientes=null;


    public $venta_id=null,$abono_anticipado_id=null,$cantidad_credito_actual=0,$cantidad_abono=0,$saldo_credito=0,$estado=0,$observaciones=null,$correlativo=0;
    public $id_data=null;
    //

    public $abono_id=null;


    //bono anticipado
    public $cliente_id=null;
    public $cantidad_abono_anticipado=null;


    //bono anticipado asignar
    public $saldo_credito_asignar=0;
    public $cantidad_abono_asignar=0;
    public $nuevo_saldo_asignar=0;
    public $asignar_venta_id=null;
    public $asignar_abono_anticipado_id=null;


    public $ventas_credito=null;
    public $isSearchVenta=false;
    public $ventas=[];
    public $no_venta=0;

    public $search_no_venta,$search_nombres_cliente,$search_codigo_cliente;

    protected $listeners=['pdfExportar','delete'];


    /////////filtros
    public $filtroNoAbono=null;
    public $filtroNoVenta=null;
    public $filtroNombreCliente=null;
    public $filtroCodigoCliente=null;
    Public $filtroFechaAbono=null;

    public $creditos=[];




    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0;
    public $abonos=[],$estado_cuentas=[],$total_abonos;
    /////

    //cliente
    public $codigo_interno=null,$nombre_empresa=null,$nombres_cliente=null,$apellidos_cliente=null;

    //venta
    public $total_venta=0,$fecha_venta=null;
    public $saldo_cancelado=false;

    protected $rules = [
        'venta_id' => 'required',
        'cantidad_credito_actual'=>'required',
        'cantidad_abono'=>'required',
        'saldo_credito'=>'required'
    ];


    public function render()
    {
        $this->abonos= Abono::with('venta')->with('cliente')
            ->where('no_abono','LIkE',"%{$this->filtroNoAbono}%")
            ->where('fecha_abono','LIkE',"%{$this->filtroFechaAbono}%")
            ->whereRelation('cliente','codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->get();

        $this->total_abonos= Abono::with('venta')->with('cliente')
            ->where('no_abono','LIkE',"%{$this->filtroNoAbono}%")
            ->where('fecha_abono','LIkE',"%{$this->filtroFechaAbono}%")
            ->whereRelation('cliente','codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->sum('total_abono');

        return view('livewire.pages.abono.index');
    }


    ////////////////// ABONO////////////////////////
    public function create()
    {
        $this->disabled=true;
        $data=Abono::latest()->first();
        if ($data) {
            $this->id=$data->id+1;
            $this->no_abono=$this->id;
        }else{
            $this->id=1;
            $this->no_abono=$this->id;
        }

        $this->tipo_pago=DataSistema::$forma_pago;
        $this->fecha_abono = Carbon::now()->toDateString();

        $this->isCreate=true;
    }

    public function buscarVenta()
    {

        $this->isSearchVenta=true;
        $this->isCreate=false;
    }

    public function updatedSearchNombresCliente($value)
    {
        $this->reset(['search_no_venta','search_codigo_cliente']);

        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('nombres_cliente','LIKE',"%$value%")
            ->where('cancelado_total_venta','=',false)
            ->where('anulado','=',false)
            ->get();
    }

    public function updatedSearchCodigoCliente($value)
    {
        $this->reset(['search_nombres_cliente','search_no_venta']);
        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('codigo_mayorista','LIKE',"%$value%")
            ->where('cancelado_total_venta','=',false)
            ->where('anulado','=',false)
            ->get();

    }

    public function updatedSearchNoVenta($value)
    {
        $this->reset(['search_nombres_cliente','search_codigo_cliente']);
        /*$this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('no_venta','LIKE',"%$value%")
            ->where('cancelado_total_venta','=',false)
            ->select('(ventas.total_venta - ventas.total_nota_credito) as total_venta')
            ->get();
        */
            $this->ventas=Venta::with("cliente")
            ->where('no_venta','LIKE',"%$value%")
            ->where('cancelado_total_venta','=',false)
            ->where('anulado','=',false)
            ->get();


    }

    public function agregarVenta($id)
    {

        $this->cancelarBuscarVenta();
        $venta=Venta::find($id);
        $this->no_venta=$venta->no_venta;
        $this->venta_id=$venta->id;
        $this->fecha_venta=$venta->fecha_venta;
        $this->cliente_id=$venta->cliente_id;
        $this->codigo_interno=$venta->cliente->codigo_interno;
        $this->nombre_empresa=$venta->cliente->nombre_empresa;
        $this->nombres_cliente=$venta->cliente->nombres_cliente;
        $this->apellidos_cliente=$venta->cliente->apellidos_cliente;
        $this->correlativo=$venta->correlativo+1;
        $this->id_venta=$venta->id;
        $this->total_venta=$venta->total_venta-$venta->total_nota_credito;
        $this->saldo_credito=($venta->total_venta-$venta->total_nota_credito)-$venta->total_abono;
        $this->cantidad_credito_actual=$venta->saldo_total_venta ;
        $this->reset(['abono_anticipado_id','cantidad_abono','nuevo_saldo']);

    }

    public function updatedCantidadAbono($value)
    {

            $this->validate([
                'cantidad_abono'=>"numeric|required|min:1|max:$this->saldo_credito"
            ]);
        $this->nuevo_saldo=$this->saldo_credito-$value;
    }

    public function store()
    {
        $this->validate([
            'cantidad_abono'=>"numeric|required|min:1|max:$this->saldo_credito",
            'fecha_abono'=>'required',
            'tipo_pago_id'=>'required',
        ]);

        $venta=Venta::find($this->id_venta);
        $venta->correlativo+=1;
        Abono::create([
                'no_abono'=>$this->no_abono,
                'fecha_abono'=>$this->fecha_abono,
                'total_abono'=>$this->cantidad_abono,
                'observaciones'=>$this->observaciones,
                'abono_anticipado'=>false,
                'abono_anticipado_asignado'=>false,
                'fecha_abono_anticipado_asignado'=>null,
                'tipo_pago'=>$this->tipo_pago_id,
                'detalle_pago'=>$this->detalle_pago,
                'correlativo'=>$venta->correlativo,
                'venta_id'=>$this->id_venta,
                'cliente_id'=>$this->cliente_id,
            ]
        );
        $venta->abono=true;
        $venta->total_abono=$venta->total_abono+$this->cantidad_abono;
        $venta->save();

        if($estado_cuenta=EstadoCuenta::where('cliente_id',$this->cliente_id)->first()){
            $estado_cuenta->total_abono=$estado_cuenta->total_abono+$this->cantidad_abono;
            $estado_cuenta->save();
        }else{
            EstadoCuenta::created([
                'cliente_id'=>$this->cliente_id,
                'total_abono'=>$this->total_abono,
            ]);
        }






        $this->alertaNotificacion("store");
        $this->cancel();

    }

/////////////////////////////////ABONO ANTICIPADO/////////////////////////////

    public function abonoAnticipado()
    {
        if ($data=Abono::latest()->first() ) {
            $this->id=$data->id+1;
            $this->no_abono=$this->id;
        }else{
            $this->id=1;
            $this->no_abono=$this->id;
        }
        $this->tipo_pago=DataSistema::$forma_pago;
        $this->fecha_abono = Carbon::now()->toDateString();
        $this->clientes=Cliente::all();
        $this->isCreateAnticipado=true;
    }

    public function storeAnticipado()
    {
        $this->validate([
            'cantidad_abono'=>"numeric|required|min:1",
            'fecha_abono'=>'required',
            'tipo_pago_id'=>'required',
        ]);
        Abono::create([
            'abono_anticipado'=>true,
            'abono_anticipado_asignado'=>false,
            'no_abono'=>$this->no_abono,
            'fecha_abono'=>$this->fecha_abono,
            'total_abono'=>$this->cantidad_abono,
            'observaciones'=>$this->observaciones,
            'abono_anticipado'=>true,
            'abono_anticipado_asignado'=>false,
            'tipo_pago'=>$this->tipo_pago_id,
            'detalle_pago'=>$this->detalle_pago,
            'cliente_id'=>$this->cliente_id,
        ]);
        $this->alertaNotificacion("store");
        $this->cancel();
    }

    //////////////////////////////////ASIGNAR ABONO ANTICIPADO/////////////////////////////////////

    public function abonoAnticipadoAsignar()
    {


        $this->ventas_credito=Venta::where('cancelado_total_venta','=',false)
        ->where('anulado','=',false)->get();

        $this->disabledAsignarAbonoAnticipado=true;
        $this->fecha_abono = Carbon::now()->toDateString();

        $this->tipo_pago=DataSistema::$forma_pago;
        $this->ventas=Venta::where('cancelado_total_venta',false)->get();
        $this->abono_anticipados=Abono::where('abono_anticipado',true)->where('abono_anticipado_asignado',false)->get();
        $this->isCreateAnticipadoAsignar=true;
    }

    public function updatedAsignarVentaId($value)
    {

        $this->reset(['abono_anticipado_id','cantidad_abono','nuevo_saldo','asignar_abono_anticipado_id','no_venta','fecha_venta','total_venta','saldo_credito','codigo_interno',
        'nombre_empresa','nombres_cliente','apellidos_cliente','cantidad_abono_asignar','nuevo_saldo_asignar']);

        $venta=Venta::find($value);

        $this->no_venta=$venta->no_venta;
        $this->venta_id=$venta->id;
        $this->fecha_venta=$venta->fecha_venta;
        $this->cliente_id=$venta->cliente_id;
        $this->codigo_interno=$venta->cliente->codigo_interno;
        $this->nombre_empresa=$venta->cliente->nombre_empresa;
        $this->nombres_cliente=$venta->cliente->nombres_cliente;
        $this->apellidos_cliente=$venta->cliente->apellidos_cliente;
        $this->correlativo=$venta->correlativo+1;
        $this->id_venta=$venta->id;
        $this->saldo_credito= $venta->saldo_total_venta;
        $this->cantidad_credito_actual=$venta->saldo_total_venta;
        $this->total_venta=($venta->total_venta-$venta->total_nota_credito)-$venta->total_abono;
    }

    public function updatedAsignarAbonoAnticipadoId($value)
    {
        $data=Abono::find($value);
        $this->no_abono=$data->no_abono;
        $this->cantidad_abono_asignar=$data->total_abono;

        $this->nuevo_saldo_asignar= $this->total_venta- $this->cantidad_abono_asignar ;
    }

    public function storeAsignarAbonoAnticipado($value)
    {
        $this->validate(['asignar_abono_anticipado_id'=>'required','asignar_venta_id'=>'required']);

        $venta=Venta::find($this->asignar_venta_id);
        $venta->correlativo+=1;
        $data = Abono::find($this->no_abono);
        $data->update([
            'venta_id'=>$venta->id,
            'fecha_abono_anticipado_asignado'=>$this->fecha_abono,
            'correlativo'=>$venta->correlativo,
            'observaciones'=>"Abono Anticipado Asignado,$this->observaciones",
            'abono_anticipado_asignado'=>true,
        ]);
        $venta->abono=true;
        $venta->total_abono=$venta->total_abono+$data->total_abono;
        $venta->save();


        if($estado_cuenta=EstadoCuenta::where('cliente_id',$this->cliente_id)->first()){
            $estado_cuenta->total_abono=$estado_cuenta->total_abono+$data->total_abono;
            $estado_cuenta->save();
        }else{
            EstadoCuenta::created([
                'cliente_id'=>$this->cliente_id,
                'total_abono'=>$this->total_abono,
            ]);
        }

        $this->alertaNotificacion("store");
        $this->cancel();

    }


//////////////////////////////////////////
    public function delete($id)
    {
        $data = Abono::find($id);
        $this->isDelete = true;
        $this->no_abono=$data->no_abono;
        $this->id_data=$data->id;
    }

    public function destroy($id)
    {
        $abono_temp = Abono::find($id);


        if($abono_temp->abono_anticipado==false && $abono_temp->abono_anticipado_asignado==false){
            //dd("abono normal");
            $venta_temp=Venta::find($abono_temp->venta_id);
            if($venta_temp->anulado==false){
                $venta_temp->correlativo-=1;
                $venta_temp->total_abono-=$abono_temp->total_abono;
                //dd("abono normal de venta no anulado");


                if($estado_cuenta=EstadoCuenta::where('cliente_id',$abono_temp->cliente_id)->first()){
                    $estado_cuenta->total_abono-=$abono_temp->total_abono;
                    $estado_cuenta->save();
                }
                $venta_temp->save();
                $abono_temp->delete();
                $this->alertaNotificacion("destroy");
            }else{
               //dd("error abono normal no borrar por anulado");
                $this->alertaNotificacion("error");
            }
        }elseif($abono_temp->abono_anticipado==true && $abono_temp->abono_anticipado_asignado==false ) {
            //dd("anticipado/no asignado");
            $abono_temp->delete();
            $this->alertaNotificacion("destroy");
        }elseif($abono_temp->abono_anticipado==true && $abono_temp->abono_anticipado_asignado==true){
            //dd("anticipado/y asignado");
            $venta_temp=Venta::find($abono_temp->venta_id);
            if($venta_temp->anulado==false){
                //dd("anticipado/y asignado /// y no anuadooo");
                $venta_temp->correlativo-=1;
                $venta_temp->total_abono-=$abono_temp->total_abono;


                if($estado_cuenta=EstadoCuenta::where('cliente_id',$abono_temp->cliente_id)->first()){
                    $estado_cuenta->total_abono-=$abono_temp->total_abono;
                    $estado_cuenta->save();
                }
                $venta_temp->save();
                $abono_temp->delete();
                $this->alertaNotificacion("destroy");
            }else{
                $this->alertaNotificacion("error");
            }

        }

       // $this->alertaNotificacion("destroy");
        $this->cancel();
    }

    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfAbonoGeneral',['abonos' => $this->abonos,'total_abonos'=>$this->total_abonos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $dato=Abono::where('no_abono','=',$id)->with('venta')->first();
            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfAbono',['dato' => $dato]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
    }


    public function cancel()
    {
        $this->reset();
        $this->resetInputFields();
        $this->resetValidation();
    }

    public function cancelarBuscarVenta()
    {
        $this->isCreate=true;

        $this->reset(['isSearchVenta','search_no_venta','search_codigo_cliente','search_nombres_cliente','ventas']);
    }

    private function resetInputFields()
    {
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at','correlativo']);
        $this->reset(['venta_id','cantidad_credito_actual','cantidad_abono','saldo_credito','no_abono','id']);
    }

    public function alertaNotificacion($tipo)
    {

        $alerta="";
        $title="";
        $texto="";
        if($tipo=="store"){

            $title="Agregar";
            $texto="Registro agregado";
            $alerta="success";

        }elseif($tipo=="update"){
            $title="Editar";
            $texto="Registro editado";
            $alerta="success";

        }elseif($tipo=="destroy"){
            $title="Borrar";
            $texto="Registro borrado";
            $alerta="success";
        }elseif($tipo=="error"){
            $title="Error";
            $texto="No se completo la operación";
            $alerta="error";
        }elseif($tipo=="errorCorrelativo"){
            $title="Error";
            $texto="No se completo la operación,existe operacion previa";
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
