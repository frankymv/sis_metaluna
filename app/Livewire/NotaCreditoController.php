<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\EstadoCuenta;
use App\Models\Inventario;
use App\Models\NotaCredito;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class NotaCreditoController extends Component
{
    use LivewireAlert;
    public $title='Nota de Credito';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;
    public $nuevo_saldo=0, $fecha_abono=null;
    public $anulacion_venta=false,$anulado=false;
    public $isSearchVenta=false;


    //cliente
    public $codigo_interno=null,$nombre_empresa=null,$nombres_cliente=null;

    //venta
    public $total_venta=0,$fecha_venta=null;
    public $saldo_cancelado=false;

    //notacredito
    public $id=null,$no_nota_credito=null,$total_total_nota_credito=0,$fecha_nota_credito=null,$cantidad_existencia=null;

    public $venta_id=null,$cantidad_credito_actual=0,$cantidad_abono=0,$saldo_credito=0,$estado=0,$observaciones=null,$correlativo=0;
    public $tipo_pago=[['id'=>'0','nombre'=>'contado'],['id'=>'1','nombre'=>'credito'],['id'=>'2','nombre'=>'abono']];
    public $anulacion=false;

    public $ventas=[];

    public $search_no_venta,$search_nombres_cliente,$search_codigo_cliente;

        /////////filtros
        public $filtroNoNotaCredito=null;
        public $filtroNoVenta=null;
        public $filtroNombreCliente=null;
        public $filtroCodigoCliente=null;
        Public $filtroFechaNotaCredito=null;

        public $nota_creditos=[];

        public $no_venta=null,$apellidos_cliente=null;


        public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0,$saldo_total_venta=0;
        public $abonos=[],$estado_cuentas=[],$total_abonos;

        public $total_nota_credito=0;
        /////

        public $delete_no=null,$delete_nombre=null;


    protected $rules = [
        'venta_id' => 'required',
        'cantidad_credito_actual'=>'required',
        'cantidad_abono'=>'required',
        'saldo_credito'=>'required',
        'fecha_nota_credito'=>'required'
    ];

    protected $listeners=['edit', 'delete','show','pdfExportar'];

    public function render()
    {

/*
        $this->total_nota_creditos = DB::table('nota_creditos')
        ->rightJoin('ventas','nota_creditos.venta_id','=','ventas.id')
        ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
        ->where('nota_creditos.no_nota_credito','LIKE',"%{$this->filtroNoNotaCredito}%")
        ->where('ventas.no_venta','LIKE',"%{$this->filtroNoVenta}%")
        ->where('nota_creditos.fecha_nota_credito','LIKE',"%{$this->filtroFechaNotaCredito}%")
        ->where('clientes.nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('clientes.codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->sum('nota_creditos.total_nota_credito');

*/




        $this->nota_creditos=NotaCredito::with('venta')->with('cliente')
        ->where('no_nota_credito','LIkE',"%{$this->filtroNoNotaCredito}%")
        ->where('fecha_nota_credito','LIkE',"%{$this->filtroFechaNotaCredito}%")
        ->whereRelation('venta','no_venta','LIKE',"%{$this->filtroNoVenta}%")
        ->whereRelation('cliente','codigo_interno','LIKE',"%{$this->filtroCodigoCliente}%")
        ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")

        ->get();

        $this->total_total_nota_credito=NotaCredito::with('venta')->with('cliente')
        ->where('no_nota_credito','LIkE',"%{$this->filtroNoNotaCredito}%")
        ->where('fecha_nota_credito','LIkE',"%{$this->filtroFechaNotaCredito}%")
        ->whereRelation('venta','no_venta','LIKE',"%{$this->filtroNoVenta}%")
        ->whereRelation('cliente','codigo_interno','LIKE',"%{$this->filtroCodigoCliente}%")
        ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->sum('total_nota_credito');



        return view('livewire.pages.nota_credito.index');
    }



    public function create(){
        $this->fecha_nota_credito=Carbon::now()->toDateString();
        $data=NotaCredito::latest()->first();
        if ($data) {
            $this->id=$data->id+1;
            $this->no_nota_credito=$this->id;
        }else{
            $this->id=1;
            $this->no_nota_credito=$this->id;
        }
        $this->isCreate=true;
    }


    public function buscarVenta(){
        $this->isSearchVenta=true;
        $this->isCreate=false;
        }

        public function updatedSearchNoVenta($value){
            $this->reset(['search_nombres_cliente','search_codigo_cliente']);
            $this->ventas=Venta::with('cliente')
            ->where('no_venta','LIKE',"%{$value}%")
            ->get();
        }


        public function updatedSearchNombresCliente($value){
            $this->reset(['search_no_venta','search_codigo_cliente']);


                $this->ventas=Venta::with('cliente')
                ->whereRelation('cliente','nombres_cliente','LIKE',"%{$value}%")
                ->get();


        }

        public function updatedSearchCodigoCliente($value){
            $this->reset(['search_nombres_cliente','search_no_venta']);

            $this->ventas=Venta::with('cliente')
            ->whereRelation('cliente','codigo_interno','LIKE',"%{$value}%")
            ->get();

        }


        public function updatedTotalNotaCredito($value){

            $this->nuevo_saldo=$this->total_venta-$value;
        }




        public function agregarVenta($id)
        {
            $this->cancelarBuscarVenta();
            $venta=Venta::find($id);

            $this->correlativo=$venta->correlativo+1;
            $this->no_venta=$venta->no_venta;

            $this->venta_id=$venta->id;
            $this->fecha_venta=$venta->fecha_venta;

            $this->total_venta=$venta->total_venta-$venta->total_nota_credito;

            $this->codigo_interno=$venta->cliente->codigo_interno;
            $this->nombre_empresa=$venta->cliente->nombre_empresa;
            $this->nombres_cliente=$venta->cliente->nombres_cliente;
            $this->apellidos_cliente=$venta->cliente->apellidos_cliente;

        }
    public function cancelarBuscarVenta(){
        $this->isCreate=true;

        $this->reset(['isSearchVenta','search_no_venta','search_codigo_cliente','search_nombres_cliente','ventas']);
    }



    public function store(){

        $this->validate(['fecha_nota_credito'=>'required','total_nota_credito'=>"numeric|required|min:1|max:$this->total_venta"]);

        $data=Venta::find($this->venta_id);
        if($this->anulacion_venta){


            $da=NotaCredito::create(
                [
                    'no_nota_credito'=>$this->no_nota_credito,
                    'venta_id'=>$this->venta_id,
                    'total_venta'=>$this->total_venta,
                    'fecha_nota_credito'=>$this->fecha_nota_credito,
                    'total_nota_credito'=>$this->total_nota_credito,
                    'cliente_id'=>$data->cliente_id,
                    'total_saldo'=>$this->nuevo_saldo,
                    'correlativo'=>$this->correlativo,
                    'anulacion_venta'=>$this->anulado,
                    'observaciones'=>"Anulacion de la Venta No. $this->venta_id, $this->observaciones",

                ]
            );

            foreach($data->productos as $key => $value){
                $cantidad_antes = DB::table('producto_sucursal')->where('producto_id','=',$value->id)->where('sucursal_id','=',$data->sucursal_id)->get();
                $can=(int)$cantidad_antes[0]->cantidad;
                $can=($can+$value->producto_venta->cantidad);

                DB::table('producto_sucursal')
              ->where('producto_id','=', $value->id,)
              ->where('sucursal_id','=',$data->sucursal_id)
              ->update(['cantidad' => $can]);

            }

            $this->alertaNotificacion("store");

        }else{

                    $da=NotaCredito::create(
                        [
                            'no_nota_credito'=>$this->no_nota_credito,
                            'venta_id'=>$this->venta_id,
                            'total_venta'=>$this->total_venta,
                            'fecha_nota_credito'=>$this->fecha_nota_credito,
                            'total_nota_credito'=>$this->total_nota_credito,
                            'total_saldo'=>$this->nuevo_saldo,
                            'cliente_id'=>$data->cliente_id,
                            'correlativo'=>$this->correlativo,
                            'anulacion_venta'=>$this->anulacion_venta,
                            'observaciones'=>$this->observaciones,

                        ]
                    );

                    $this->alertaNotificacion("store");
    };
    $this->cancel();
}

public function exportarGeneral()
{
    $fecha_reporte=Carbon::now()->toDateTimeString();
    $pdf = Pdf::loadView('/livewire/pdf/pdfNotaCreditoGeneral',['nota_creditos' => $this->nota_creditos,'total_nota_creditos'=>$this->total_nota_creditos]);
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->setPaper('leter', 'landscape')->stream();
        }, "$this->title-$fecha_reporte.pdf");
}



public function exportarFila($id)
{


    $nota_credito=NotaCredito::with('venta')->with('cliente')->find($id);



        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfNotaCredito',['dato'=>$nota_credito]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
}

    public function anulacionVenta(){
        if($this->anulado===true){
            $this->total_nota_credito=$this->total_venta;
            $this->disabled=true;
            $this->anulacion_venta=true;
            }else{
                $this->total_nota_credito=0;
            $this->disabled=false;
            $this->anulacion_venta=false;

            }
        }

    public function delete($id){

        $data = NotaCredito::find($id);

               if($data->anulacion_venta){
                $this->alert('error', 'No es posible borrar nota de credito de anulacion', [
                    'position' => 'center',
                    'timer' => '2000',
                    'toast' => true,
                    'showConfirmButton' => false,
                    'onConfirmed' => '',
                    'timerProgressBar' => true,
                    'text' => 'No es posible borrar una nota de credito de anulacion',
                ]);

               }else{
                $data_venta=Venta::find($data->venta_id);

                if($data->correlativo==$data_venta->correlativo){
                    $this->isDelete = true;
                    $this->delete_no=$data->no_nota_credito;
                    $this->delete_nombre=$data->total_nota_credito;
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
                };

               }



    }

    public function destroy($id)
    {
        $data = NotaCredito::find($id);
        $data_venta = Venta::find($data->venta_id);
        $this->correlativo=$data_venta->correlativo-1;

        $data_venta->update([
            'correlativo'=>$this->correlativo,
            'saldo_venta'=>($data->total_nota_credito+$data->total_saldo),
            'total_nota_credito'=>$data_venta->total_nota_credito-$data->total_nota_credito,
            'fecha_nota_credito'=>null
        ]);


        $data->delete();


        $this->alertaNotificacion("destroy");


        if(DB::table('estado_cuentas')->where('cliente_id',$data->cliente_id)->exists()){
            $estado_cuenta_temp=EstadoCuenta::where('cliente_id',$data->cliente_id)->first();
            $estado_cuenta=DB::table('estado_cuentas')
            ->where('cliente_id','=', $data->cliente_id)
            ->update(['total_abono' => $estado_cuenta_temp->total_abono+$data->total_nota_credito]);
        }else{
            $data=EstadoCuenta::create(
                [
                'cliente_id'=>$data->cliente_id,
                'total_abono'=>$data->total_nota_credito,
                'total_credito'=>0,
                ]
                );


        };


        $this->cancel();

    }



    public function cancel(){
        $this->reset();
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){

        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at','correlativo']);
        $this->reset(['venta_id','cantidad_credito_actual','cantidad_abono','saldo_credito']);


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
