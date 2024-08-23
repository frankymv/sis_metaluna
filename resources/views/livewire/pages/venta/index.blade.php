<x-frk.components.template-index>
    <x-slot:head>
        <div class="w-full">
            <div class="flex w-full">
                <x-frk.components.title label="{{$title}}" />
                <x-frk.components.button color="red" label="Exportar PDF" wire:click="exportarGeneral()" />
            </div>
            <div class="flex w-full">
                <x-frk.components.label-input label="No venta" wire:model.live="filtroNoVenta"/>
                <x-frk.components.label-input label="Codigo Cliente" wire:model.live="filtroCodigoCliente"/>
                <x-frk.components.label-input label="Nombre Cliente" wire:model.live="filtroNombreCliente"/>

                <x-frk.components.date-picker   wire:model.live="filtroFechaVenta" label="Fecha Venta"/>
                <x-frk.components.selectFiltro label="Forma Pago" wire:model.live="filtroFormaPago">
                    @foreach ($this->forma_pagos as $data)
                    <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>
                <x-frk.components.selectFiltro label="Envio" wire:model.live="filtroEnvio">
                    @foreach ($this->envios as $data)
                    <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Tipo Cliente" wire:model.live="filtroTipoCliente">
                    @foreach ($this->tipo_clientes as $data)
                    <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>

                <x-frk.components.selectFiltro label="Ruta" wire:model.live="filtroRutaCliente">
                    @foreach ($this->rutas as $data)
                    <option value="{{ $data['id'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                    @endforeach
                </x-forms.select>
                {{$filtroNoVenta}}
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
                            <th class="px-4 py-3">No Venta</th>
                        <th class="px-4 py-3">Cliente</th>
                        <th class="px-4 py-3">Ruta</th>
                        <th class="px-4 py-3">Tipo Cliente</th>
                        <th class="px-4 py-3">Forma Pago</th>
                        <th class="px-4 py-3">Envio</th>
                        <th class="px-4 py-3">Fecha Venta</th>
                        <th class="px-4 py-3">Total Venta</th>
                        <th class="px-4 py-3">Nota Credito</th>
                        <th class="px-4 py-3">Total Venta con Nota Credito</th>
                        <th class="px-4 py-3">Credito</th>
                        <th class="px-4 py-3">Abono</th>
                        <th class="px-4 py-3">Saldo</th>


                        <th class="px-4 py-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @foreach ($ventas as $data)
                        <tr class="text-gray-700">
                            <td class="px-4 py-3 text-ms font-semibold border">{{$data->no_venta}}</td>
                            <td class="px-4 py-3 border">
                                <p class="text-xs text-gray-600">Codigo Cliente Mayorista: {{$data->codigo_mayorista}} Nombres: {{$data->nombres_cliente}}</p>
                            </td>
                            <td class="px-4 py-3 text-sm border">{{$data->nombre}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->tipo_cliente}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->forma_pago_venta}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->envio}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->fecha_venta}}</td>
                            <td class="px-4 py-3 text-sm font-semibold border">{{$data->total_venta}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->total_nota_credito}}</td>
                            <td class="px-4 py-3 text-sm border">{{$data->total_venta-$data->total_nota_credito}}</td>



                            @if (($data->total_credito-$data->total_nota_credito)<=0)
                            <td class="px-4 py-3 text-sm border"> 0</td>
                            @else
                            <td class="px-4 py-3 text-sm border"> {{$data->total_credito-$data->total_nota_credito}}</td>
                            @endif

                            <td class="px-4 py-3 text-sm border">{{$data->total_abono}}</td>




                            @if ((($data->total_credito-$data->total_nota_credito)-$data->total_abono)<=0)
                            <td class="px-4 py-3 text-sm border"> 0</td>
                            @else
                            <td class="px-4 py-3 text-sm border"> {{($data->total_credito-$data->total_nota_credito)-$data->total_abono}}</td>
                            @endif
                            <td class="px-4 py-3 text-sm border flex w-full">
                                <x-frk.components.button-icon color="red" icon="fa-solid fa-file-pdf" wire:click="exportarFila({{$data->id}})" />
                                                        </td>

                        </tr>
                        @endforeach
                        <tr>
                            <td class="px-4 py-3 text-sm border"></td>
                            <td class="px-4 py-3 text-sm border"></td>
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

        @if($isShow)
            @include('livewire.pages.venta.show')
        @endif
        @if($isDelete)
            @include('livewire.pages.venta.delete')
        @endif

    </x-slot:footer>
</x-frk.components.template-index>
