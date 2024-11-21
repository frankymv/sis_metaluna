<x-frk.components.template-index>
    <x-slot:head>
        <div class="flex w-full">
            <div class="flex w-full justify-center">
                <x-frk.components.title   label="{{$title}}" />
            </div>
            <div class="flex w-full justify-center">

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
                    <th class="px-4 py-3">No Credito
                        <x-frk.components.filtro-input  wire:model.live="filtroNoCredito"/>
                    </th>
                    <th class="px-4 py-3">Fecha Credito
                        <x-frk.components.filtro-date-picker-range  label="Fecha"  />
                    </th>
                    <th class="px-4 py-3">Fecha Limite Credito</th>
                    <th class="px-4 py-3">Total</th>

                    <th class="px-4 py-3">No Venta</th>
                    <th class="px-4 py-3">Nombre Cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroNombreCliente"/>
                    </th>
                    <th class="px-4 py-3">Codigo Cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroCodigoCliente"/>
                    </th>
                    <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($creditos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_credito}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_limite_credito}}</td>
                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_credito}}</td>





                        <td class="px-4 py-3 text-sm border">{{$data->no_venta}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->nombres_cliente}} {{$data->apellidos_cliente}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->codigo_mayorista}}</td>

                         <td class="px-4 py-3 text-sm border">
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
