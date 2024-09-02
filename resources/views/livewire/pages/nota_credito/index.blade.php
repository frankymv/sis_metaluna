<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
                <x-frk.components.button label="agregar" wire:click="create()" />
            </div>
            <div class="flex w-full">

                <x-frk.components.label-input label="No Nota Credito" wire:model.live="filtroNoNotaCredito"/>
                <x-frk.components.label-input label="No Venta" wire:model.live="filtroNoVenta"/>
                <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>
                <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>
                <x-frk.components.date-picker    label="Fecha Abono" wire:model.live="filtroFechaNotaCredito" />
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
                    <th class="px-4 py-3">No Nota Credito</th>
                    <th class="px-4 py-3">No Venta</th>


                    <th class="px-4 py-3">Nombre Cliente</th>
                    <th class="px-4 py-3">Codigo Cliente</th>
                    <th class="px-4 py-3">Total Nota Credito</th>
                    <th class="px-4 py-3">Fecha Nota Credito</th>
                    <th class="px-4 py-3">Observaciones</th>

                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($nota_creditos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_nota_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->venta->no_venta}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} Telefono {{$data->cliente->telefono_principal}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->cliente->codigo_interno}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->total_nota_credito}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->fecha_nota_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>
                         <td class="px-4 py-3 text-sm border flex w-full">
                            <td class="px-4 py-3 text-sm border flex w-full">
                                <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />
                                <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
                            </td>                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>


                        <td class="px-4 py-3 text-sm border"></td>
                    </tr>

                </tbody>
            </table>
          </div>
        </div>
    </section>

    </x-slot:body>
    <x-slot:footer>
        @if($isSearchVenta)
            @include('livewire.pages.nota_credito.searchVenta')
        @endif
        @if($isCreate)
            @include('livewire.pages.nota_credito.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.nota_credito.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.nota_credito.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.nota_credito.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
