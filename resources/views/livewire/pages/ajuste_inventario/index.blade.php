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
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-200 uppercase border-gray-900">
                        <th class="px-4 py-2 text-ms font-semibold border ">No Ajuste
                            <x-frk.components.filtro-input   placeholder="No Ajuste" wire:model.live="filtroNoAjuste"/>
                        </th>
                        <th class="px-4 py-2">Fecha Ajuste
                            <x-frk.components.filtro-date-picker-range   placeholder="Fecha"  />
                        </th>
                        <th class="px-4 py-2">Productos</th>
                        <th class="px-4 py-2">Cantidad</th>
                        <th class="px-4 py-2">Tipo Ajuste
                            <x-frk.components.filtro-select placeholder="Tipo Ajuste"  error="tipo_ajuste" wire:model.live="filtroTipoAjuste">
                                @foreach ($this->tipos_ajustes as $data)
                                <option value="{{ $data['valor'] }}" wire:key="producto-{{ $data['valor'] }}">{{ $data['nombre'] }}</option>
                                @endforeach
                            </x-forms.select>
                        </th>
                        <th class="px-4 py-2">Descripcion</th>
                        <th class="px-4 py-2">Accion</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($ajustes as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-sm font-semibold border">{{$data->ajuste_inventario_no}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->fecha_ajuste_inventario}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->producto->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->cantidad_traslado}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->tipo_ajuste}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->descripcion}}</td>
                        <td class="px-4 py-3 text-sm border">
                            <div class="flex justify-center">
                                <x-frk.components.button-icon color="blue" icon="fa-solid fa-eye" wire:click="show({{$data->id}})" />
                                <x-frk.components.button-icon color="yellow" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                                <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
                            </div>
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
            @include('livewire.pages.ajuste_inventario.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.ajuste_inventario.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.ajuste_inventario.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.ajuste_inventario.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
