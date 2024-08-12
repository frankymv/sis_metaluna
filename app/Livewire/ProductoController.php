<?php

namespace App\Livewire;

use App\Constantes\UnidadMedida;
use App\Models\Disenio;
use App\Models\Marca;
use App\Models\Material;
use App\Models\Producto;
use App\Models\Tipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProductoController extends Component
{
    use LivewireAlert;
    //
    public $codigo='', $precio_venta_mayorista=0,$precio_venta_minorista=0,$precio_venta_producto=0, $nombre='', $descripcion='', $disabled=false,$disabledButton=false,$calibre=null,   $divisible=false, $marca_id, $tipo_id, $material_id, $disenio_id,  $estado=true,$created_at,$updated_at;
    public $disabledCodigo=false, $disabledNombre=false,$disabledTipo=false, $disabledGenerar=false;
    public $disabledDisenio=false,$disabledMarca=false, $disabledMaterial=false, $disabledLongitud=false, $disabledPeso=false, $disabledDiametro=false;

    public $longitudes=null;
    public $pesos=null;
    public $diametros=null;

    public $longitud=null;
    public $tipo_longitud=null;
    public $peso=null;
    public $tipo_peso=null;
    public $diametro=null;
    public $tipo_diametro=null;

    public $productos=[];

    public $marcas, $tipos, $materiales, $disenios;
    //
    public $title='Producto';
    public $data=null, $id_data=null, $id_last=null;
    public $isCreate = false;
    public $isEdit = false;
    public $isShow = false;
    public $isDelete = false;

    public $delete_no=null, $delete_nombre=null;

    protected $rules = [
        'codigo'=>'required',
        'precio_venta_producto'=>'required',
        'precio_venta_mayorista'=>'required',
        'precio_venta_minorista'=>'required',
        'nombre'=>'required',
        'tipo_id'=>'required'
    ];

    protected $listeners=['edit', 'delete','show'];

    /////////filtros
    public $filtroCodigoProducto=null;
    public $filtroNombreProducto=null;
    public $filtroTipo=null;
    Public $filtroMarca=null;
    Public $filtroDisenio=null;
    Public $filtroMaterial=null;

    public function render()
    {

        $this->tipos=Tipo::all();
        $this->marcas=Marca::all();
        $this->disenios=Disenio::all();
        $this->materiales=Material::all();

        //$this->productos=Sucursal::with('productos')->find(2);
        $this->productos=Producto::with('marca')->with('material')->with('tipo')->with('disenio')->with('sucursales')
        ->where('codigo','LIKE',"%{$this->filtroCodigoProducto}%")
        ->where('nombre','LIKE',"%{$this->filtroNombreProducto}%")
        ->whereRelation('marca','id','LIKE',"%{$this->filtroMarca}%")
        ->whereRelation('tipo','id','LIKE',"%{$this->filtroTipo}%")
        ->whereRelation('disenio','id','LIKE',"%{$this->filtroDisenio}%")
        ->whereRelation('material','id','LIKE',"%{$this->filtroMaterial}%")
        ->get();


        return view('livewire.pages.producto.index');
    }

    public function create(){

        $this->longitudes=UnidadMedida::$longitud;
        $this->pesos=UnidadMedida::$peso;
        $this->diametros=UnidadMedida::$diametro;
        $this->marcas=Marca::where('estado',1)->get();
        $this->tipos=Tipo::where('estado',1)->get();
        $this->materiales=Material::where('estado',1)->get();
        $this->disenios=Disenio::where('estado',1)->get();

        $this->isCreate=true;
    }

    public function store(){
        $this->validate();
        Producto::create(
            [
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'calibre'=>$this->calibre,
            'longitud'=>$this->longitud,
            'tipo_longitud'=>$this->tipo_longitud,
            'diametro'=>$this->diametro,
            'tipo_diametro'=>$this->tipo_diametro,
            'peso'=>$this->peso,
            'tipo_peso'=>$this->tipo_peso,
            'divisible'=>$this->divisible,
            'estado'=>$this->estado,
            'marca_id'=>$this->marca_id,
            'tipo_id'=>$this->tipo_id,
            'material_id'=>$this->material_id,
            'disenio_id'=>$this->disenio_id,
            'precio_venta_producto'=>$this->precio_venta_producto,
            'estado'=>$this->estado
            ]
        );
        $this->alertaNotificacion("store");
        $this->cancel();

    }

    public function edit($rowId){
        $this->longitudes=UnidadMedida::$longitud;
        $this->pesos=UnidadMedida::$peso;
        $this->diametros=UnidadMedida::$diametro;
        $this->marcas=Marca::all();
        $this->tipos=Tipo::where('estado',1)->get();
        $this->materiales=Material::where('estado',1)->get();
        $this->disenios=Disenio::where('estado',1)->get();

        $data = Producto::find($rowId);
        $this->disabled=true;
        $this->disabledButton=true;
        $this->disabledCodigo=true;
        $this->disabledNombre=true;
        $this->disabledTipo=true;
        $this->disabledDisenio=false;
        $this->disabledMarca=false;
        $this->disabledMaterial=false;
        $this->disabledLongitud=false;
        $this->disabledPeso=false;
        $this->disabledDiametro=false;

        $this->id_data=$data->id;
        $this->codigo=$data->codigo;
        $this->nombre=$data->nombre;
        $this->descripcion=$data->descripcion;
        $this->calibre=$data->calibre;

        $this->longitud=$data->longitud;
        $this->tipo_longitud=$data->tipo_longitud;

        $this->diametro=$data->diametro;
        $this->tipo_diametro=$data->tipo_diametro;

        $this->peso=$data->peso;
        $this->tipo_peso=$data->tipo_peso;
        $this->peso=$data->peso;
        $this->longitud=$data->longitud;
        $this->divisible=$data->divisible;
        $this->estado=$data->estado;
        $this->marca_id=$data->marca_id;
        $this->tipo_id=$data->tipo_id;
        $this->material_id=$data->material_id;
        $this->disenio_id=$data->disenio_id;
        $this->precio_venta_producto=$data->precio_venta_producto;
        $this->estado=$data->estado;

        $this->isEdit=true;
    }

    public function show($rowId){
        $this->marcas=Marca::where('estado',1)->get();
        $this->tipos=Tipo::where('estado',1)->get();
        $this->materiales=Material::where('estado',1)->get();
        $this->disenios=Disenio::where('estado',1)->get();
        $data = Producto::find($rowId);

        $this->id_data=$data->id;
        $this->codigo = $data->codigo;
        $this->nombre = $data->nombre;
        $this->estado = $data->estado;
        $this->descripcion=$data->descripcion;
        $this->calibre=$data->calibre;

        $this->longitud=$data->longitud;
        $this->tipo_longitud=$data->tipo_longitud;

        $this->diametro=$data->diametro;
        $this->tipo_diametro=$data->tipo_diametro;

        $this->peso=$data->peso;
        $this->tipo_peso=$data->tipo_peso;

        $this->precio_venta_producto=$data->precio_venta_producto;
        $this->created_at = $data->created_at;
        $this->updated_at = $data->updated_at;
        $this->disabled=true;
        $this->isShow=true;
    }

    public function update($rowId){

        $data = Producto::find($rowId);
        $data->update([
            'codigo'=>$this->codigo,
            'nombre'=>$this->nombre,
            'descripcion'=>$this->descripcion,
            'calibre'=>$this->calibre,
            'longitud'=>$this->longitud,
            'tipo_longitud'=>$this->tipo_longitud,
            'diametro'=>$this->diametro,
            'tipo_diametro'=>$this->tipo_diametro,
            'peso'=>$this->peso,
            'tipo_peso'=>$this->tipo_peso,
            'divisible'=>$this->divisible,
            'estado'=>$this->estado,
            'marca_id'=>$this->marca_id,
            'tipo_id'=>$this->tipo_id,
            'material_id'=>$this->material_id,
            'disenio_id'=>$this->disenio_id,
            'precio_venta_producto'=>$this->precio_venta_producto,
            'estado'=>$this->estado
        ]);

        $this->alertaNotificacion("update");




        $this->cancel();

    }

    public function delete($id){
        $data = Producto::find($id);
        $this->id_data=$data->id;
        $this->delete_no=$data->codigo;
        $this->delete_nombre=$data->nombre;
        $this->isDelete = true;
    }



    public function destroy($rowId){
        $data=Producto::find($rowId);
        $mensaje='Registro borrado exitosamente';

        try {
            $data->delete();

            $this->alertaNotificacion("destroy");

        } catch (Exception $e) {


            if($e->getCode()=="23000"){
                $mensaje="El registro esta asociado a otro registro";
            }

            $this->alert('error', 'No es posible borrar', [
                'position' => 'center',
                'timer' => '3000',
                'toast' => true,
                'showConfirmButton' => false,
                'onConfirmed' => '',
                'timerProgressBar' => true,
                'text' => $mensaje,
            ]);
        }






        $this->isDelete = false;
        $this->cancel();






    }

    public function generar(){
        $marcas='';
        $tipos='';
        $materiales='';
        $disenios='';
        $temp_calibre='';
        $temp_diametro='';
        $temp_peso='';
        $temp_longitud='';

        $this->validate([
            'tipo_id' => 'required'
        ]);

        if ($this->tipo_id!=null) {
            $tempA=Tipo::find($this->tipo_id);
            $tipos=$tempA->nombre.' ';
        }
        if ($this->marca_id!=null) {
            $marcas=Marca::find($this->marca_id);
            $marcas=$marcas->nombre.' ';
        }
        if ($this->material_id!=null) {
            $materiales=Material::find($this->material_id);
            $materiales=$materiales->nombre.' ';
        }
        if ($this->disenio_id!=null) {
            $disenios=Disenio::find($this->disenio_id);
            $disenios=$disenios->nombre.' ';
        }
        if ($this->calibre!=null) {
            $temp_calibre='Calibre:'.$this->calibre.' ';
        }

        if ($this->longitud!=null) {
            $this->validate([
                'longitud' => 'required',
                'tipo_longitud' => 'required',
            ]);
            $temp_longitud.='Longitud:'.$this->longitud.' '.$this->longitudes[$this->tipo_longitud];
        }

        if ($this->peso!=null) {
            $this->validate([
                'peso' => 'required',
                'tipo_peso' => 'required',
            ]);
            $temp_peso.='Peso: '.$this->peso.' '.$this->pesos[$this->tipo_peso];
        }

        if ($this->diametro!=null) {



            $this->validate([
                'diametro' => 'required',
                'tipo_diametro' => 'required',
            ]);
            $temp_diametro.='Diametro: '.$this->diametro.' '.$this->diametros[$this->tipo_diametro];
        }







        $this->id_last=Producto::latest('id')->first();
        if ( $this->id_last===null) {
            $this->id_last=0;
        }else{
            $datas=Producto::latest('id')->first();
            $this->id_last=$datas->id;
        }
        $this->nombre=$tempA->nombre;
        $tempB=$this->id_last;
        $this->codigo=substr($tempA->nombre,0,3).$tempB;

       $this->nombre=$tipos.''.$materiales.''.$marcas.''.$disenios.''.$temp_calibre.''. $temp_longitud.''. $temp_peso.''. $temp_diametro;

    }

    public function exportarGeneral()
    {
        $fecha_reporte=Carbon::now()->toDateTimeString();
        $pdf = Pdf::loadView('/livewire/pdf/pdfProductoGeneral',['productos'=>$this->productos]);
        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->setPaper('leter', 'landscape')->stream();
            }, "$this->title-$fecha_reporte.pdf");
    }

    public function exportarFila($id)
    {

        $dato=Producto::find($id)->with('marca')->with('material')->with('tipo')->with('disenio')->with('sucursales')->first();

            $fecha_reporte=Carbon::now()->toDateTimeString();
            $pdf = Pdf::loadView('/livewire/pdf/pdfProducto',['dato' => $dato]);
            return response()->streamDownload(function () use ($pdf) {
                echo $pdf->setPaper('leter')->stream();
                }, "$this->title-$fecha_reporte.pdf");
       // }
    }


    public function cancel(){
        $this->reset();
        $this->resetInputFields();
        $this->resetValidation();
    }

    public function resetInput(){
        $this->reset(['codigo','id_last','nombre','marca_id','tipo_id','material_id','disenio_id','calibre','peso','longitud','precio_venta_producto']);

        $this->reset([

            'longitud',
            'tipo_longitud',
            'diametro',
            'tipo_diametro',
            'peso',
            'tipo_peso',

        ]);

    }

    private function resetInputFields(){

        $this->reset();
        //$this->reset(['isCreate','isEdit','isDelete','isShow','codigo','id_last','nombre', 'descripcion','estado','calibre','peso','longitud','divisible','marca_id','tipo_id','material_id','disenio_id','estado','created_at','updated_at']);
    }


    public function divisibleToggle(){
        if($this->divisible==1)
        {
            $this->divisible=0;
        }else{
            $this->divisible=1;
        }
    }

    public function alertaNotificacion($tipo){
        $alerta="";
        $title="";
        $texto="";
        if($tipo==="store"){

            $title="Agregar";
            $texto="Registro agregado";
            $alerta="success";

        }elseif($tipo==="update"){
            $title="Editar";
            $texto="Registro editado";
            $alerta="success";

        }elseif($tipo==="destroy"){
            $title="Borrar";
            $texto="Registro borrado";
            $alerta="success";
        }elseif($tipo==="error"){
            $title="Error";
            $texto="No se completo la operación";
            $alerta="error";
        }
        return $this->alert("$alerta", "$title", [
            'position' => 'center',
            'timer' => '2000',
            'toast' => true,
            'showConfirmButton' => false,
            'onConfirmed' => '',
            'timerProgressBar' => true,
            'text' => "$texto"
        ]);
    }

}
