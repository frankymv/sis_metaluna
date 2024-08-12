<?php

namespace App\Livewire;

use App\Models\Abono;
use App\Models\Cliente;
use App\Models\EstadoCuenta;
use App\Models\NotaCredito;
use App\Models\Venta;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EstadoCuentaVentaController extends Component
{
    public $title='Estado Cuenta Venta';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    public $venta_id=null,$cantidad_credito_actual=null,$cantidad_abono=null,$saldo_credito=null,$estado=0;
    public $tipo_pago=[['id'=>'0','nombre'=>'contado'],['id'=>'1','nombre'=>'credito'],['id'=>'2','nombre'=>'abono']];


    public $ventas_credito=null;
    protected $listeners=['edit', 'delete','showDetalle','pdfExportar'];

    protected $rules = [
        'venta_id' => 'required',
        'cantidad_credito_actual'=>'required',
        'cantidad_abono'=>'required',
        'saldo_credito'=>'required'
    ];



    public $ventas=[];



    public $filtroNoVenta;
    public $filtroCodigoCliente=NULL;
    public $filtroNombreCliente;
    public $filtroFechaVenta;
    public $filtroRuta;
    public $filtroFormaPago;
    public $filtroEnvio;
    public $filtroTipoCliente;
    public $filtroRutaCliente=null;

    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0;

    /////////////////////

    public function render()
    {

/*        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->leftJoin('rutas','clientes.ruta_id','=','rutas.id')
            ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
            ->where('nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->where('codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->where('fecha_venta','LIKE',"%{$this->filtroFechaVenta}%")
            ->where('forma_pago','LIKE',"%{$this->filtroFormaPago}%")

            ->get();
            */



            $this->ventas=Venta::with('productos')
            ->with('creditos')
            ->with('abonos')
            ->with('notacreditos')
            ->with('cliente')
            ->where('no_venta','LIkE',"%{$this->filtroNoVenta}%")
            ->where('fecha_venta','LIkE',"%{$this->filtroFechaVenta}%")
            ->whereRelation('cliente','nombres_cliente','LIkE',"%{$this->filtroNombreCliente}%")
            ->whereRelation('cliente','codigo_interno','LIkE',"%{$this->filtroCodigoCliente}%")->get();



        //dd($this->ventas[0]->cliente->nombres_cliente);


        return view('livewire.pages.estado_cuenta_venta.index');
    }



    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfEstadoCuentaVentaGeneral',['ventas' => $this->ventas,'total_ventas'=>$this->total_ventas]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }



    public function exportarFila($id)
    {



        $correl=0;

        $saldo_actual=0;
        $saldo_anterior=0;

        $venta=Venta::with('productos')->find($id)->toArray();
        $correl=$venta['correlativo'];

        $abono=Abono::where('venta_id','=',$id)->get()->toArray();

        $nota_credito=NotaCredito::where('venta_id','=',$id)->get()->toArray();


        $no_venta=$venta['no_venta'];


        $cliente=Cliente::find($venta['cliente_id'])->toArray();

        //$user=User::find(1)->toArray();
        $saldo_anterior=$venta['saldo_credito_cliente'];

        if ($venta['forma_pago']==='CREDI') {
            $data=EstadoCuenta::where('cliente_id','=',$venta['cliente_id'])->get();

            $saldo_actual=$saldo_anterior+$venta['total_venta'];
        }else{
            $saldo_anterior=0;
            $saldo_actual=$venta['total_venta'];
        }

        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfEstadoCuentaVenta',['venta' => $venta,'cliente'=>$cliente,'saldo_anterior'=>$saldo_anterior,'saldo_actual'=>$saldo_actual,'venta' => $venta,'cliente'=>$cliente,'abono'=>$abono,'nota_credito'=>$nota_credito,'correl'=>$correl]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
        return $pdf->download("estado_cuenta_venta_$no_venta.pdf");
    }



    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){

        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        $this->reset(['venta_id','cantidad_credito_actual','cantidad_abono','saldo_credito']);


    }
}
