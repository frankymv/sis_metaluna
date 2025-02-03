<x-frk.components.template-index>
    <x-slot:head>
    </x-slot:head>
    <x-slot:body>

    <section class="container mx-auto">
        <div class="flex-wrap w-full">
            <div class="flex flex-wrap">
                <div class="flex w-full">
                    <div class="flex flex-wrap justify-center items-center w-2/12">
                        <x-frk.components.title label="{{$title}}" />
                    </div>
                    <div class="flex  w-1/12">
                        <x-frk.components.label-input label="No." :disabled="$disabledInput" wire:model="no_venta" />
                    </div>
                    <div class="flex w-2/12">
                        <x-frk.components.date-picker :disabled="$disabledInput" erase="false" wire:model="fecha_venta" label="Fecha"/>
                    </div>
                    <div class="flex w-2/12 ">
                        <x-frk.components.select label="Forma Pago" error="id_forma_pago" :disabled="$disabled" wire:model.live="id_forma_pago">
                            @foreach ($this->forma_pagos as $data)
                            <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div class="flex w-2/12 ">
                        <x-frk.components.select label="Envio" error="id_envio" :disabled="$disabled" wire:model.live="id_envio">
                            @foreach ($this->envios as $data)
                            <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                    <div class="flex w-1/12"></div>
                    <div class="flex w-2/12 justify-between">
                        <x-frk.components.button label="Buscar Cliente" color="blue" wire:click="searchCliente()" />
                        <x-frk.components.button-icon color="red" icon="fa-solid fa-trash" wire:click="borrarTodo()" />
                    </div>
                </div>
                <div class="flex w-full">
                    <div class="flex w-1/12">
                        <x-frk.components.label-input label="cod. inter" :disabled="$disabledInput" wire:model="codigo_interno" />
                    </div>
                    <div class="flex w-1/12">
                        <x-frk.components.label-input label="cod. mayor" :disabled="$disabledInput" wire:model="codigo_mayorista" />
                    </div>
                    <div class="flex w-2/12">
                        <x-frk.components.label-input label="tipo cliente" :disabled="$disabledInput"  wire:model="tipo_cliente" />
                    </div>
                    <div class="flex w-1/12">
                        <x-frk.components.label-input label="nit" :disabled="$disabledInput" wire:model="nit" />
                    </div>
                    <div class="flex w-4/12">
                        <x-frk.components.label-input label="nombre" error="nombres_cliente" :disabled="$disabled" wire:model="nombres_cliente" />
                    </div>
                    <div class="flex w-4/12">
                        <x-frk.components.label-input label="direccion" :disabled="$disabled" wire:model="direccion_fisica" />
                    </div>
                </div>
                <div class=" flex w-full">
                    <div class="flex flex-wrap mt-5 w-1/2">
                        <x-frk.components.subtitle    label="Detalle venta" />
                    </div>
                    <div class="flex flex-wrap w-1/2">
                        <x-frk.components.button label="Buscar Producto" color="green" wire:click="buscarProducto()" />
                    </div>
                </div>
                <div class="flex w-1/3">
                    <x-frk.components.error error="contadorProductos" />
                </div>
                <div class="w-full  rounded-lg shadow-lg">
                    <div class="w-full overflow-x-auto">
                        <table class=" w-full">
                            <thead>
                                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                                    <th class="px-4 py-3">Codigo</th>
                                    <th class="px-4 py-3">Cantidad</th>
                                    <th class="px-4 py-3">Producto</th>
                                    <th class="px-4 py-3">Precio Venta</th>
                                    <th class="px-4 py-3">Subtotal</th>
                                    <th class="px-4 py-3">Acciones</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                @foreach($productosDetalle as $key => $value)
                                <tr class="text-gray-700">
                                    <td class="px-4 py-1 text-ms font-semibold border">{{$value['id']}} - {{$value['codigo']}}</td>
                                    <td class="px-4 py-1 text-sm border"> {{$value['cantidad_producto']}}</td>
                                    <td class="px-4 py-1 text-sm border">{{$value['nombre']}}</td>
                                    <td class="px-4 py-1 text-sm border">Q. {{$value['precio_venta_producto']}}</td>
                                    <td class="px-4 py-1 text-sm border">Q. {{$value['subtotal_producto']}}</td>
                                    <td class="px-4 py-1 text-sm border flex">
                                        <x-frk.buttons.trash-button label="-" icon="fa-solid fa-truck-fast"   wire:click="removeDetalle({{$key}})" />
                                    </td>
                                </tr>
                                @endforeach
                                <tr class="text-md font-semibold tracking-wide text-left text-gray-900 bg-gray-100 uppercase border-b">
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3"></th>
                                    <th class="px-4 py-3">Total: Q. {{$total_venta}} </th>
                                    <th class="px-4 py-3"></th>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="flex w-full py-4">
                    <x-frk.components.label-input label="Observaciones venta"  wire:model="observaciones_venta" />
                    <x-frk.components.button color="orange" label="Finalizar Venta" wire:click="store()" />
                </div>
            </div>
            <div class="flex">
                <div class="flex-wrap w-4/12">
                    <x-frk.components.subtitle font_size="text-base"  label="Historial Credito" />
                    <div class="flex">
                        <div class="flex w-2/6">
                            <x-frk.components.label-input-money  label="Anticipo" :disabled="$disabledInput" wire:model="abono_anticipado" />
                        </div>
                        <div class="flex w-2/6">
                            <x-frk.components.label-input-money  label="Saldo Cre." error="saldo_credito" :disabled="$disabledInput" wire:model.live="saldo_credito" />
                        </div>
                        <div class="flex w-2/6">
                            <x-frk.components.label-input-money  label="Nuevo Saldo" :disabled="$disabledInput" wire:model.live="nuevo_saldo" />
                        </div>
                    </div>
                </div>
                <div class="flex-wrap w-4/12">
                    <x-frk.components.subtitle font_size="text-base"  label="Detalle Credito" />
                    <div class="flex">
                        <div class="flex w-2/5">
                            <x-frk.components.label-input-money  label="Limite Credito" error="limite_credito" :disabled="$disabledInput" wire:model.live="limite_credito" />
                        </div>
                        <div class="flex w-2/5">
                            <x-frk.components.label-input-money  label="Limite Credito" error="limite_credito" :disabled="$disabledInput" wire:model.live="limite_credito" />
                        </div>
                        <div class="flex w-2/5">
                            <x-frk.components.label-input label="Dias " error="dias_ultimo_credito"  wire:model.live="dias_ultimo_credito" />
                        </div>
                    </div>
                </div>
                <div class="flex-wrap w-4/12">
                    @if ($id_forma_pago=='CREDI')
                        <div class="flex">
                            <div class="flex w-1/3">
                                <x-frk.buttons.unlock-icon-button class="bg-orange-500 hover:bg-orange-700 label" wire:click="liberarCredito()" />
                            </div>
                            <div class="flex w-1/3">
                                <x-frk.components.label-input label="Usuario"  type="input" wire:model="email_edit" />
                            </div>
                            <div class="flex w-1/3">
                                <x-frk.components.label-input-password label="Password" type="password" wire:model="codigo_edit" />
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <div class="w-full  flex-wrap">
                @if ($id_forma_pago=='CREDI')
                    <div class="flex">
                        <x-frk.components.label-input label="Observaciones credito"  wire:model="observaciones_credito" />
                    </div>
                @endif
            </div>
        </div>
    </section>
        </x-slot:body>
    <x-slot:footer>
        @if($isSearchCliente)
            @include('livewire.pages.venta_rapida.searchCliente')
        @endif
        @if($isAddProduct)
            @include('livewire.pages.venta_rapida.addProduct')
        @endif
        @if($isSearchProduct)
            @include('livewire.pages.venta_rapida.searchProduct')
        @endif
        @if($isDetalleVenta)
            @include('livewire.pages.venta_rapida.detalleVenta')
        @endif
        @if($isPrintVenta)
            @include('livewire.pages.venta_rapida.printVenta')
        @endif
    </x-slot:footer>
</x-frk.components.template-index>

