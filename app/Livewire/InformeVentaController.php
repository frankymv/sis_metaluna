<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Ruta;
use App\Models\Venta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class InformeVentaController extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $title='Informe Venta';
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


    protected $listeners=['edit', 'delete','show'];

    public function render()
    {

        $this->forma_pagos=DataSistema::$forma_pago;
        $this->envios=DataSistema::$envio;
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        $this->rutas=Ruta::all();

        $this->ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->leftJoin('rutas','clientes.ruta_id','=','rutas.id')
            ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
            ->where('nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->where('codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->where('fecha_venta','LIKE',"%{$this->filtroFechaVenta}%")
            ->where('forma_pago','LIKE',"%{$this->filtroFormaPago}%")
            ->where('envio','LIKE',"%{$this->filtroEnvio}%")
            ->where('tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")
            ->where('ruta_id','LIKE',"%{$this->filtroRutaCliente}%")
            ->get();

        $this->total_ventas = DB::table('ventas')
            ->rightJoin('clientes','ventas.cliente_id','=','clientes.id')
            ->leftJoin('rutas','clientes.ruta_id','=','rutas.id')
            ->where('codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
            ->where('no_venta','LIKE',"%{$this->filtroNoVenta}%")
            ->where('nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")
            ->where('fecha_venta','LIKE',"%{$this->filtroFechaVenta}%")
            ->where('forma_pago','LIKE',"%{$this->filtroFormaPago}%")
            ->where('envio','LIKE',"%{$this->filtroEnvio}%")
            ->where('tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")
            ->where('ruta_id','LIKE',"%{$this->filtroRutaCliente}%")

            ->sum('total_venta');


        return view('livewire.pages.informe.index_venta');
    }
}
