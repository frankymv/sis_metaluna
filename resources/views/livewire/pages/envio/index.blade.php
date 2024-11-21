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
            <table class="w-full">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                    <th class="px-4 py-3 text-ms font-semibold border">No Envio
                        <x-frk.components.filtro-input  wire:model.live="filtroNoEnvio"/>

                    </th>
                    <th class="px-4 py-3">Fecha Envio
                        <x-frk.components.filtro-date-picker-range  label="Fecha"  />
                    </th>
                    <th class="px-4 py-3">Estado Envio
                        <x-frk.components.filtro-select label="Estado" wire:model.live="filtroEstadoEnvio">
                            @foreach ($this->estados as $data)
                            <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                            @endforeach
                        </x-forms.select>
                    </th>
                    <th class="px-4 py-3">Ruta Codigo
                        <x-frk.components.filtro-select label="Rutas" wire:model.live="filtroRuta">
                            @foreach ($this->rutas as $data)
                            <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                            @endforeach
                        </x-forms.select>
                    </th>
                    <th class="px-4 py-3">Ventas</th>
                    <th class="px-4 py-3">Usuario
                        <x-frk.components.filtro-select label="Usuarios" wire:model.live="filtroUsuario">
                            @foreach ($this->usuarios as $data)
                            <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombres']  }}</option>
                            @endforeach
                        </x-forms.select>

                    </th>
                    <th class="px-4 py-3">Vehiculo

                        <x-frk.components.filtro-select label="Vehiculos" wire:model.live="filtroVehiculo">
                            @foreach ($this->vehiculos as $data)
                            <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['alias']  }}</option>
                            @endforeach
                        </x-forms.select>
                    </th>
                    <th class="px-4 py-3">Accion</th>

                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($envios as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->envio_no}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->envio_fecha}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->estado_envio}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->ruta_id}}</td>
                    <td class="px-4 py-3 text-sm border">
                    @foreach ($data->ventas as $dataa)
                        <p class="text-xs text-gray-600">No Venta: {{$dataa->no_venta}} Fecha: {{$dataa->fecha_venta}} Total: {{$dataa->total_venta}}</p>
                    @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        @foreach ($data->users as $dataa)
                            <p class="text-xs text-gray-600">Codigo: {{$dataa->codigo}} Fecha: {{$dataa->nombre}} </p>
                        @endforeach
                        </td>
                    <td class="px-4 py-3 text-sm border">
                        @foreach ($data->vehiculos as $dataa)
                            <p class="text-xs text-gray-600">Codigo: {{$dataa->codigo}} Alias: {{$dataa->alias}}</p>
                        @endforeach
                    </td>

                        <td class="px-4 py-3 text-sm border flex">

                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="blue" icon="fa-solid fa-flag-checkered" wire:click="finalizar({{$data->id}})" />
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
                        </td>

                    </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $envios->withQueryString()->links()}}
          </div>
        </div>
    </section>





    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.envio.create')
        @endif
        @if($isFinalizar)
            @include('livewire.pages.envio.finalizar')
        @endif
        @if($isEdit)
            @include('livewire.pages.envio.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.envio.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.envio.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
