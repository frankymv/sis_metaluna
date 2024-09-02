<x-frk.components.template-index>
    <x-slot:head>
        <x-frk.components.title label="{{$title}}" />
        <x-frk.components.button label="agregar" wire:click="create()" />
    </x-slot:head>
    <x-slot:body>


    <section class="container mx-auto ">
        <div class="w-full  rounded-lg shadow-lg">
          <div class="w-full overflow-x-auto">
            <table class=" table-fixed">
                <thead>
                    <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                    <th class="px-4 py-3 text-ms font-semibold border">No Envio</th>
                    <th class="px-4 py-3">Fecha Envio</th>
                    <th class="px-4 py-3">Estado Envio</th>
                    <th class="px-4 py-3">Ruta Codigo</th>
                    <th class="px-4 py-3">Ventas</th>
                    <th class="px-4 py-3">Usuario</th>
                    <th class="px-4 py-3">Vehiculo</th>
                    <th class="px-4 py-3">Accion</th>

                    </tr>
                </thead>
                <tbody class="bg-white">
                    @foreach ($envios as $data)
                    <tr class="text-gray-700">
                        <td class="px-4 py-3 text-ms font-semibold border">{{$data->envio_no}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->envio_fecha}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->estado_envio}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->ruta_id}}</td>
                    <td class="px-4 py-3 text-sm border">
                    @foreach ($data->ventas as $dataa)
                        <p class="text-xs text-gray-600">No Venta: {{$dataa->no_venta}} Fecha: {{$dataa->fecha_venta}} Total: {{$dataa->total_venta}}</p>
                    @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm border">
                        @foreach ($data->users as $dataa)
                            <p class="text-xs text-gray-600">Codigo: {{$dataa->codigo}} Fecha: {{$dataa->nombre}} </p>
                        @endforeach
                        </td>
                    <td class="px-4 py-3 text-sm border">
                        @foreach ($data->vehiculos as $dataa)
                            <p class="text-xs text-gray-600">Codigo: {{$dataa->codigo}} Alias: {{$dataa->alias}}</p>
                        @endforeach
                    </td>

                        <td class="px-4 py-3 text-sm border flex w-full">

                            <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                            <x-frk.components.button-icon color="blue" icon="fa-solid fa-flag-checkered" wire:click="finalizar({{$data->id}})" />
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
            @include('livewire.pages.envio.create')
        @endif
        @if($isFinalizar)
            @include('livewire.pages.envio.finalizar')
        @endif
        @if($isEdit)
            @include('livewire.pages.envio.edit')
        @endif
        @if($isShow)
            @include('livewire.pages.envio.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.envio.delete')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>
