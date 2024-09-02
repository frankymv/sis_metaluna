<x-frk.components.template-index>
    <x-slot:head>
    <div class="w-full">
        <div class="flex w-full">
            <x-frk.components.title label="{{$title}}" />
            <x-frk.components.button label="agregar" wire:click="create()" />
            <x-frk.components.button-icon label="exportar" color="red" icon="fa-solid fa-file-pdf" wire:click="exportarGeneral()" />
        </div>
        <div class="flex w-full">
            <x-frk.components.label-input label="Codigo Interno" wire:model.live="filtroCodigoInterno"/>
            <x-frk.components.label-input label="Codigo Mayorista" wire:model.live="filtroCodigMayorista"/>
            <x-frk.components.select label="Tipo Cliente" wire:model.live="filtroTipoCliente">
                @foreach ($this->tipo_clientes as $data)
                <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                @endforeach
            </x-forms.select>
            <x-frk.components.label-input label="Nombres Cliente" wire:model.live="filtroNombresCliente"/>
            <x-frk.components.label-input label="Apellidos Cliente" wire:model.live="filtroApellidosCliente"/>

            <x-frk.components.select label="Ruta" wire:model.live="filtroRuta">
                @foreach ($this->rutas as $data)
                <option value="{{ $data->id }}" wire:key="tipo-{{ $data['id'] }}"> {{ $data->nombre }}</option>
                @endforeach
            </x-forms.select>
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
                        <th class="px-4 py-3">Codigo Interno</th>
                    <th class="px-4 py-3">Codigo Mayorista</th>
                    <th class="px-4 py-3">Tipo Cliente</th>
                    <th class="px-4 py-3">Nombre empresa</th>
                    <th class="px-4 py-3">Nombres cliente</th>
                    <th class="px-4 py-3">Apellidos cliente</th>
                    <th class="px-4 py-3">Nit</th>
                    <th class="px-4 py-3">Telefono</th>
                    <th class="px-4 py-3">Direccion</th>
                    <th class="px-4 py-3">Ruta</th>
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

                        <td class="px-4 py-3 text-sm border">{{$data->ruta->nombre}}</td>
                        <td class="px-4 py-3 text-sm border">
                            <p class="text-xs text-gray-600">Limite:{{$data->limite_credito}}</p>
                            <p class="text-xs text-gray-600">Dias:{{$data->dias_limite_credito}}</p>


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
