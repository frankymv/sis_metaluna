<x-frk.components.template-index>
    <x-slot:head>
        <div class="flex w-full">
            <div class="flex w-full justify-center">
                <x-frk.components.title   label="{{$title}}" />
            </div>
            <div class="flex w-full justify-center">
                <x-frk.components.button color="blue" label="agregar" wire:click="create()" />
                <x-frk.components.button-icon  color="red" icon="fa-solid fa-file-pdf" wire:click="exportarGeneral()" />
                <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="borrarFiltros()" />
                <div class="flex   justify-center">
                    <select wire:model.live="per_page" class="flex border mx-2 border-gray-400  text-sm shadow text-gray-900 rounded-md focus:border-blue-500 focus:border-2 placeholder-gray-400 focus:outline-none focus:shadow-outline"  >
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="15">15</option>
                        <option value="20">20</option>
                        <option value="">Todo</option>
                    </select>
                </div>
            </div>
        </div>
            <div class="flex w-full">



        </div>
    </x-slot:head>
    <x-slot:body>



    <section class="container mx-auto ">
        <div class="w-full  rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class=" w-full">
                <thead>


                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">

                    <th class="px-4 py-3">No Nota Credito
                        <x-frk.components.filtro-input  wire:model.live="filtroNoNotaCredito"/>
                    </th>
                    <th class="px-4 py-3">Fecha Nota Credito
                        <x-frk.components.filtro-date-picker-range  label="filtroFechaNotaCredito"  />
                    </th>
                    <th class="px-4 py-3">No Venta
                        <x-frk.components.filtro-input  wire:model.live="filtroNoVenta"/>
                    </th>


                    <th class="px-4 py-3">Nombre Cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroNombreCliente"/>
                    </th>
                    <th class="px-4 py-3">Codigo Cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroCodigoCliente"/>
                    </th>
                    <th class="px-4 py-3">Total Nota Credito</th>

                    <th class="px-4 py-3">Observaciones</th>

                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($notass as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_nota_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_nota_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->venta->no_venta}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} {{$data->cliente->apellidos_cliente}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->cliente->codigo_interno}}</td>
                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_nota_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>
                        <td class="px-4 py-3 text-sm border flex">
                            <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
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
            {{ $notass->withQueryString()->links()}}
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
