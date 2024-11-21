<?php

namespace App\Livewire;

use App\Constantes\DataSistema;
use App\Models\Cliente;
use App\Models\Ruta;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class InformeEstadoCuentaController extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $title='Estado Cuenta';
    public $ventas=[];



    public $filtroCodigoCliente=NULL;
    public $filtroNombreCliente;
    public $filtroClientes;
    public $filtroTipoCliente;
    public $filtroRutaCliente=null;

    public $forma_pagos,$envios,$tipo_clientes,$rutas,$total_ventas=0;
    public $clientes=[],$estado_cuentas=[];


    protected $listeners=['edit', 'delete','show'];

    public function render()
    {

        $this->forma_pagos=DataSistema::$forma_pago;
        $this->clientes=Cliente::all();
        $this->envios=DataSistema::$envio;
        $this->tipo_clientes=DataSistema::$tipo_cliente;
        $this->rutas=Ruta::all();

        $this->estado_cuentas = DB::table('estado_cuentas')
        ->rightJoin('clientes','estado_cuentas.cliente_id','=','clientes.id')
        ->leftJoin('rutas','clientes.ruta_id','=','rutas.id')
        ->where('codigo_interno','LIKE',"%{$this->filtroClientes}%")
        ->where('codigo_mayorista','LIKE',"%{$this->filtroCodigoCliente}%")
        ->where('nombres_cliente','LIKE',"%{$this->filtroNombreCliente}%")

        ->where('tipo_cliente','LIKE',"%{$this->filtroTipoCliente}%")
        ->where('ruta_id','LIKE',"%{$this->filtroRutaCliente}%")
            ->get();








        return view('livewire.pages.informe.index_estado_cuenta');
    }
}
