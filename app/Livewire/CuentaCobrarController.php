<?php

namespace App\Livewire;

use App\Models\EstadoCuenta;
use App\Models\Venta;
use Livewire\Component;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\WithPagination;

class CuentaCobrarController extends Component
{
    use LivewireAlert;
    use WithPagination;
    public $title='Estado Cuenta Ventas';
    public $data, $per_page=10,  $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    public $venta_id=null,$cantidad_credito_actual=null,$cantidad_abono=null,$saldo_credito=null,$estado=0;
    public $tipo_pago=[['id'=>'0','nombre'=>'contado'],['id'=>'1','nombre'=>'credito'],['id'=>'2','nombre'=>'abono']];


    public $ventas_credito=null;

    protected $rules = [
        'venta_id' => 'required',
        'cantidad_credito_actual'=>'required',
        'cantidad_abono'=>'required',
        'saldo_credito'=>'required'
    ];

    public function render()
    {
        return view('livewire.pages.cuenta_cobrar.index');
    }

    public function create(){

        $this->ventas_credito=Venta::where('cancelado','0')->get();
        $this->isCreate=true;

    }

    public function updatedVentaId($value){
        $venta=Venta::find($value);
        $this->id_data=$venta->id;

        $this->cantidad_credito_actual=$venta->saldo_venta;


    }

    public function updatedCantidadAbono($value){
        $this->saldo_credito=$this->cantidad_credito_actual-$value;
    }



    public function store(){

    $this->validate();
                    $da=EstadoCuenta::create(
                        [
                            'venta_id'=>$this->id_data,
                            'tipo_transaccion'=>'efectivo',
                            'detalle_transaccion'=>'',
                            'tipo_estado_cuenta'=>$this->tipo_pago[2]['nombre'],
                            'cantidad'=>$this->cantidad_abono,
                            'fecha'=>now()
                        ]
                    );
                    # code...

                    $this->cancel();
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
