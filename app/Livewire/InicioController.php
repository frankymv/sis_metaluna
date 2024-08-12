<?php

namespace App\Livewire;

use App\Models\Cliente;
use App\Models\Credito;
use App\Models\Envio;
use App\Models\EstadoCuenta;
use App\Models\Producto;
use App\Models\Venta;
use Carbon\Carbon;
use Livewire\Component;

class InicioController extends Component
{
    public $clientes = 0,$clientes_credito=0, $creditos=0,$creditos_cantidad=0, $ventas_del_dia=0, $productos_baja_existencia_canitdad=0,$ventas=0, $productos=0,$productos_baja_existencia=0, $venta_reciente=0,$credito_dia=0,$importe_venta_dia=0,$ventas_dia=0,$ventas_actuales=0;
    public $envios_pendiente_finalizar=0,$envios=[];
    public function render()
    {
        $this->envios_pendiente_finalizar=Envio::where('finalizado',false)->count();

        $this->envios=Envio::where('finalizado',false)->get();
        $this->clientes=Cliente::all()->count();
        $this->ventas=Venta::all()->count();
        $this->productos=Producto::all()->count();
        $this->productos_baja_existencia=Producto::where('existencia','<','100')->get();
        $this->productos_baja_existencia_canitdad=Producto::where('existencia','<','100')->count();





        $this->creditos=Credito::orderBy('fecha_credito', 'ASC')->get();
        $this->creditos_cantidad=Credito::all()->count();

        $this->ventas_del_dia=Venta::where('fecha_venta',Carbon::now()->toDateString())->count();


        $this->venta_reciente=Venta::orderBy('fecha_venta', 'DESC')->get();


        $this->ventas_actuales=Venta::where('fecha_venta',Carbon::now())->count();

        $this->importe_venta_dia=Venta::all()->sum('total_venta');

        $this->credito_dia=Venta::all()->sum('saldo_venta');


        return view('livewire.pages.inicio.index');
    }
}
