<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
                <x-frk.components.button label="agregar {{$title}}" wire:click="create()" />
                </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No Viatico" wire:model.live="filtroNoViatico"/>
                <x-frk.components.label-input label="No Usuario" wire:model.live="filtroNoUsuario"/>
                <x-frk.components.label-input label="Nombre Usuario" wire:model.live="filtroNombreUsuario"/>
                <x-frk.components.label-input label="Apellido Usuario" wire:model.live="filtroApellidoUsuario"/>
                <x-frk.components.date-picker    label="Fecha Abono" wire:model.live="filtroFechaViatico" />
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
                    <th class="px-4 py-3">No Viatico</th>
                    <th class="px-4 py-3">Codigo Usuario</th>
                    <th class="px-4 py-3">Nombre Usuario</th>
                    <th class="px-4 py-3">Observaciones</th>
                    <th class="px-4 py-3">Total Viatico</th>
                    <th class="px-4 py-3">Fecha Viatico</th>

                    <th class="px-4 py-3">Acciones</th>


                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($viaticos as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_viatico}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->user->codigo}}</td>

                        <td class="px-4 py-3 border">
                            <p class="text-xs text-gray-600">Nombre:{{$data->user->nombres}} {{$data->user->apellidos}}</p>
                        </td>
                        <td class="px-4 py-3 text-sm border">{{$data->observaciones}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->total_viatico}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->fecha_viatico}}</td>
                         <td class="px-4 py-3 text-sm border flex w-full">
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf"  />
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
