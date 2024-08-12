<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
                <x-frk.components.button label="agregar {{$title}}" wire:click="create()" />
            </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No Combustible" wire:model.live="filtroNoCombustible"/>


                <x-frk.components.selectFiltro label="Usuario" wire:model.live="filtroUsuario">
                    @foreach ($this->users as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">{{ $data->nombres }} {{ $data->apellidos }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Vehiculo" wire:model.live="filtroVehiculo">
                    @foreach ($this->vehiculos as $data)
                    <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}">Placa:{{ $data->numero_placa }} - Alias{{ $data->alias }}</option>
                    @endforeach
                </x-forms.select>
                <x-frk.components.label-input label="Observaciones" wire:model.live="filtroObservaciones"/>
                <x-frk.components.date-picker    label="Fecha Combustible" wire:model.live="filtroFechaCombustible" />
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
                    <th class="px-4 py-3">No Combustible</th>
                    <th class="px-4 py-3">Codigo Usuario</th>
                    <th class="px-4 py-3">Nombre Usuario</th>
                    <th class="px-4 py-3">Placas Vehiculo</th>
                    <th class="px-4 py-3">Alias Vehiculo</th>
                    <th class="px-4 py-3">Observaciones</th>
                    <th class="px-4 py-3">Total Combustible</th>
                    <th class="px-4 py-3">Fecha Combustible</th>

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
                        <td class="px-4 py-3 text-sm border flex w-full">
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
