<x-frk.components.template-index>
    <x-slot:head>
    </x-slot:head>
    <x-slot:body>
    <div class="flex-wrap w-full">
        <div class="flex flex-wrap">
            <div class="flex w-full ">
                <div class="flex w-full flex-wrap md:w-2/12">
                    <x-frk.components.title label="{{$title}}" />

                </div>
                <div class="flex w-full md:w-2/12">
                    <x-frk.components.date-picker :disabled="$disabledInput" erase="false" wire:model="fecha_venta" label="Fecha Venta"/>
                </div>
                <div class="flex w-full md:w-1/12">
                    <x-frk.components.label-input label="no venta" :disabled="$disabledInput" wire:model="no_venta" />
                </div>
                <div class="flex w-full md:w-2/12 ">
                    <x-frk.components.select label="Forma Pago" error="id_forma_pago" :disabled="$disabled" wire:model.live="id_forma_pago">
                        @foreach ($this->forma_pagos as $data)
                        <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                        @endforeach
                    </x-forms.select>
                </div>
                <div class="flex w-full md:w-2/12 ">
                    <x-frk.components.select label="Envio" error="id_envio" :disabled="$disabled" wire:model.live="id_envio">
                        @foreach ($this->envios as $data)
                        <option value="{{ $data['valor'] }}" wire:key="tipo-{{ $data['id'] }}">{{ $data['nombre'] }}</option>
                        @endforeach
                    </x-forms.select>
                </div>


                <div class="flex w-full md:w-1/12"></div>

                <div class="flex w-full md:w-2/12">
                    <x-frk.components.button label="Buscar Cliente" color="blue" wire:click="searchCliente()" />
                </div>

            </div>
            <div class="flex w-full">

                <div class="flex w-full md:w-1/12">
                    <x-frk.components.label-input label="cod. inter" :disabled="$disabledInput" wire:model="codigo_interno" />
                </div>
                <div class="flex w-full md:w-1/12">
                    <x-frk.components.label-input label="cod. mayor" :disabled="$disabledInput" wire:model="codigo_mayorista" />
                </div>
                <div class="flex w-full md:w-2/12">
                    <x-frk.components.label-input label="tipo cliente" :disabled="$disabledInput"  wire:model="tipo_cliente" />
                </div>
                <div class="flex w-full md:w-1/12">
                    <x-frk.components.label-input label="nit" :disabled="$disabledInput" wire:model="nit" />
                </div>
                <div class="flex w-full md:w-4/12">
                    <x-frk.components.label-input label="nombre" error="nombres_cliente" :disabled="$disabled" wire:model="nombres_cliente" />
                </div>
                <div class="flex w-full md:w-4/12">
                    <x-frk.components.label-input label="direccion" :disabled="$disabled" wire:model="direccion_fisica" />
                </div>

            </div>

            <div class=" flex w-full">
                <div class="flex flex-wrap md:w-1/2">
                    <x-frk.components.subtitle    label="Detalle venta" />
                </div>

                <div class="flex flex-wrap md:w-1/2">
                    <x-frk.components.button label="Buscar Producto" wire:click="buscarProducto()" />
                </div>
            </div>
            <div class="flex w-full md:w-1/3">
                <x-frk.components.error error="contadorProductos" />
            </div>
            <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full table-auto  text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-sm text-gray-700 uppercase bg-gray-300 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="border px-2 py-1 text-center">
                                Codigo
                            </th>
                            <th scope="col" class="border px-2 py-1 text-center">
                                Cant.
                            </th>
                            <th scope="col" class="border px-2 py-1 text-center">
                                Descripcion
                            </th>
                            <th scope="col" class="border px-2 py-1 text-center">
                                Precio
                            </th>
                            <th scope="col" class="border px-2 py-1 text-center">
                                Subtotal
                            </th>
                            <th scope="col" class="border px-2 py-1 text-center">
                                X
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($productosDetalle as $key => $value)
                        <tr class="bg-white">
                            <th scope="col" class="border border-gray-300 px-2 text-center">
                                {{$value['id']}} //{{$value['codigo']}}
                            </th>
                            <th scope="col" class="border border-gray-300  px-2 text-center">

                                {{$value['cantidad_producto']}}
                            </th>
                            <th scope="col" class="border border-gray-300  px-2 text-left">
                                {{$value['nombre']}}

                            </th>
                            <th scope="col" class="border border-gray-300  px-2 py-1 text-center">
                                Q. {{$value['precio_venta_producto']}}
                            </th>
                            <th scope="col" class="border border-gray-300  px-2 text-right">
                                Q. {{$value['subtotal_producto']}}
                            </th>

                            <th scope="col" class="border border-gray-300  px-2 text-right">
                                <div class="flex w-full md:w-1/4">
                                    <x-frk.buttons.trash-button label="-" icon="fa-solid fa-truck-fast"   wire:click="removeDetalle({{$key}})" />
                                </div>
                            </th>
                        </tr>
                        @endforeach
                        <tr class="bg-white border-b table-cols-6">
                            <th scope="col" class=" px-2 col-span-3 text-center">
                                    - - -
                            </th>
                            <th scope="col" class=" px-2 col-span-3 text-center">
                                - - -
                        </th>
                        <th scope="col" class=" px-2 col-span-3 text-center">
                            - - -
                        </th>
                        <th scope="col" class=" px-2 col-span-3">
                            <p class=" text-base  text-center uppercase">Total:</p>
                        </th>
                        <th scope="col" class="b px-2 col-span-4">
                            <p class=" text-base  text-right"> Q. {{$total_venta}}</p>
                        </th>
                        <th scope="col" class=" px-2 col-span-3 text-center">
                                - - -
                        </th>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="flex-wrap w-full py-4">
                <div class=" flex w-full">
                    <x-frk.components.label-input label="Observaciones venta"  wire:model="observaciones_venta" />
                </div>
                <div class="flex w-full justify-between">
                    <x-frk.components.button icon="fa-solid fa-eraser" color="red" wire:click="borrarTodo()" />
                    <x-frk.components.button label="Finalizar Venta" wire:click="store()" />
                </div>
            </div>

        </div>

        <div class="flex w-full">
            <div class="w-full  flex-wrap md:w-3/12">
                <x-frk.components.subtitle font_size="text-base"  label="Detalle Credito" />
                <div class="flex w-full">
                    <div class="flex w-full md:w-2/5">
                        <x-frk.components.label-input label="Limite Credito" error="limite_credito" :disabled="$disabledInput" wire:model.live="limite_credito" />
                    </div>
                    <div class="flex w-full md:w-2/5">
                        <x-frk.components.label-input label="Dias " error="dias_ultimo_credito"  wire:model.live="dias_ultimo_credito" />
                    </div>
                </div>
                <x-frk.components.subtitle font_size="text-base"  label="Historial Credito" />


                    <div class="flex w-full">
                        <div class="flex w-full md:w-2/6">
                            <x-frk.components.label-input label="Anticipo" :disabled="$disabledInput" wire:model="abono_anticipado" />
                        </div>
                        <div class="flex w-full md:w-2/6">
                            <x-frk.components.label-input label="Saldo Cre." error="saldo_credito" :disabled="$disabledInput" wire:model.live="saldo_credito" />
                        </div>
                        <div class="flex w-full md:w-2/6">
                            <x-frk.components.label-input label="Nuevo Saldo" :disabled="$disabledInput" wire:model.live="nuevo_saldo" />
                        </div>
                    </div>
                @if ($id_forma_pago=='CREDI')
                    <div class="flex w-full">
                        <div class="flex w-full md:w-1/2">
                            <x-frk.components.button icon="fa-solid fa-unlock" color="green" wire:click="liberarCredito()" />
                        </div>
                        <div class="flex w-full md:w-1/2">
                            <x-frk.components.label-input label="Usuario"  wire:model="email_edit" />
                        </div>
                        <div class="flex w-full md:w-1/2">
                            <x-frk.components.label-input-password label="Password" type="password" wire:model="codigo_edit" />
                        </div>
                    </div>
                @endif
            </div>

            <div class="flex w-full md:w-1/12">

            </div>


            <div class="w-full  flex-wrap md:w-8/12">
                @if ($id_forma_pago=='CREDI')
                    <div class="flex w-full">
                        <x-frk.components.subtitle font_size="text-base"  label="Credito" />
                    </div>
                    <div class="flex w-full">
                        <x-frk.components.label-input label="Observaciones credito"  wire:model="observaciones_credito" />
                    </div>
                @endif
            </div>

        </div>

    </div>

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


    </x-slot:footer>
</x-frk.components.template-index>

