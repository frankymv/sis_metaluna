<x-frk.components.template-index>
    <x-slot:head>
    <div class="flex w-full">
        <div class="flex w-full justify-center">
            <x-frk.components.title   label="{{$title}}" />
        </div>
        <div class="flex w-full justify-center">

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
        <div class="flex w-full">


            <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>
            <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>



            <x-frk.components.select label="Ruta" wire:model.live="filtroRutaCliente">
                @foreach ($this->rutas as $data)
                <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                @endforeach
            </x-forms.select>
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
                        <th class="px-4 py-3">No.</th>
                        <th class="px-4 py-3">Detalle Cliente</th>
                        <th class="px-4 py-3">Credito</th>
                        <th class="px-4 py-3">Abono</th>
                        <th class="px-4 py-3">Saldo</th>
                        <th class="px-4 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($estado_cuentas as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 border">{{$data->id}}</td>
                        <td class="px-4 py-3 text-sm border">
                            <p class="text-xs text-gray-600">Codigo Cliente Mayorista:{{$data->cliente->codigo_interno}}</p>
                            <p class="text-xs text-gray-600">{{$data->cliente->nombres_cliente}} {{$data->cliente->apellidos_cliente}}</p>
                            <p class="text-xs text-gray-600">{{$data->cliente->nombre_empresa}}</p>
                            <p class="text-xs text-gray-600"></p>
                        </td>
                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_credito}}</td>
                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_abono}}</td>
                        <td class="px-4 py-3 text-sm border">Q. {{$data->total_credito-$data->total_abono}} </td>
                        <td class="px-4 py-3 text-sm border">
                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->cliente_id}})" />
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
            @include('livewire.pages.estado_cuenta.create')
        @endif
        @if($isEdit)
            @include('livewire.pages.estado_cuenta.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.estado_cuenta.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.estado_cuenta.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
