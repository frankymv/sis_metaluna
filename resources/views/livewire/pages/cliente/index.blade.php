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
                        <th class="px-4 py-3">Codigo Interno
                            <x-frk.components.filtro-input  wire:model.live="filtroCodigoInterno"/>
                        </th>
                    <th class="px-4 py-3">Codigo Mayorista
                        <x-frk.components.filtro-input  wire:model.live="filtroCodigMayorista"/>
                    </th>
                    <th class="px-4 py-3">Tipo Cliente
                        <x-frk.components.select label="Tipo Cliente" wire:model.live="filtroTipoCliente">
                            @foreach ($this->tipo_clientes as $data)
                            <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                            @endforeach
                        </x-forms.select>
                    </th>
                    <th class="px-4 py-3">Nombre empresa</th>
                    <th class="px-4 py-3">Nombres cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroNombresCliente"/>
                    </th>
                    <th class="px-4 py-3">Apellidos cliente
                        <x-frk.components.filtro-input  wire:model.live="filtroApellidosCliente"/>
                    </th>
                    <th class="px-4 py-3">Nit</th>
                    <th class="px-4 py-3">Telefono</th>
                    <th class="px-4 py-3">Direccion</th>

                    <th class="px-4 py-3">Credito</th>
                    <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($clientes as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->codigo_interno}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->codigo_mayorista}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->tipo_cliente}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->nombre_empresa}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->nombres_cliente}}</td>

                        <td class="px-4 py-3 text-sm border">{{$data->apellidos_cliente}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->nit}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->telefono_principal}}</td>
                        <td class="px-4 py-3 text-sm border">{{$data->direccion_fisica}}</td>


                        <td class="px-4 py-3 text-sm border">
                            <p class="text-xs text-gray-600">Limite: Q.{{$data->limite_credito}}</p>
                            <p class="text-xs text-gray-600">Dias: {{$data->dias_limite_credito}}</p>


                        </td>

                        <td class="px-4 py-3 text-sm border flex">
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
    {{ $clientes->withQueryString()->links()}}

    </x-slot:body>
    <x-slot:footer>
        @if($isCreate)
            @include('livewire.pages.cliente.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.cliente.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.cliente.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.cliente.delete')
        @endif

    </x-slot:footer>
</x-frk.components.template-index>
