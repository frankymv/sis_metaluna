<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button label="agregar {{$title}}" wire:click="create()" />
                <x-frk.components.button-icon label="exportar" color="red" icon="fa-solid fa-file-pdf" wire:click="exportarGeneral()" />
                </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No Viatico" wire:model.live="filtroNoServicio"/>
                <x-frk.components.selectFiltro label="Vehiculo" wire:model.live="filtroVehiculo">
                    @foreach ($this->vehiculos as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->alias }} {{ $data->apellidos }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.date-picker    label="Fecha Venta" wire:model.live="filtroFechaServicio" />
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

                        <td class="px-4 py-3 text-ms font-semibold border">no_servicio</th>
                            <th class="px-4 py-3">fecha_servicio</th>
                            <th class="px-4 py-3">total_servicio</th>
                            <th class="px-4 py-3">vehiculo_id</th>
                            <th class="px-4 py-3">descripcion</th>
                            <th class="px-4 py-3">Acciones</th>



                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($servicios as $data)
                    <tr class="text-gray-700">

                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_servicio}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_servicio}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->total_servicio}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->vehiculo->numero_placa}} / {{$data->vehiculo->alias}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->descripcion}}</td>
                         <td class="px-4 py-3 text-sm border flex w-full">
                            <x-frk.components.button-icon color="yellow" icon="fa-solid fa-eye" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="green" icon="fa-solid fa-pencil" wire:click="edit({{$data->id}})" />
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
            @include('livewire.pages.servicio.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.servicio.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.servicio.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.servicio.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
