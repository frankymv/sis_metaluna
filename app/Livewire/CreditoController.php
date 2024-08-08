<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Ruta;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;


class CreditoController extends Component
{

    public $title='Credito';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $disabled=false;


    public $no_credito=null, $venta_id=null, $fecha_credito=null, $total_credito=null, $cliente_id=null, $observaciones=null, $created_at=null, $updated_at=null;
    public $nombres_cliente=null, $apellidos_cliente=null;
    protected $rules = [
        'codigo' => 'required',
        'tipo_vehiculo' => 'required',
        'tipo_placa' => 'required',
        'numero_placa' => 'required',
        'marca' => 'required',
        'modelo' => 'required',
        'linea' => 'required',
        'alias' => 'required',
    ];





    /////////filtros
    public $filtroNoCredito=null;
    public $filtroNombreCliente=null;
    public $filtroCodigoCliente=null;
    Public $filtroFechaCredito=null;

    public $creditos=[];


    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0;
    public $clientes=[],$estado_cuentas=[],$total_creditos;
    /////
    protected $listeners=['edit', 'delete','show','pdfExportar'];

    public function render()
    {


        $this->creditos = DB::table('creditos')
        ->rightJoin('ventas','creditos.venta_id','=','ventas.id')
        ->rightJoin('clientes','creditos.cliente_id','=','clientes.id')
        ->where('creditos.no_credito','LIKE',"%{$this->filtroNoCredito}%")
        ->where('creditos.fecha_credito','LIKE',"%{$this->filtroFechaCredito}%")
        ->where('clientes.nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('clientes.codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->get();






        $this->total_creditos = DB::table('creditos')
        ->rightJoin('ventas','creditos.venta_id','=','ventas.id')
        ->rightJoin('clientes','creditos.cliente_id','=','clientes.id')
        ->where('creditos.no_credito','LIKE',"%{$this->filtroNoCredito}%")
        ->where('creditos.fecha_credito','LIKE',"%{$this->filtroFechaCredito}%")
        ->where('clientes.nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('clientes.codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->sum('creditos.total_credito');


        return view('livewire.pages.credito.index');
    }


    public function show($rowId){

        $this->isShow=true;
        $data=Credito::find($rowId);

        $this->no_credito=$data->no_credito;
        $this->venta_id=$data->venta_id;
        $this->fecha_credito=$data->fecha_credito;
        $this->total_credito=$data->total_credito;

        $this->cliente_id=$data->cliente_id;
        $this->nombres_cliente=$data->cliente->nombres_cliente;
        $this->apellidos_cliente=$data->cliente->apellidos_cliente;

        $this->observaciones=$data->observaciones;
        $this->created_at=$data->created_at;
        $this->updated_at=$data->updated_at;

        $this->disabled=true;
        $this->isShow=true;
        ////////////////////
    }

    public function cancel(){
        $this->reset();
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','created_at','updated_at']);
        $this->reset(['no_credito','venta_id','fecha_credito','total_credito','cliente_id','nombres_cliente','apellidos_cliente','observaciones','created_at','updated_at']);
    }




    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCreditoGeneral',['creditos' => $this->creditos,'total_creditos'=>$this->total_creditos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {

        $credito=Credito::with('venta')->with('cliente')
        ->where('no_credito',1)->first();

/*
        $this->creditos = DB::table('creditos')
        ->rightJoin('ventas','creditos.venta_id','=','ventas.id')
        ->rightJoin('clientes','creditos.cliente_id','=','clientes.id')
        ->where('creditos.no_credito','LIKE',"%{$this->filtroNoCredito}%")
        ->where('creditos.fecha_credito','LIKE',"%{$this->filtroFechaCredito}%")
        ->where('clientes.nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
        ->where('clientes.codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->get();
*/



        $fecha_reporte=Carbon::now()->toDateTimeString();


        $pdf = Pdf::loadView('/livewire/pdf/pdfCredito ',['dato'=>$credito]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }















}
