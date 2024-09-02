<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
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
            <table class=" table-fixed">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                        <th class="px-4 py-3">No Venta</th>
                    <th class="px-4 py-3">Cliente</th>

                    <th class="px-4 py-3">Forma Pago</th>
                    <th class="px-4 py-3">Fecha Venta</th>
                    <th class="px-4 py-3">Total Venta</th>
                    <th class="px-4 py-3">Nota Credito</th>
                    <th class="px-4 py-3">Total Venta con Nota Credito</th>
                    <th class="px-4 py-3">Credito</th>
                    <th class="px-4 py-3">Abono</th>
                    <th class="px-4 py-3">Saldo</th>
                    <th class="px-4 py-3">Anulado</th>
                    <th class="px-4 py-3">Detalle Operaciones</th>

                    <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($ventas as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_venta}}</td>
                            <td class="px-4 py-3 border">
                                <p class="text-xs text-gray-600">Codigo Cliente Mayorista: {{$data->cliente->codigo_mayorista}} Nombres: {{$data->cliente->nombres_cliente}}</p>
                            </td>
                            <td class="px-4 py-3 text-sm border">{{$data->forma_pago_venta}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->fecha_venta}}</td>
                            <td class="px-4 py-3 text-sm font-semibold border">{{$data->total_venta}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->total_nota_credito}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->total_venta-$data->total_nota_credito}}</td>



                            @if (($data->total_credito-$data->total_nota_credito)<=0)
                            <td class="px-4 py-3 text-sm border"> 0</td>
                            @else
                            <td class="px-4 py-3 text-sm border"> {{$data->total_credito-$data->total_nota_credito}}</td>
                            @endif

                            <td class="px-4 py-3 text-sm border">{{$data->total_abono}}</td>




                            @if ((($data->total_credito-$data->total_nota_credito)-$data->total_abono)<=0)
                            <td class="px-4 py-3 text-sm border"> 0</td>
                            @else
                            <td class="px-4 py-3 text-sm border"> {{($data->total_credito-$data->total_nota_credito)-$data->total_abono}}</td>
                            @endif
                            @if ($data->anulado==0)
                            <td class="px-4 py-3 text-sm border text-green-600 font-bold"> NO</td>
                            @else
                            <td class="px-4 py-3 text-sm border text-red-600 font-bold"> SI</td>
                            @endif
                            <td class="px-4 py-3 border">
                            @foreach ($data->creditos as $dataa)
                                <p class="text-xs text-gray-600">No Credito: {{$dataa->no_credito}} Fecha: {{$dataa->fecha_credito}} Total: {{$dataa->total_credito}}</p>
                            @endforeach
                            @foreach ($data->abonos as $dataa)
                                <p class="text-xs text-gray-600">No_abono: {{$dataa->no_abono}} Fecha: {{$dataa->fecha_abono}} Total: {{$dataa->total_abono}}</p>
                            @endforeach
                            @foreach ($data->notacreditos as $dataa)
                                <p class="text-xs text-gray-600">No Nota Credito: {{$dataa->no_nota_credito}} Fecha: {{$dataa->fecha_nota_credito}} Total: {{$dataa->total_nota_credito}}</p>
                            @endforeach
                            </td>
                            <td class="px-4 py-3 text-sm border flex w-full">
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
