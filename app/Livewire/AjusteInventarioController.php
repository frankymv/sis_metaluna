<?php

namespace App\Livewire;
use Illuminate\Support\Str;

use App\Constantes\DataSistema;
use App\Models\AjusteInventario;
use App\Models\Producto;
use App\Models\Sucursal;
use App\Models\Traslado;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf ;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\Volt\Compilers\Mount;
use Livewire\WithPagination;

class AjusteInventarioController extends Component
{

    use WithPagination;
    public $title='Ajuste Inventario';
    public $data, $id_data;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false;

    public $sucursales=null,$id=null;



    ////////////////////
    public $ajuste_inventario_no=null;
    public $productos,$producto_id=null, $descripcion=null, $estado=1,$cantidad_traslado=0,$tipo_ajuste=null,$sucursal_id=null;
    public $tipos_ajustes=null;
    ////////////////////


    public $fecha_ajuste_inventario=null;

    ////////////////////

    public $ajustes=null;

    public $estados=null;
    public $filtroNoAjuste=null;

    public $filtroTipoAjuste=null;



    public $fecha_rango=null;

    public $variablePrueba=null;

    public $anio=null;


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
        if(Str::length($id)==10){
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
        $this->tipos_ajustes=DataSistema::$tipo_ajuste_invetario;
        $this->ajustes=AjusteInventario::where('ajuste_inventario_no','LIkE',"%{$this->filtroNoAjuste}%")
        ->where('tipo_ajuste','LIkE',"%{$this->filtroTipoAjuste}%")
        ->whereDate('fecha_ajuste_inventario', '>=', $this->filtroFechaInicio)
        ->whereDate('fecha_ajuste_inventario', '<=', $this->filtroFechaFin)
        ->get();
        return view('livewire.pages.ajuste_inventario.index');
    }





    public function create(){
        $this->tipos_ajustes=DataSistema::$tipo_ajuste_invetario;
        $data=AjusteInventario::latest()->first();

        if ( $data) {
            $this->id=$data->id+1;
            $this->ajuste_inventario_no=$this->id;

        }else{
            $this->id=1;
            $this->ajuste_inventario_no=$this->id;
        }



        $this->productos=Sucursal::find(Auth::user()->sucursal_id);
        $this->isCreate=true;
    }

    public function store(){


        $this->validate([
            'ajuste_inventario_no'=>'required',
            'fecha_ajuste_inventario' => 'required',
            'producto_id' => 'required',
            'tipo_ajuste' => 'required',
            'cantidad_traslado' => 'numeric|required|min:1|max:99999',
            'descripcion' => 'required'
        ]);


        if($this->cantidad_traslado==0 ){
            $this->addError('cantidad_traslado', 'La cantidad debe ser superior a 0');
        }
            AjusteInventario::create(
                [
                'ajuste_inventario_no'=>$this->ajuste_inventario_no,
                'fecha_ajuste_inventario'=>$this->fecha_ajuste_inventario,
                'producto_id'=>$this->producto_id,
                'tipo_ajuste'=>$this->tipo_ajuste,
                'descripcion'=>$this->descripcion,
                'cantidad_traslado'=>$this->cantidad_traslado,
                'sucursal_id'=>Auth::user()->sucursal_id,
                ]
            );

            $pro_sucu=DB::table('producto_sucursal')
            ->where('producto_id' ,'=', $this->producto_id)
            ->where('sucursal_id','=', Auth::user()->sucursal_id)
            ->first();




            if($this->tipo_ajuste=="ingreso"){
                $cant=$this->cantidad_traslado+$pro_sucu->cantidad;
            }else{
                $cant=$pro_sucu->cantidad-$this->cantidad_traslado;
            }

            $pro_sucu=DB::table('producto_sucursal')
            ->where('producto_id' ,'=', $this->producto_id)
            ->where('sucursal_id','=', Auth::user()->sucursal_id)
            ->update(['cantidad' => $cant]);

            $da=DB::table('producto_sucursal')
            ->where('producto_id' ,'=', $this->producto_id)
            ->where('sucursal_id','=', Auth::user()->sucursal_id)
            ->sum('cantidad');


        Producto::find($this->producto_id)
                ->update(['existencia' => $da]);


            $this->cancel();
    }


    public function delete($rowId){
        $data = AjusteInventario::find($rowId);
        $this->ajuste_inventario_no=$data->ajuste_inventario_no;
        $this->id_data=$data->id;
        $this->ajuste_inventario_no = $data->ajuste_inventario_no;
        $this->isDelete = true;
}

public function destroy($rowId)
{
    $data=AjusteInventario::find($rowId);

    $pro_sucu=DB::table('producto_sucursal')
    ->where('producto_id' ,'=', $data->producto_id)
    ->where('sucursal_id','=', $data->sucursal_id)
    ->first();

    if($data->tipo_ajuste=="0"){
        $cant=$pro_sucu->cantidad-$data->cantidad_traslado;
    }else{
        $cant=$pro_sucu->cantidad+$data->cantidad_traslado;
    }

    $pro_sucu=DB::table('producto_sucursal')
    ->where('producto_id' ,'=', $data->producto_id)
    ->where('sucursal_id','=', $data->sucursal_id)
    ->update(['cantidad' => $cant]);



    $da=DB::table('producto_sucursal')
        ->where('producto_id' ,'=', $data->producto_id)
        ->sum('cantidad');


    Producto::find($data->producto_id)
            ->update(['existencia' => $da]);





    $data->delete();


    $this->cancel();

}


public function exportarGeneral()
{
    $fecha_reporte=Carbon::now()->toDateTimeString();
    $pdf = Pdf::loadView('/livewire/pdf/pdfAjusteGeneral',['data' => $this->ajustes]);
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->setPaper('leter', 'landscape')->stream();
        }, "$this->title-$fecha_reporte.pdf");
}

public function exportarFila($id)
{
    $data=AjusteInventario::find($id);
    $fecha_reporte=Carbon::now()->toDateTimeString();
    $pdf = Pdf::loadView('/livewire/pdf/pdfAjuste',['data'=>$data]);
    return response()->streamDownload(function () use ($pdf) {
        echo $pdf->setPaper('leter')->stream();
        }, "$this->title-$fecha_reporte.pdf");
}




    public function cancel(){
        $this->resetInputFields();
        $this->resetValidation();

    }

    private function resetInputFields(){
        $this->reset(['isCreate','isEdit','isShow','isDelete','disabled','estado','created_at','updated_at']);
        ///////////////////
        $this->reset(['producto_id','tipo_ajuste','descripcion','cantidad_traslado']);
        ////////////////////
    }

    public function pdfExportar($id){


        return redirect()->route('pdfExportarAjusteInventario',$id);

    }

    public function pdfExportarAjusteInventario($id)
    {
        $ajuste_inventario=AjusteInventario::find($id)->toArray();
        $producto = Producto::find($ajuste_inventario['producto_id'])->toArray();
        $sucursal = Sucursal::find($ajuste_inventario['sucursal_id'])->toArray();







    //$pdf = Pdf::loadView('pdf.invoice', $data);



        $pdf = Pdf::loadView('/livewire/pdf/pdfAjusteInventario',['ajuste_inventario' => $ajuste_inventario,'producto'=>$producto,'sucursal'=>$sucursal]);

        //$pdf = Pdf::loadView('pdf.invoice', $data);
       // return $pdf->download("venta_$no_venta.pdf");

        //return redirect()->route('pdfVentaRapida',$id);

        //return $pdf->download('venta_pdf.pdf');
        //return $pdf->download("ajuste_inventario.pdf");
            return $pdf->stream();
        //return $pdf->download('itsolutionstuff.pdf');

    }







}
