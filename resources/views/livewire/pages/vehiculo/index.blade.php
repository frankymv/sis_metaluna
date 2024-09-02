<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
                <x-frk.components.button label="agregar" wire:click="create()" />
            </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="Codigo Vehiculo" wire:model.live="filtroCodigo"/>

                <x-frk.components.label-input label="Numero Placa" wire:model.live="filtroNumeroPlaca"/>
                <x-frk.components.label-input    label="Alias" wire:model.live="filtroAlias" />
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
                        <th class="px-4 py-3">Codigo</th>
                        <th class="px-4 py-3">Tipo Vehiculo</th>
                        <th class="px-4 py-3">Tipo Placa</th>
                        <th class="px-4 py-3">Numero Placa</th>
                        <th class="px-4 py-3">Marca</th>
                        <th class="px-4 py-3">Modelo</th>
                        <th class="px-4 py-3">Linea</th>
                        <th class="px-4 py-3">Alias</th>
                        <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($vehiculos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->codigo}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->tipo_vehiculo}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->tipo_placa}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->numero_placa}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->marca}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->modelo}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->linea}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->alias}}</td>

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
            @include('livewire.pages.vehiculo.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.vehiculo.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.vehiculo.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.vehiculo.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
