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
    </x-slot:head>
    <x-slot:body>
    <section class="container mx-auto ">
        <div class="w-full  rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class=" w-full">
                <thead>


                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                    <th class="px-4 py-3">No Viatico
                        <x-frk.components.filtro-input  wire:model.live="filtroNoViatico"/>
                    </th>
                    <th class="px-4 py-3">Codigo Usuario
                        <x-frk.components.filtro-input  wire:model.live="filtroNoUsuario"/>
                    </th>
                    <th class="px-4 py-3">Nombre Usuario
                        <x-frk.components.filtro-input  wire:model.live="filtroNombreUsuario"/>
                    </th>
                    <th class="px-4 py-3">Observaciones</th>
                    <th class="px-4 py-3">Total Viatico</th>
                    <th class="px-4 py-3">Fecha Viatico
                        <x-frk.components.filtro-date-picker-range  label="Fecha"  />
                    </th>

                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($viaticos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_viatico}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->user->codigo}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">{{$data->user->nombres}} {{$data->user->apellidos}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>

                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_viatico}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->fecha_viatico}}</td>
                         <td class="px-4 py-3 text-sm border flex">
                            <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="green" icon="fa-solid fa-pencil" wire:click="edit({{$data->id}})" />
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
          </div>
        </div>
    </section>

    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.viatico.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.viatico.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.viatico.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.viatico.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
