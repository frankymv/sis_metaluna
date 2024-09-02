<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button label="agregar" wire:click="create()" />
                <x-frk.components.button-icon label="exportar" color="red" icon="fa-solid fa-file-pdf" wire:click="exportarGeneral()" />
                </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No Traslado" wire:model.live="filtroNoTraslado"/>
                <x-frk.components.date-picker-range  label="Fecha"  />

                <x-frk.components.select label="Sucursal Origen" wire:model.live="filtroSucursalOrigen">
                    @foreach ($this->sucursales as $data)
                    <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.select label="Sucursal Destino" wire:model.live="filtroSucursalDestino">
                    @foreach ($this->sucursales as $data)
                    <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                    @endforeach
                </x-forms.select>
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
                        <th class="px-4 py-3 text-ms font-semibold border">No Traslado</th>
                        <th class="px-4 py-3">Fecha Traslado</th>
                        <th class="px-4 py-3">Origen</th>
                        <th class="px-4 py-3">Destino</th>
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
