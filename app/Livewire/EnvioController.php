<?php

namespace App\Livewire;

use App\Models\Envio;
use App\Models\Ruta;
use App\Models\User;
use App\Models\Vehiculo;
use App\Models\Venta;
use Barryvdh\DomPDF\Facade\Pdf as FacadePdf;

use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EnvioController extends Component
{
    use LivewireAlert;
    public $title='Envio';
    public $data, $id_data,$id_last;
    public $isCreate = false,$isEdit = false, $isShow = false, $isDelete = false,$isFinalizar=false;
    public $estadoShow,$estadoFalse="Inactivo",$estadoTrue="Habilitado";
    public $created_at,$updated_at,$disabled=false,$disabled_observaciones_inicio_envio=false,$disabled_observaciones_final_envio=false;
    public $rutas=[], $municipios=[],$ventas=null,$vehiculos=null,$ventass=[];
    ////////////////


    public $i = 0;
    public $j = 0;
    public $k = 0;


    public $fecha;


    public $usuarios=[];


    public $envio_id=null;

    public $venta_id=null;
    public $inputsVenta=[];
    public $ventaContador=null;

    public $ventaDetalle=[];
    public $idDetalleVenta=[];
    public $noVenta=[];

    public $totalVenta=[];
    public $nombreCliente=[];

    public $user_id=null;
    public $inputsUsuario=[];
    public $usuarioContador=null;
    public $usuarioDetalle=[];
    public $idDetalleUsuario=[];


    public $vehiculo_id=null;
    public $inputsVehiculo=[];
    public $vehiculoDetalle=[];
    public $aliasVehiculo=[];
    public $vehiculoContador=null;
    public $idDetalleVehiculo=[];
    public $codigoVehiculo=[];

    public $estados,$procesos;

    public $observaciones_inicio_envio=null, $observaciones_final_envio=null,$estado='Iniciado';
    public $envios,$envio=null;


    public $envio_no=null;
    public $envio_fecha=null;

    public $ruta_id=null;
    public $id=0;

    public $proceso_id=null;
    public $proceso_nombre=null;

    public $estado_id=null;
    public $estado_nombre=null;
    public $estado_fecha=null;
    public $estado_observacion=null;

    public $user_id_created_at=null;
    public $user_name_created_at=null;

    public $visible=false;
    public $finalizado=false;

    public $disabled_envio_no=true;

public $disabled_venta=true,$disabled_user=true,$disabled_vehiculo=true;
public $diabled_proceso_id=false,$disabled_estado_id=false,$disabled_estado_obserbacion=false,$disabled_estado_fecha=false;

//////////////delete/////////
public $delete_no=null,$delete_nombre=null;


    protected $listeners=['edit', 'delete','show','finalizar','pdfExportar'];

    public function render()
    {
        $this->envios=Envio::all();
        return view('livewire.pages.envio.index');
    }

    public function create(){
        $this->diabled_proceso_id=true;
        $this->disabled_estado_id=false;
        $this->disabled_estado_obserbacion=false;
        $this->disabled_estado_fecha=true;

        $this->proceso_id=1;
        $this->estado_id=3;

        $data=Envio::latest()->first();


        if ( $data) {
            $this->id=$data->id+1;
            $this->envio_no=$this->id;
        }else{
            $this->id=1;
            $this->envio_no=$this->id;
        }

        $this->usuarios=User::all();
        $this->ventas=Venta::where('envio','=','ENVIO')->where('estado_envio','=','SIN ASIGNAR')->get();
        $this->rutas=Ruta::all();
        $this->vehiculos=Vehiculo::all();
        $this->isCreate=true;
    }



    public function borrador (){
        $this->proceso_id=1;
        $this->estado_id=3;
        $this->store();
    }

    public function addDetalleVenta(){

        foreach ($this->ventas as $key => $value) {
            if($value['id']===intval($this->venta_id)){
                array_push($this->inputsVenta,$this->i);
                array_push($this->noVenta,$value['no_venta']);
                array_push($this->totalVenta,$value['total_venta']);
                array_push($this->nombreCliente,$value->cliente['nombres_cliente']);
                array_push($this->idDetalleVenta,$value['id']);
                $this->i++;
            }
        }
        $this->reset(['venta_id','user_id','vehiculo_id']);
    }


    public function addDetalleUsuario(){
        foreach ($this->usuarios as $key => $value) {
            if($value['id']===intval($this->user_id)){
                array_push($this->inputsUsuario,$this->j);
                array_push($this->usuarioDetalle,$value['nombres']);
                array_push($this->idDetalleUsuario,$value['id']);
                $this->j++;
            }
        }
        $this->reset(['venta_id','user_id','vehiculo_id']);
    }

    public function addDetalleVehiculo(){
        foreach ($this->vehiculos as $key => $value) {
            if($value['id']===intval($this->vehiculo_id)){

                array_push($this->inputsVehiculo,$this->k);
                array_push($this->codigoVehiculo,$value['codigo']);
                array_push($this->aliasVehiculo,$value['alias']);
                array_push($this->idDetalleVehiculo,$value['id']);
                $this->k++;
            }
        }
        $this->reset(['venta_id','user_id','vehiculo_id']);
    }

    public function pdfExportar($id){
        return redirect()->route('pdfExportarEnvio',$id);
    }

    public function pdfExportarEnvio($id)
    {
        $ventas=[];
        $envio=Envio::with('users')->with('ventas')->with('vehiculos')->with('ruta')->find($id)->toArray();



        foreach ($envio['ventas'] as $key => $value) {

            $data=Venta::with('cliente')->find($value['id'])->toArray();
            array_push($ventas ,$data);
        }



        $pdf = FacadePdf::loadView('/livewire/pdf/pdfEnvio ',['envio'=>$envio,'ventas'=>$ventas]);
        return $pdf->stream();

    }


    public function store(){

        $this->validate(['envio_no'=>'required','envio_fecha'=>'required','ruta_id'=>'required',
        'i'=>'numeric|min:1','j'=>'numeric|min:1','k'=>'numeric|min:1']);
        $data=Envio::create(
            [
                'envio_no'=>$this->envio_no,
                'envio_fecha'=>$this->envio_fecha,
                'ruta_id'=>$this->ruta_id,
                'estado_envio'=>"PROCESO",
                'observaciones_inicio_envio'=>$this->observaciones_inicio_envio,
                'visible'=>'1',
                'finalizado'=>'0',
            ]);

        $data->ventas()->attach($this->idDetalleVenta);
        $data->users()->attach($this->idDetalleUsuario);
        $data->vehiculos()->attach($this->idDetalleVehiculo);


        foreach ($this->idDetalleVenta as $key => $value) {
            $data=Venta::find($value);
            $data->update([
                'estado_envio'=>"PROCESO"
            ]);
        }

    ////////////////////
    $this->alertaNotificacion("store");
        $this->reset();
    }

    public function finalizar($id){
        $this->isFinalizar=true;
        $this->disabled=true;
        $this->disabled_observaciones_inicio_envio=true;
        $this->rutas=Ruta::all();
        $this->envio=Envio::where('id','=',$id)->with('ventas')->with('vehiculos')->with('users')->first();
        $this->disabled_observaciones_inicio_envio=true;
        $this->envio_id=$this->envio->id;
        $this->envio_no=$this->envio->envio_no;
        $this->envio_fecha=$this->envio->envio_fecha;
        $this->ruta_id=$this->envio->ruta_id;
        $this->created_at = $this->envio->created_at;
        $this->updated_at = $this->envio->updated_at;
        $this->observaciones_inicio_envio = $this->envio->observaciones_inicio_envio;
        ////////////////////
    }



    public function store_finish(){
            ////////////////////
            $data = Envio::find($this->envio_id);
            $data->update([
                'observaciones_fin_envio'=>$this->observaciones_final_envio,
                'estado_envio'=>"FINALIZADO",
                'finalizado'=>true
            ]);

            foreach ($data->ventas  as $key => $value) {
                $data = Venta::find($value['id']);
                $data->update([
                    'estado_envio'=>"FINALIZADO"
                ]);
            }
        ////////////////////
        $this->alertaNotificacion("store");
            $this->cancel();
    }

    public function delete($id){
        $data = Envio::find($id);
        $this->id_data= $data->id;
        $this->isDelete = true;
        $this->delete_no=$data->envio_no;
        $this->delete_nombre=$data->envio_fecha;
    }

    public function destroy($id){

        $data = Envio::find($id)->with('ventas')->first();

        foreach ($data->ventas as $key => $value) {
            Venta::find($value->id)
            ->update(['estado_envio' => 'SIN ASIGNAR']);
        }
        $data->ventas()->detach();
        $data->users()->detach();
        $data->vehiculos()->detach();

        $data->delete();

        $this->alertaNotificacion("destroy");
/*


*/


        $this->isDelete = false;
        $this->cancel();
    }



    public function cancel(){
        $this->reset();
        $this->resetValidation();
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
