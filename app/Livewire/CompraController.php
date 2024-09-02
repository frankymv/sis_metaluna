<?php

namespace App\Livewire;
use Illuminate\Support\Str;

use App\Models\Compra;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Sucursal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CompraController extends Component
{
    public $title='Compra';
    public $data, $id_data,$id_last,$id=null;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    /////////////
    public $proveedores=null,$sucursals=null,$productos=null,$nombre=null,$producto=null,$producto_id=null,$sucursal_id=null,$cantidad=null,$compra_no=null,$compra_fecha,$proveedor_id,$estado=true;
    public $productoDetalle,$cantidadDetalle;
    public $inputs = [];
    public $detalleCompraMulti=[];
    public $nombresDetalle= [],$productosDetalle= [], $cantidadesDetalle= [];
    public $i = 0;
    public $no_recibo_compra=null;
    public $disabled_producto=false;
    public $disabled_cantidad=false;

    public $compras=null;
    public $sucursales=null;



    public $filtroNoCompra=null;
    public $filtroReciboCompra=null;
    public $filtroFechaCompra=null;
    public $filtroProveedor=null;
    public $filtroSucursal=null;



    protected $listeners=['edit', 'delete','show','pdfExportar'];



    public $filtroFecha=null;
    public $filtroFechaInicio=null;
    public $filtroFechaFin=null;


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

    public function render()
    {



        $this->proveedores=Proveedor::all();
        $this->sucursales=Sucursal::all();

        $this->compras=Compra::with('productos')->with('sucursal')->with('proveedor')
        ->where('compra_no','LIKE',"%{$this->filtroNoCompra}%")
        ->whereDate('compra_fecha', '>=', $this->filtroFechaInicio)
        ->whereDate('compra_fecha', '<=', $this->filtroFechaFin)
        ->where('no_recibo_compra','LIKE',"%{$this->filtroReciboCompra}%")
        ->where('proveedor_id','LIKE',"%{$this->filtroProveedor}%")
        ->where('sucursal_id','LIKE',"%{$this->filtroSucursal}%")

        ->get();


        return view('livewire.pages.compra.index');
    }


    public function exportarGeneral()
{
    $fecha_reporte=Carbon::now()->toDateTimeString();
    $pdf = Pdf::loadView('/livewire/pdf/pdfCompraGeneral',['data' => $this->compras]);
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->setPaper('leter', 'landscape')->stream();
        }, "$this->title-$fecha_reporte.pdf");
}



public function exportarFila($id)
{


    $data=Compra::with('productos')->with('sucursal')->with('proveedor')->find($id);

        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCompra',['data'=>$data]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter')->stream();
            }, "$this->title-$fecha_reporte.pdf");
}




    public function create(){
        $data=Compra::latest()->first();
        if ( $data) {
            $this->id=$data->id+1;
            $this->compra_no=$this->id;

        }else{
            $this->id=1;
            $this->compra_no=$this->id;
        }

        $this->sucursals=Sucursal::where('bodega','1')->get();
        $this->proveedores=Proveedor::all();
        $this->productos=Producto::all();
        $this->isCreate=true;
    }

    public function addDetalle(){
        $this->disabled_producto=true;
        $this->disabled_cantidad=true;
        $this->validate([
            'cantidad' => 'required'
        ]);

        foreach ($this->productos as $key => $value) {
            if($value['id']===intval($this->producto_id)){

                array_push($this->inputs,$this->i);
                array_push($this->nombresDetalle ,$value['nombre']);
                array_push($this->productosDetalle ,$value['id']);
                array_push($this->cantidadesDetalle ,$this->cantidad);
                $this->i +=1;
            }
        }
        $this->reset(['cantidad','producto_id']);
    }

    public function removeDetalle($i)
    {
        unset($this->inputs[$i]);
        unset($this->nombresDetalle[$i]);
        unset($this->productosDetalle[$i]);
        unset($this->cantidadesDetalle[$i]);
    }





    public function pdfExportar($id){
        return redirect()->route('pdfExportarCompra',$id);
    }

    public function pdfExportarCompra($id)
    {
        $compra=Compra::with('productos')->find($id)->toArray();
        $pdf = Pdf::loadView('/livewire/pdf/pdfCompra ',['compra'=>$compra]);
        return $pdf->stream();

    }






    public function store(){
        $this->validate([
            'no_recibo_compra' => 'required',
            'compra_fecha'=>'required',
            'proveedor_id'=>'required',
            'sucursal_id'=>'required',
            'inputs'=>'required'
        ]);

        $data=Compra::create(
            [
            'compra_no'=>$this->compra_no,
            'no_recibo_compra'=>$this->no_recibo_compra,
            'compra_fecha'=>$this->compra_fecha,
            'sucursal_id'=>$this->sucursal_id,
            'proveedor_id'=>$this->proveedor_id,
            ]
            );


        foreach ($this->productosDetalle as $key => $value) {



            if(DB::table('producto_sucursal')->where('producto_id',$value)->where('sucursal_id',$this->sucursal_id)->exists()){
                $pro_sucu=DB::table('producto_sucursal')
                ->where('producto_id' ,'=', $value)
                ->where('sucursal_id','=', $this->sucursal_id)
                ->first();

                $cant=$this->cantidadesDetalle[$key]+$pro_sucu->cantidad;
                $pro_sucu=DB::table('producto_sucursal')
                ->where('producto_id' ,'=', $value)
                ->where('sucursal_id','=', $this->sucursal_id)
                ->update(['cantidad' => $cant]);

                $pro=Producto::find($value);
                $exit=$this->cantidadesDetalle[$key]+$pro->existencia;
                Producto::find($value)
                    ->update(['existencia' => $exit]);

            }else{

                DB::table('producto_sucursal')->insert([
                    'producto_id' => $value,
                    'sucursal_id' => $this->sucursal_id,
                    'cantidad' =>$this->cantidadesDetalle[$key]
                ]);

                $temp_pro=Producto::find($value);
                $exit=$this->cantidadesDetalle[$key]+$temp_pro->existencia;

                Producto::find($value)
                    ->update(['existencia' => $exit]);
            }

            $data->productos()->attach($value,['cantidad' => $this->cantidadesDetalle[$key]]);

        }
        $this->cancel();


    }


    public function edit($id){
        $this->proveedores=Proveedor::all();
        $this->productos=Producto::all();
        $this->sucursals=Sucursal::where('bodega','1')->get();
        $data = Compra::find($id);

        $this->compra_no=$data->compra_no;
        $this->compra_fecha=$data->compra_fecha;
        $this->proveedor_id=$data->proveedor_id;
        $datos=$data->productos()->get();

        foreach ($datos as $key => $value) {
            array_push($this->inputs ,$key);
            array_push($this->nombresDetalle ,$value->nombre);
            array_push($this->productosDetalle ,$value->id);
            array_push($this->cantidadesDetalle ,$value->pivot->cantidad);
        }
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->isEdit=true;
    }

    public function show($id){
        $this->sucursals=Sucursal::where('bodega','1')->get();
        $this->proveedores=Proveedor::all();
        $this->productos=Producto::all();
        $data = Compra::find($id);

        $this->no_recibo_compra=$data->no_recibo_compra;

        $this->compra_no=$data->compra_no;
        $this->compra_fecha=$data->compra_fecha;
        $this->proveedor_id=$data->proveedor_id;
        $datos=$data->productos()->get();

        foreach ($datos as $key => $value) {
            array_push($this->inputs ,$key);
            array_push($this->nombresDetalle ,$value->nombre);
            array_push($this->productosDetalle ,$value->id);
            array_push($this->cantidadesDetalle ,$value->pivot->cantidad);
        }
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
        ////////////////////
            }

    public function delete($id){
            $data = Compra::find($id);
            $this->compra_no=$data->compra_no;
            $this->id_data=$data->id;
            $this->compra_no = $data->compra_no;
            $this->isDelete = true;
    }

    public function destroy($id)
    {
        $data=Compra::find($id);
        $datos=$data->productos()->get();
        foreach ($datos as $key => $value) {
            array_push($this->inputs ,$key);
            array_push($this->nombresDetalle ,$value->nombre);
            array_push($this->productosDetalle ,$value->id);
            array_push($this->cantidadesDetalle ,$value->pivot->cantidad);
        }

        foreach ($this->productosDetalle as $key => $value) {

            if(DB::table('producto_sucursal')->where('producto_id',$value)->where('sucursal_id',$data->sucursal_id)->exists()){
                $pro_sucu=DB::table('producto_sucursal')
                ->where('producto_id' ,'=', $value)
                ->where('sucursal_id','=', $data->sucursal_id)
                ->first();

                $cant=$pro_sucu->cantidad-$this->cantidadesDetalle[$key];
                $pro_sucu=DB::table('producto_sucursal')
                ->where('producto_id' ,'=', $value)
                ->where('sucursal_id','=', $data->sucursal_id)
                ->update(['cantidad' => $cant]);

                /*$pro=Producto::find($value);
                $exit=$pro->existencia-$this->cantidadesDetalle[$key];
                Producto::find($value)
                    ->update(['existencia' => $exit]);
                */

                $da=DB::table('producto_sucursal')
                    ->where('producto_id' ,'=', $value)
                    ->sum('cantidad');


                Producto::find($value)
                        ->update(['existencia' => $da]);

            };

            $data->productos()->detach($value,['cantidad' => $this->cantidadesDetalle[$key]]);

        }

        $data->delete();


        $this->cancel();

    }




    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();
    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','created_at','updated_at']);
        ///////////////////
        $this->reset(['compra_fecha','cantidad','estado','nombresDetalle','productosDetalle','cantidadesDetalle','producto','inputs','i','id','no_recibo_compra','proveedor_id','sucursal_id']);
        ////////////////////
    }

}
