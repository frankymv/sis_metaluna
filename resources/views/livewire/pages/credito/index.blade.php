<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
            </div>
            <div class="flex w-full">

                <x-frk.components.label-input label="No Credito" wire:model.live="filtroNoCredito"/>
                <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>
                <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>

                <x-frk.components.date-picker   wire:model.live="filtroFechaCredito" label="Fecha Credito"/>
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
                    <th class="px-4 py-3">No Credito</th>
                    <th class="px-4 py-3">Fecha Credito</th>
                    <th class="px-4 py-3">Fecha Limite Credito</th>
                    <th class="px-4 py-3">Total</th>

                    <th class="px-4 py-3">No Venta</th>
                    <th class="px-4 py-3">Nombre Cliente</th>
                    <th class="px-4 py-3">Codigo Cliente</th>




                    <th class="px-4 py-3">Acciones</th>

                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($creditos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_limite_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->total_credito}}</td>





                        <td class="px-4 py-3 text-sm border">{{$data->no_venta}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->nombres_cliente}} Telefono {{$data->telefono_principal}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->codigo_mayorista}}</td>

                         <td class="px-4 py-3 text-sm border flex w-full">
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                        </td>


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

        @if($isEdit)
            @include('livewire.pages.credito.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.credito.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.credito.delete')
        @endif

    </x-slot:footer>
</x-frk.components.template-index>
