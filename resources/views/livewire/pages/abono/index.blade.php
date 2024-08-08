<x-frk.components.template-index>
    <x-slot:head>

    <div class="w-full">
        <div class="flex w-full">
            <x-frk.components.title label="{{$title}}" />
            <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
            <x-frk.components.button label="agregar {{$title}}" wire:click="create()" />
            <x-frk.components.button label="Abono anticipado" wire:click="abonoAnticipado()" />
            <x-frk.components.button label="Asignar Abono anticipado" wire:click="abonoAnticipadoAsignar()" />
        </div>
        <div class="flex w-full">

            <x-frk.components.label-input label="No Abono" wire:model.live="filtroNoAbono"/>
            <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>
            <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>

            <x-frk.components.date-picker   wire:model.live="filtroFechaAbono" label="Fecha Abono"/>
        </div>
    </div>


    </x-slot:head>
    <x-slot:body>



    <section class="container mx-auto p-6 font-mono">
        <div class="w-full mb-8 overflow-hidden rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class="w-full">
                <thead>


                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b border-gray-600">
                        <th class="px-4 py-3">Fecha Abono</th>
                    <th class="px-4 py-3">No Abono</th>
                    <th class="px-4 py-3">Total Abono</th>
                    <th class="px-4 py-3">Observaciones</th>
                    <th class="px-4 py-3">No Venta</th>

                    <th class="px-4 py-3">Nombre Cliente</th>
                    <th class="px-4 py-3">Codigo Cliente</th>



                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($abonos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_abono}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_abono}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->total_abono}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>
                        <td class="px-4 py-3 text-sm border">
                            @if ($data->venta==null)
                            Abono Anticipado
                            @else
                            Abono a: {{ $data->venta->no_venta}}
                            @endif


                        </td>
                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} Telefono {{$data->cliente->telefono_principal}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->cliente->codigo_mayorista}}</td>
                         <td class="px-4 py-3 text-sm border flex w-full">
                            <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />

                                <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
                        </td>
                    </tr>
                    @endforeach
                    <tr>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border"></td>
                        <td class="px-4 py-3 text-sm border">{{$total_abonos}}</td>
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

        @if($isCreate)
            @include('livewire.pages.abono.create_abono')
        @endif

        @if($isSearchVenta)
            @include('livewire.pages.abono.searchVenta')
        @endif
        @if($isCreateAnticipado)
            @include('livewire.pages.abono.create_anticipado')
        @endif
        @if($isCreateAnticipadoAsignar)
            @include('livewire.pages.abono.create_anticipado_asignar')
        @endif
        @if($isEdit)
            @include('livewire.pages.abono.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.abono.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.abono.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
