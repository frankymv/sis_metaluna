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
                            <th class="px-4 py-3 text-ms font-semibold border">Id</th>
                            <th class="px-4 py-3">Nombre
                                <x-frk.components.filtro-input  wire:model.live="filtroNombre"/>
                            </th>
                            <th class="px-4 py-3">Descripcion</th>

                            <th class="px-4 py-3">Accion</th>


                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($roles as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border">{{$data->id}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->name}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->descripcion}}</td>

                             <td class="px-4 py-3 text-sm border">
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
            @include('livewire.pages.marca.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.marca.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.marca.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.marca.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
