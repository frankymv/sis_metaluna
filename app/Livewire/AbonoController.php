<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
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
    public $created_at,$updated_at,$disabled=false;
    public $nuevo_saldo=0, $fecha_abono=null,$abono_anticipados=null;
    public $tipo_pago=null, $tipo_pago_id=null,$no_pago=0,$detalle_pago='',$clientes=null;


    public $venta_id=null,$abono_anticipado_id=null,$cantidad_credito_actual=0,$cantidad_abono=0,$saldo_credito=0,$estado=0,$observaciones=null,$correlativo=0;
    public $id_data=null;

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

       /* $this->abonos = DB::table('abonos')
        ->rightJoin('ventas','abonos.venta_id','=','ventas.id')
        ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
        ->where('abonos.no_abono','LIKE',"%{$this->filtroNoAbono}%")
        ->where('ventas.no_venta','LIKE',"%{$this->filtroNoVenta}%")
        ->where('abonos.fecha_abono','LIKE',"%{$this->filtroFechaAbono}%")
        ->where('clientes.nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('clientes.codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->get();

*/
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

    public function create(){
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
        $this->ventas_credito=Venta::where('saldo_cancelado','0')->get();
        $this->isCreate=true;

    }
/////////////////////////////////BONO ANTICIPADO/////////////////////////////

    public function buscarVenta(){
    $this->isSearchVenta=true;
    $this->isCreate=false;

    }

    public function abonoAnticipado(){

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

    public function updatedCantidadAbono($value){
            $this->validate([
                'cantidad_abono'=>"numeric|required|min:1|max:$this->saldo_credito"
            ]);
        $this->nuevo_saldo=$this->saldo_credito-$value;
    }

    public function store()
    {
        $this->validate([
            'cantidad_abono'=>"numeric|required|min:1|max:$this->saldo_credito",
            'fecha_abono'=>'required'
        ]);


        $da=Abono::create(
            [
                'abono_anticipado'=>false,
                'abono_anticipado_asignado'=>false,
                'no_abono'=>$this->no_abono,
                'fecha_abono_anticipado'=>$this->fecha_abono,
                'venta_id'=>$this->id_venta,
                'fecha_abono'=>$this->fecha_abono,
                'saldo_credito'=>$this->saldo_credito,
                'total_abono'=>$this->cantidad_abono,
                'total_saldo'=>$this->nuevo_saldo,
                'correlativo'=>$this->correlativo,
                'cliente_id'=>$this->cliente_id,
                'observaciones'=>$this->observaciones,
                'tipo_pago'=>$this->tipo_pago_id,
                'no_pago'=>$this->no_pago,
                'detalle_pago'=>$this->detalle_pago,
            ]
        );

        if($this->nuevo_saldo!=0){
            $venta=DB::table('ventas')
            ->where('id','=', $this->id_venta)
            ->update(['correlativo'=>$this->correlativo,'saldo_total_venta'=>$this->nuevo_saldo]);
        }else{
            $venta=DB::table('ventas')
            ->where('id','=', $this->id_venta)
            ->update(['correlativo'=>$this->correlativo,'saldo_total_venta'=>$this->nuevo_saldo,'saldo_cancelado'=>true, 'fecha_saldo_cancelado'=>$this->fecha_abono]);
        };

        if(DB::table('estado_cuentas')->where('cliente_id',$this->cliente_id)->exists()){
            $estado_cuenta_temp=EstadoCuenta::where('cliente_id',$this->cliente_id)->first();
            $estado_cuenta=DB::table('estado_cuentas')
            ->where('cliente_id','=', $this->cliente_id)
            ->update(['total_abono' => $this->cantidad_abono+$estado_cuenta_temp->total_abono]);
        }else{
            $data=EstadoCuenta::create(
                [
                'cliente_id'=>$this->cliente_id,
                'total_abono'=>$this->cantidad_abono,
                'total_credito'=>0,
                ]
                );

        };


        $this->alertaNotificacion("store");
        $this->cancel();

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
        $this->total_venta=$venta->total_venta;
        $this->saldo_credito=$venta->saldo_total_venta;
        $this->cantidad_credito_actual=$venta->saldo_total_venta ;
        $this->reset(['abono_anticipado_id','cantidad_abono','nuevo_saldo']);

        }


    public function cancelarBuscarVenta(){
        $this->isCreate=true;

        $this->reset(['isSearchVenta','search_no_venta','search_codigo_cliente','search_nombres_cliente','ventas']);
    }

    public function updatedSearchNombresCliente($value){
        $this->reset(['search_no_venta','search_codigo_cliente']);

        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('nombres_cliente','LIKE',"%$value%")
            ->where('saldo_cancelado','=',false)
            ->get();
    }

    public function updatedSearchCodigoCliente($value){
        $this->reset(['search_nombres_cliente','search_no_venta']);
        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('codigo_mayorista','LIKE',"%$value%")
            ->where('saldo_cancelado','=',false)
            ->get();

    }

    public function updatedSearchNoVenta($value){
        $this->reset(['search_nombres_cliente','search_codigo_cliente']);
        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->where('no_venta','LIKE',"%$value%")
            ->where('saldo_cancelado','=',false)
            ->get();

    }

    public function storeAnticipado(){
        $this->validate([
            'cantidad_abono_anticipado'=>"numeric|required|min:1",
            'fecha_abono'=>'required'
        ]);

        Abono::create(
            [
                'abono_anticipado'=>true,
                'no_abono'=>$this->no_abono,
                'fecha_abono'=>$this->fecha_abono,
                'fecha_abono_anticipado'=>$this->fecha_abono,
                'saldo_credito'=>$this->saldo_credito,
                'total_abono'=>$this->cantidad_abono_anticipado,
                'total_saldo'=>'0',
                'correlativo'=>'0',
                'cliente_id'=>$this->cliente_id,
                'observaciones'=>$this->observaciones,
                'tipo_pago'=>$this->tipo_pago_id,
                'detalle_pago'=>$this->detalle_pago,
            ]
        );

        $this->alertaNotificacion("store");
        $this->cancel();


    }

//////////////////////////////////ASIGNAR ABONO ANTICIPADO/////////////////////////////////////
    public function updatedAsignarVentaId($value){

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
            $this->total_venta=$venta->total_venta;
            $this->saldo_credito=$venta->saldo_total_venta;
            $this->cantidad_credito_actual=$venta->saldo_total_venta ;


        $this->saldo_credito_asignar=$venta->saldo_venta;




    }

    public function updatedAsignarAbonoAnticipadoId($value){
        $data=Abono::find($value);

        $this->cantidad_abono_asignar=$data->total_abono;
        $this->nuevo_saldo_asignar= $this->saldo_credito - $this->cantidad_abono_asignar ;
    }

    public function storeAsignarAbonoAnticipado($value){


        $data = Abono::find($value);
        $data->update([
                'venta_id'=>$this->id_venta,
                'fecha_abono'=>$this->fecha_abono,
                'saldo_credito'=>$this->saldo_credito_asignar,
                'total_abono'=>$this->cantidad_abono_asignar,
                'total_saldo'=>$this->nuevo_saldo_asignar,
                'correlativo'=>$this->correlativo,
                'observaciones'=>$this->observaciones,
                'tipo_pago'=>$this->tipo_pago_id,
                'no_pago'=>$this->no_pago,
                'detalle_pago'=>$this->detalle_pago,
                'abono_anticipado_asignado'=>true,
            ]);

        $this->alertaNotificacion("store");

        if($this->nuevo_saldo_asignar!=0){
            DB::table('ventas')
            ->where('id','=', $this->id_venta)
            ->update(['correlativo'=>$this->correlativo,'saldo_total_venta'=>$this->nuevo_saldo_asignar]);
        }else{
            DB::table('ventas')
            ->where('id','=', $this->id_venta)
            ->update(['correlativo'=>$this->correlativo,'saldo_total_venta'=>$this->nuevo_saldo_asignar,'saldo_cancelado'=>true, 'fecha_saldo_cancelado'=>$this->fecha_abono]);
        };

        if(DB::table('estado_cuentas')->where('cliente_id',$this->cliente_id)->exists()){
            $estado_cuenta_temp=EstadoCuenta::where('cliente_id',$this->cliente_id)->first();
            $estado_cuenta=DB::table('estado_cuentas')
            ->where('cliente_id','=', $this->cliente_id)
            ->update(['total_abono' => $this->cantidad_abono_asignar+$estado_cuenta_temp->total_abono]);


        }else{
            $data=EstadoCuenta::create(
                [
                'cliente_id'=>$this->cliente_id,
                'total_abono'=>$this->cantidad_abono_asignar,
                'total_credito'=>0,
                ]
                );
        };




        $this->cancel();

    }


    public function abonoAnticipadoAsignar(){
        $data=Abono::latest()->first();
        $this->fecha_abono = Carbon::now()->toDateString();
        if ($data) {
            $this->id=$data->id+1;
            $this->no_abono=$this->id;

        }else{
            $this->id=1;
            $this->no_abono=$this->id;
        }
        $this->tipo_pago=DataSistema::$forma_pago;
        $this->ventas=Venta::where('saldo_cancelado',false)->get();
        $this->abono_anticipados=Abono::where('abono_anticipado',true)->where('abono_anticipado_asignado',false)->get();
        $this->isCreateAnticipadoAsignar=true;
    }


    public function updatedAbonoAnticipadoId($value)
    {
        $data=Abono::find($value);
        $this->cantidad_abono=$data->total_abono;
        $this->nuevo_saldo=$this->saldo_credito-$this->cantidad_abono;
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

        /*if($abono['venta_id']==null){
            $cliente=Cliente::find($abono['cliente_id'])->toArray();
            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfAbonoAnticipado',['cliente'=>$cliente,'abono'=>$abono]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
        }else{*/
            //$venta=Venta::find($abono['venta_id'])->toArray();
            //$cliente=Cliente::find($abono['venta']['cliente_id'])->toArray();
            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfAbono',['dato' => $dato]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
       // }
    }


    public function delete($id)
    {


        $data = Abono::find($id);
        if($data->abono_anticipado){

            if($data->abono_anticipado_asignado!=true){
                $this->isDelete = true;
                $this->no_abono=$data->no_abono;
                $this->id_data=$data->id;
                $this->no_abono=$data->no_abono;


            }else{

                $data_venta=Venta::find($data->venta_id);

                if($data->correlativo==$data_venta->correlativo){
                    $this->isDelete = true;
                    $this->no_abono=$data->no_abono;
                    $this->id_data=$data->id;
                }else{

                    $this->alert('error', 'No es posible borrar', [
                        'position' => 'center',
                        'timer' => '2000',
                        'toast' => true,
                        'showConfirmButton' => false,
                        'onConfirmed' => '',
                        'timerProgressBar' => true,
                        'text' => 'Existe una operacion anterior',
                    ]);
                }
            };

        }else{
            $data_venta=Venta::find($data->venta_id);

            if($data->correlativo==$data_venta->correlativo){
                $this->isDelete = true;
                $this->no_abono=$data->no_abono;
            }else{

                $this->alert('error', 'No es posible borrar', [
                    'position' => 'center',
                    'timer' => '2000',
                    'toast' => true,
                    'showConfirmButton' => false,
                    'onConfirmed' => '',
                    'timerProgressBar' => true,
                    'text' => 'Existe una operacion anterior',
                ]);
            }
            $this->id_data=$data->id;
            $this->no_abono=$data->no_abono;
        }
        //dd($this->no_abono);
        //$this->id_data=$data->id;



    }

    public function destroy($id)
    {
        $data = Abono::find($id);

        if ($data->abono_anticipado_asignado==false && $data->abono_anticipado==true ) {

            $data->delete();
        }else{

            $this->cantidad_abono=$data->total_abono;
            $this->cliente_id=$data->cliente_id;

            $data_venta = Venta::find($data->venta_id);
            $this->correlativo=$data_venta->correlativo-1;

            if($data_venta->saldo_cancelado){
                $data_venta->update([
                    'correlativo'=>$this->correlativo,
                    'saldo_venta'=>$data->saldo_credito,
                    'saldo_cancelado'=>false,
                ]);
            }else{
                $data_venta->update([
                    'correlativo'=>$this->correlativo,
                    'saldo_venta'=>$data->saldo_credito
                ]);
            }
            $this->alertaNotificacion("destroy");
            $data->delete();


            if(DB::table('estado_cuentas')->where('cliente_id',$this->cliente_id)->exists()){
                $estado_cuenta_temp=EstadoCuenta::where('cliente_id',$this->cliente_id)->first();
                $estado_cuenta=DB::table('estado_cuentas')
                ->where('cliente_id','=', $this->cliente_id)
                ->update(['total_abono' => $estado_cuenta_temp->total_abono-$this->cantidad_abono]);
            }else{

                $data=EstadoCuenta::create(
                    [
                    'cliente_id'=>$this->cliente_id,
                    'total_abono'=>$this->cantidad_abono,
                    'total_credito'=>0,
                    ]
                    );

            };
        };


        $this->cancel();

    }

    public function cancel()
    {
        $this->reset();
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields()
    {

        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at','correlativo']);
        $this->reset(['venta_id','cantidad_credito_actual','cantidad_abono','saldo_credito','no_abono','id']);


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
