<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Abono;
use App\Models\Cliente;
use App\Models\EstadoCuenta;
use App\Models\Ruta;
use App\Models\Venta;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Str;

use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;


class VentaController extends Component
{
    use LivewireAlert;
    use WithPagination;
    use LivewireAlert;

    public $title='Ventas';
    public $data, $per_page=10,  $id_data,$id_last;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false,$isAddProduct=false,$disabled_nombre_producto=false,$disabled_existencia_producto=false,$disabled_codigo_producto=false,$disabled_subtotal_producto=false,$tipo_cliente;
    public $disabledInput=false,$disabledInputPasswordAdmin=false;

    public $fecha_actual_registro;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false,$abono_venta;

    /////////////
    public $codigo='',$proveedores,$productos=[],$nombre,$producto,$producto_id,$cantidad,$no_orden,$fecha,$proveedor_id,$tipo_id=0,$estado=true,$buscar_producto,$buscar_cliente;
    public $productoDetalle,$cantidadDetalle,$tipos,$total_venta;
    public $inputs = [];
    public $detalleCompraMulti=[],$tipo_venta=[['id'=>'0','nombre'=>'Cotizacion'],['id'=>'1','nombre'=>'Efectivo'],['id'=>'2','nombre'=>'Credito'],['id'=>'3','nombre'=>'Efectivo / Credito']];
    public $tipo_pago=[['id'=>'0','nombre'=>'contado'],['id'=>'1','nombre'=>'credito'],['id'=>'2','nombre'=>'abono']];
    public $nombresDetalle= [],$productosDetalle= [], $cantidadesDetalle= [],$subtotalDetalle= [],$clientes=[],$total=0;
    public $i = 0;

    public $no_venta=null;
    public $fecha_venta=null;
    public $cantidad_efectivo=0,$cantidad_credito=0,$cancelado=false,$cliente_id;

    public $id_producto,$codigo_producto,$existencia_producto=1,$nombre_producto='',$precio_venta_producto=0,$cantidad_producto=0,$subtotal_producto=0,$precio_venta_base=0;
    public $disabled_precio_venta_producto=false,$disabled_cantidad_producto=false, $disabledCredito=true;

    public $id_cliente,$id_codigo, $nombre_empresa, $nombres_cliente, $apellidos_cliente, $nit, $descuento=0, $total_descuento=0,$ahorro=0, $direccion_fisica,$direccion_departamento, $direccion_municipio;
    public $usuario_edit,$codigo_edit;
    public $envio=false,$venta=null;



    ///////////filtradooo




    public $filtroNoVenta;
    public $filtroCodigoCliente=NULL;
    public $filtroNombreCliente;

    public $filtroRuta;
    public $filtroFormaPago;
    public $filtroEnvio;
    public $filtroTipoCliente;
    public $filtroRutaCliente=null;

    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas;

    /////////////////////

    public $filtroFecha=null;
    public $filtroFechaInicio=null;
    public $filtroFechaFin=null;


    protected $listeners=['edit', 'delete','showDetalle','pdfExportar','Envio'];

    public function mount()
    {
        $this->filtroFechaInicio=Carbon::now()->format('Y')."-01-01";
        $this->filtroFechaFin=Carbon::now()->toDateString();
    }


    public function updatedFiltroFecha($id){
        if(Str ::length($id)==10){
            $this->filtroFechaInicio=$id;
            $this->filtroFechaFin=$id;
        }else{
            $this->filtroFechaInicio=Str::substr($id, 0, 10);
            $this->filtroFechaFin=Str::substr($id, 13, 25);
        }

    }
    public function borrarFiltros()
    {
        $this->reset();
        $this->mount();
    }

    public function render()
    {

        $this->forma_pagos=DataSistema::$forma_pago;
        $this->envios=DataSistema::$envio;
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        $this->rutas=Ruta::all();

        $data_temp = Venta::with('envios')->with('cliente')
            ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
            ->whereRelation('cliente','codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->where('forma_pago_venta','LIKE',"%{$this->filtroFormaPago}%")
            ->where('envio','LIKE',"%{$this->filtroEnvio}%")
            ->whereRelation('cliente','tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")
            ->latest();

            if(!empty($this->filtroFecha)){
                $data_temp->whereBetween('fecha_venta',[$this->filtroFechaInicio,$this->filtroFechaFin]);
            }



        $data_temp=$data_temp->paginate($this->per_page);




        $this->total_ventas = Venta::with('envios')->with('cliente')
            ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
            ->whereRelation('cliente','codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->where('forma_pago_venta','LIKE',"%{$this->filtroFormaPago}%")
            ->where('envio','LIKE',"%{$this->filtroEnvio}%")
            ->whereRelation('cliente','tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")


            ->sum('total_venta');





        return view('livewire.pages.venta.index', [
            'ventas' => $data_temp,
        ]);



    }



    public function showDetalle($value){
        $this->isShow=true;
        $this->disabledInput=true;
        $this->venta=Venta::where('no_venta',$value['no_venta'])->with('cliente')->with('productos')->with('envios')->first();




        $this->codigo=$this->venta->cliente->codigo;
        $this->nit=$this->venta->cliente->nit;
        $this->nombres_cliente=$this->venta->cliente->nombres_cliente;
        $this->nombre_empresa=$this->venta->cliente->nombre_empresa;
        $this->direccion_fisica=$this->venta->cliente->direccion_fisica;
        $this->direccion_departamento=$this->venta->cliente->direccion_departamento;
        $this->direccion_municipio=$this->venta->cliente->direccion_municipio;
        $this->tipo_cliente=$this->venta->cliente->tipo_cliente;
        $this->no_venta=$this->venta->no_venta;
        $this->fecha_venta=$this->venta->fecha_venta;
        $this->total_venta=$this->venta->total_venta;
        $this->cliente_id=$this->venta->cliente_id;



    }



    public function Envio($id){


        $data=Venta::find($id);

        if($data->envio!="ENVIO"){
            $temp_envio="ENVIO";
            $temp_estado_envio="SIN ASIGNAR";

        }else{
            $temp_envio="SINENVIO";
            $temp_estado_envio="NO APLICA";
        }

        $data->update([

            'envio'=>$temp_envio,
            'estado_envio'=>$temp_estado_envio
        ]);



        $this->alert('success', 'ENVIO', [
            'position' => 'center',
            'timer' => '2000',
            'toast' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
            'timerProgressBar' => true,
            'text' => 'Envio cambiado correctamente',
           ]);


           $this->cancel();


    }


    public function Credito($id){


        $data=Venta::find($id);

        if($data->envio!="ENVIO"){
            $temp_envio="ENVIO";
            $temp_estado_envio="SIN ASIGNAR";

        }else{
            $temp_envio="SINENVIO";
            $temp_estado_envio="NO APLICA";
        }

        $data->update([

            'envio'=>$temp_envio,
            'estado_envio'=>$temp_estado_envio
        ]);



        $this->alert('success', 'ENVIO', [
            'position' => 'center',
            'timer' => '2000',
            'toast' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
            'timerProgressBar' => true,
            'text' => 'Envio cambiado correctamente',
           ]);


           $this->cancel();


    }

    public function exportarGeneral()
    {
        $data_temp = Venta::with('envios')->with('cliente')
        ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
        ->whereRelation('cliente','codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->whereRelation('cliente','nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('forma_pago_venta','LIKE',"%{$this->filtroFormaPago}%")
        ->where('envio','LIKE',"%{$this->filtroEnvio}%")
        ->whereRelation('cliente','tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")
        ->latest();

        if(!empty($this->filtroFecha)){
            $data_temp->whereBetween('fecha_venta',[$this->filtroFechaInicio,$this->filtroFechaFin]);
        }



    $data_temp=$data_temp->paginate($this->per_page);
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfVentaGeneral',['ventas' => $data_temp,'total_ventas'=>$this->total_ventas]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $saldo_actual=0;
        $saldo_anterior=0;


        $venta=Venta::with('productos')->where('id',$id)->get()->first()->toArray();
        $abono=Abono::where('id',$venta['no_venta'])->first()->toArray();

        $no_venta=$venta['no_venta'];
        $cliente=Cliente::find($venta['cliente_id'])->toArray();
        //$user=User::find(1)->toArray();



        if ($venta['forma_pago_venta']==='CREDI') {
            $data=EstadoCuenta::where('cliente_id','=',$venta['cliente_id'])->get();

            $saldo_actual=$saldo_anterior+$venta['total_venta'];
        }else{
            $saldo_anterior=0;
            $saldo_actual=$venta['total_venta'];
        }

        $pdf = Pdf::loadView('/livewire/pdf/pdfVenta',['venta' => $venta,'cliente'=>$cliente,'saldo_actual'=>$saldo_actual,'abono'=>$abono]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','created_at','updated_at']);
        ///////////////////
        $this->reset(['productos','no_orden','fecha','cantidad','estado','nombresDetalle','productosDetalle','cantidadesDetalle','producto','inputs','clientes']);
        ////////////////////
    }


    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }
}

