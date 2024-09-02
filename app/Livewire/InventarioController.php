<?php

namespace App\Livewire;
use Illuminate\Support\Str;

use App\Models\Disenio;
use App\Models\Marca;
use App\Models\Material;
use App\Models\Producto;
use App\Models\Tipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Component;

use Carbon\Carbon;

class InventarioController extends Component
{
    //


    public $existencia, $estado=1,$created_at,$updated_at, $producto_id;

    //
    public $title='Inventario';
    public $data, $id_data;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $isDelete = false;


    public $dataa;

    public $productos=[];
    public $marcas=[];
    public $tipos=[];

    public $materiales=[];
    public $disenios=[];
    public $producto_sucursal=[];

    public $sucursal_asignada;


    /////////filtros
    public $filtroCodigoProducto=null;
    public $filtroNombreProducto=null;
    public $filtroTipo=null;
    Public $filtroMarca=null;
    Public $filtroDisenio=null;
    Public $filtroMaterial=null;



    protected $rules = [
        'nombre' => 'required',
    ];

    protected $listeners=['edit', 'delete','show','pdfExportar'];




    public function render()
    {

        $this->tipos=Tipo::all();
        $this->marcas=Marca::all();
        $this->disenios=Disenio::all();
        $this->materiales=Material::all();

        $this->productos=Producto::with('marca')->with('material')->with('tipo')->with('disenio')->with('sucursales')
        ->where('codigo','LIKE',"%{$this->filtroCodigoProducto}%")
        ->where('nombre','LIKE',"%{$this->filtroNombreProducto}%")
        ->whereRelation('marca','id','LIKE',"%{$this->filtroMarca}%")
        ->whereRelation('tipo','id','LIKE',"%{$this->filtroTipo}%")
        ->whereRelation('disenio','id','LIKE',"%{$this->filtroDisenio}%")
        ->whereRelation('material','id','LIKE',"%{$this->filtroMaterial}%")
        ->get();

        return view('livewire.pages.inventario.index');

    }


    public function borrarFiltros()
    {
        $this->reset();
    }




    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfInventarioGeneral',['productos'=>$this->productos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {

        $dato=Producto::find($id)->with('marca')->with('material')->with('tipo')->with('disenio')->with('sucursales')->first();

            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfInventario',['dato' => $dato]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
       // }
    }






}
