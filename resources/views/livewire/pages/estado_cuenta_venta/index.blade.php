<x-frk.components.template-index>
    <x-slot:head>
        <div class="flex w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />

                </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No Venta" wire:model.live="filtroNoVenta"/>
                <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>
                <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>
                <x-frk.components.date-picker    label="Fecha Venta" wire:model.live="filtroFechaVenta" />
            </div>
        </div>
    </x-slot:head>
    <x-slot:body>
    <section class="container mx-auto ">
        <div class="w-full  rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                        <th class="px-4 py-3 text-wrap">
                            No</br>Venta</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Forma </br>Pago</th>
                        <th class="px-4 py-3">Fecha </br>Venta</th>
                        <th class="px-4 py-3">Saldo:</th>
                        <th class="px-4 py-3">Anulado</th>
                        <th class="px-4 py-3">Detalle Operaciones</th>
                        <th class="px-4 py-3">Cancelada</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($ventas as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 border">{{$data->no_venta}}</td>
                            <td class="px-4 py-3 border">
                                <p class="text-xs text-gray-600">Codigo Cliente Mayorista: {{$data->cliente->codigo_mayorista}}</p>
                                <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} {{$data->cliente->apellidos_cliente}}</p>
                                <p class="text-xs text-gray-600">{{$data->cliente->nombre_empresa}}</p>

                            </td>
                            <td class="px-4 py-3 text-sm border">{{$data->forma_pago_venta}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->fecha_venta}}</td>


                            <td class="px-4 py-3 text-sm border">
                                <p class="text-xs text-gray-600"> Total Venta:{{$data->total_venta}}</p>
                                <p class="text-xs text-gray-600"> Nota Credito: {{$data->total_nota_credito}}</p>
                                <p class="text-base text-gray-600 font-bold">Nuevo Saldo: {{$data->total_venta-$data->total_nota_credito}}</p>
                                <br>

                                @if ($data->credito)
                                <p class="text-xs text-gray-600">Saldo credito:
                                    @if (($data->total_credito-$data->total_nota_credito)<=0)
                                        0
                                    @else
                                        {{$data->total_credito-$data->total_nota_credito}}
                                    @endif
                                     </p>
                                     <p class="text-xs text-gray-600">Total abonos: {{$data->total_abono}}</p>
                                     <p class="text-base text-gray-600 font-bold">Credito actual:
                                        @if ((($data->total_credito-$data->total_nota_credito)-$data->total_abono)<=0)
                                            0
                                            @else
                                            {{($data->total_credito-$data->total_nota_credito)-$data->total_abono}}
                                        @endif
                                    </p>
                                @endif
                            </td>

                            @if ($data->anulado==0)
                                <td class="px-4 py-3 text-sm border text-green-600 font-bold"> NO</td>
                                @else
                                <td class="px-4 py-3 text-sm border text-red-600 font-bold"> SI</td>
                            @endif
                            <td class="px-4 py-3 border">
                                @if ($data->credito!=null)
                                <p class="text-xs text-gray-600 font-bold">- No_Credito: {{$data->credito->no_credito}} </p>
                                <p class="text-xs text-gray-600">Fecha: {{$data->credito->fecha_credito}} </p>
                                <p class="text-xs text-gray-600">Fecha limite: {{$data->credito->fecha_limite_credito}}</p>
                                <p class="text-xs text-gray-600">Total: {{$data->credito->total_credito}}</p>
                                @endif
                            @foreach ($data->abonos as $dataa)
                                <p class="text-xs text-gray-600 font-bold">- No_abono: {{$dataa->no_abono}} </p>
                                <p class="text-xs text-gray-600">Fecha: {{$dataa->fecha_abono}} </p>
                                <p class="text-xs text-gray-600">Total: {{$dataa->total_abono}}</p>
                            @endforeach
                            @foreach ($data->notacreditos as $dataa)
                                <p class="text-xs text-gray-600 font-bold">- No Nota Credito: {{$dataa->no_nota_credito}} </p>
                                <p class="text-xs text-gray-600">Fecha: {{$dataa->fecha_nota_credito}}</p>
                                <p class="text-xs text-gray-600">Total: {{$dataa->total_nota_credito}}</p>
                            @endforeach
                            </td>
                            @if ($data->cancelado_total_venta==0)
                            <td class="px-4 py-3 text-sm border text-red-600 font-bold"> NO</td>
                            @else
                            <td class="px-4 py-3 text-sm border text-green-600 font-bold"> SI</td>
                        @endif
                            <td class="px-4 py-3 text-sm border">
                                <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
        </div>
    </section>

    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.estado_cuenta_venta.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.estado_cuenta_venta.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.estado_cuenta_venta.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.estado_cuenta_venta.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
