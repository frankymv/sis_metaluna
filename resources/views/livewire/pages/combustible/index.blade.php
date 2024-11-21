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
                    <th class="px-4 py-3">No Combustible
                        <x-frk.components.filtro-input  wire:model.live="filtroNoCombustible"/>
                    </th>
                    <th class="px-4 py-3">Fecha Combustible
                        <x-frk.components.filtro-date-picker-range  label="filtroFechaCombustible"  />
                    </th>
                    <th class="px-4 py-3">Codigo Usuario</th>
                    <th class="px-4 py-3">Nombre Usuario</th>
                    <th class="px-4 py-3">Placas Vehiculo</th>
                    <th class="px-4 py-3">Alias Vehiculo

                        <x-frk.components.filtro-select label="Vehiculo" wire:model.live="filtroProveedor">
                            @foreach ($this->vehiculos as $data)
                            <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">Placa:{{ $data->numero_placa }} - Alias{{ $data->alias }}</option>
                            @endforeach
                        </x-forms.select>
                    </th>
                    <th class="px-4 py-3">Observaciones
                        <x-frk.components.filtro-input  wire:model.live="filtroObservaciones"/>
                    </th>
                    <th class="px-4 py-3">Total Combustible</th>


                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($combustibles as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_combustible}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->user->codigo}}</td>


                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">Nombre:{{$data->user->nombres}} {{$data->user->apellidos}}</p>
                        </td>
                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">Nombre:{{$data->vehiculo->numero_placa}} </p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->vehiculo->alias}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->total_combustible}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->fecha_combustible}}</td>
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
{{$combustibles->withQueryString()->links()}}

    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.combustible.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.combustible.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.combustible.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.combustible.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
