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
                <table class="w-full">
                    <thead>
                        <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                            <th class="px-4 py-3 text-ms font-semibold border">Id</th>
                            <th class="px-4 py-3">Nombre
                                <x-frk.components.filtro-input  wire:model.live="filtroNombre"/>

                            </th>
                            <th class="px-4 py-3">Descripcion</th>
                            <th class="px-4 py-3">Estado
                                <x-frk.components.filtro-select label="Estado" wire:model.live="filtroEstado">
                                    @foreach ($this->estados as $data)
                                    <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre']  }}</option>
                                    @endforeach
                                </x-forms.select>
                            </th>
                            <th class="px-4 py-3">Accion</th>


                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($tipos as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border">{{$data->id}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->nombre}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->descripcion}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->estado}}</td>
                             <td class="px-4 py-3 text-sm border flex w-full">
                                <x-frk.components.button-icon color="green" icon="fa-solid fa-pencil" wire:click="edit({{$data->id}})" />
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
            @include('livewire.pages.tipo.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.tipo.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.tipo.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.tipo.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
