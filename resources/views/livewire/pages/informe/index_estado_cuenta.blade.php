<x-frk.components.template-index>
    <x-slot:head>

        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="create()" />
            </div>
            <div class="flex w-full">

                <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>
                <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>
                <x-frk.components.select label="Listado Clientes" wire:model.live="filtroClientes">
                    @foreach ($this->clientes as $data)
                    <option value="{{ $data['codigo_interno'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombres_cliente'] }}</option>
                    @endforeach
                </x-forms.select>
                <x-frk.components.select label="Tipo Cliente" wire:model.live="filtroTipoCliente">
                    @foreach ($this->tipo_clientes as $data)
                    <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.select label="Ruta" wire:model.live="filtroRutaCliente">
                    @foreach ($this->rutas as $data)
                    <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>
            </div>
        </div>
    </x-slot:head>
    <x-slot:body>


    <!-- component -->
<section class="container mx-auto >
    <div class="w-full  rounded-lg shadow-lg">
      <div class="w-full overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                <th class="px-4 py-3">Codigo Interno</th>
                <th class="px-4 py-3">Codigo Mayorista</th>
                <th class="px-4 py-3">Nombre Cliente</th>
                <th class="px-4 py-3">Direccion Cliente</th>
                <th class="px-4 py-3">Tipo Cliente</th>
                <th class="px-4 py-3">Ruta</th>
                <th class="px-4 py-3">Credito</th>
                <th class="px-4 py-3">Abono</th>
                <th class="px-4 py-3">Saldo</th>


                </tr>
            </thead>
            <tbody class="bg-white">
                @foreach ($estado_cuentas as $data)
                <tr class="text-gray-700">
                    <td class="px-4 py-3 text-ms font-semibold border">{{$data->codigo_interno}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->codigo_mayorista}}</td>
                    <td class="px-4 py-3 border">
                        <p class="text-xs text-gray-600">{{$data->nombres_cliente}} Telefono {{$data->telefono_principal}}</p>
                    </td>
                    <td class="px-4 py-3 text-sm border">{{$data->direccion_fisica}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->tipo_cliente}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->nombre}}</td>

                    <td class="px-4 py-3 text-sm border">{{$data->total_credito}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->total_abono}}</td>
                    <td class="px-4 py-3 text-sm border">{{$data->total_credito-$data->total_abono}} </td>


                </tr>
                @endforeach
                <tr>
                    <td class="px-4 py-3 text-sm border"></td>
                    <td class="px-4 py-3 text-sm border"></td>
                    <td class="px-4 py-3 text-sm border"></td>
                    <td class="px-4 py-3 text-sm border"></td>
                    <td class="px-4 py-3 text-sm border"></td>


                    <td class="px-4 py-3 text-sm border">{{$total_ventas}}</td>
                </tr>

            </tbody>
        </table>
      </div>
    </div>
</section>
    </x-slot:body>
    <x-slot:footer>

    </x-slot:footer>
</x-frk.components.template-index>
