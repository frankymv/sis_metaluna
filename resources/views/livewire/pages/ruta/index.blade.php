<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
                <x-frk.components.button label="agregar {{$title}}" wire:click="create()" />
            </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="Codigo" wire:model.live="filtroCodigo"/>


                <x-frk.components.label-input    label="Nombre" wire:model.live="filtroNombre" />
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
                        <th class="px-4 py-3 text-ms font-semibold border">Codigo</th>
                        <th class="px-4 py-3">Nombre</th>
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
