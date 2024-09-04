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
                        <th class="px-4 py-3 text-ms font-semibold border">No Traslado
                            <x-frk.components.filtro-input  wire:model.live="filtroNoTraslado"/>
                        </th>
                        <th class="px-4 py-3">Fecha Traslado
                            <x-frk.components.filtro-date-picker-range  label="Fecha"  />
                        </th>
                        <th class="px-4 py-3">Origen
                            <x-frk.components.filtro-select  wire:model.live="filtroSucursalOrigen">
                                @foreach ($this->sucursales as $data)
                                <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                                @endforeach
                            </x-forms.select>
                        </th>
                        <th class="px-4 py-3">Destino
                            <x-frk.components.filtro-select wire:model.live="filtroSucursalDestino">
                                @foreach ($this->sucursales as $data)
                                <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                                @endforeach
                            </x-forms.select>
                        </th>
                        <th class="px-4 py-3">Productos</th>
                        <th class="px-4 py-3">Acciones</th>



                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($traslados as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->traslado_no}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->traslado_fecha}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->sucursalOrigen->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->sucursalDestino->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">



                            @foreach ($data->productos as $key=>$dataa)
                            <p>Producto:{{$dataa->nombre}}</p>
                            <p>Cantidad:{{$dataa->pivot->cantidad}}</p>
                             @endforeach

                        </td>
                        <td class="px-4 py-3 text-sm border flex w-full">
                            <x-frk.components.button-icon color="blue" icon="fa-solid fa-eye" wire:click="show({{$data->id}})" />
                            <x-frk.components.button-icon color="yellow" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
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
            @include('livewire.pages.traslado.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.traslado.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.traslado.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.traslado.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
