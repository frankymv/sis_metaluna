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
            <table class=" w-full">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                        <th class="px-4 py-3 text-ms font-semibold border">Codigo
                            <x-frk.components.filtro-input  wire:model.live="filtroCodigo"/>

                        </th>
                        <th class="px-4 py-3">Nombre
                            <x-frk.components.filtro-input  wire:model.live="filtroNombre" />
                        </th>
                        <th class="px-4 py-3">Descripcion</th>
                        <th class="px-4 py-3">Departamentos / Municipios</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($rutas as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->codigo}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->descripcion}}</td>
                        <td class="px-4 py-3 text-sm border">
                        @foreach ($data->departamentos as $key=>$dataa)
                        <p>DEPARTAMENTO:{{$dataa->nombre}}</p>
                        <p>MUNICIPIO:{{$data->municipios[$key]['nombre']}}</p>
                        <p>Observacion:{{$data->municipios[$key]['observacion']}}</p>
                        @endforeach
                        </td>
                         <td class="px-4 py-3 text-sm border flex">
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="green" icon="fa-solid fa-pencil" wire:click="edit({{$data->id}})" />
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="delete({{$data->id}})" />
                        </td>
                    </tr>
                    @endforeach


                </tbody>
            </table>
            {{ $rutas->withQueryString()->links()}}
          </div>
        </div>
    </section>




    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.ruta.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.ruta.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.ruta.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.ruta.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
