<x-frk.components.template-crud  maxWidth="7xl">
    <x-slot:title>
        <x-frk.components.title label="Nueva {{$title}}" />
    </x-slot>
    <x-slot:body>

    <div class="flex flex-wrap w-full">
        <!-- /--------------- lado izquierdo----------- -->
            <div class=" flex-wrap md:w-2/5">
                <div class="w-full">

                    <div class="flex w-full items-center ">
                        <x-frk.components.label-input label="buscar_cliente" :disabled="$disabled" wire:model="buscar_cliente" />
                        <x-frk.buttons.search-icon-button wire:click.prevent="buscarCliente()" />
                    </div>
                </div>

                <div class="flex-wrap w-full">

                    <div class="flex w-full ">
                        <x-frk.components.label-input label="buscar_producto" :disabled="$disabled" wire:model="buscar_producto" />
                    </div>
                    <div class="flex w-full ">
                        <x-frk.components.select label="tipo" :disabled="$disabled" wire:model="tipo_id" id="tipo_id">
                            @foreach ($this->tipos as $data)
                            <option value="{{ $data->id }}" wire:key="tipo-{{ $data->id }}">{{ $data->nombre }}</option>
                            @endforeach
                        </x-forms.select>
                    </div>
                </div>

                <div class="w-full relative  shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-1">
                                    Codigo / Producto
                                </th>

                                <th scope="col" class="px-2 py-1">
                                    Existencia
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Accion
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($productos as $key => $value)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                    {{$value->codigo}} /
                                    {{$value->nombre}}

                                </th>

                                <td class="px-2 py-1">
                                    {{$value->existencia}}
                                </td>
                                <td class="px-2 py-1">
                                    <x-frk.buttons.plus-button label="agregar {{$title}}" wire:click.prevent="addProductQuantity({{$value['id']}})" />


                                </td>


                            </tr>
                            @endforeach



                        </tbody>
                    </table>
                </div>
            </div>



            <!-- /--------------- lado derecho-----------
            <div class="flex-wrap md:w-3/5 border-double border-4 border-sky-500 p-3 ">-->

            <div class="flex flex-wrap md:w-3/5">
                <div class="flex w-full">
                    <div class="flex md:w-1/4">
                        <x-frk.components.label-input label="nit" :disabled="$disabledInput" wire:model="nit" />
                    </div>
                    <div class="flex md:w-1/4">
                        <x-frk.components.label-input label="codigo" :disabled="$disabledInput" wire:model="codigo" />
                    </div>
                    <div class="flex md:w-1/4">
                        <x-frk.components.label-input label="no_venta" :disabled="$disabledInput" wire:model="no_venta" />
                    </div>
                    <div class="flex md:w-1/4">
                        <x-frk.components.input-datetime :disabled="$disabledInput" wire:model="fecha_venta" label="Fecha de Compra"/>
                    </div>



                </div>


                <div class="flex w-full ">

                    <div class="flex md:w-1/2">
                        <x-frk.components.label-input label="nombres_cliente" :disabled="$disabled" wire:model="nombres_cliente" />
                    </div>
                    <div class="flex md:w-1/2">
                        <x-frk.components.label-input label="nombre_empresa" :disabled="$disabled" wire:model="nombre_empresa" />
                    </div>
                </div>
                <div class="flex w-full ">

                    <div class="flex md:w-3/4">
                        <x-frk.components.label-input label="direccion_fisica" :disabled="$disabled" wire:model="direccion_fisica" />
                    </div>
                    <div class="flex md:w-1/4">
                        <x-frk.components.label-input label="tipo_cliente" :disabled="$disabledInput"  wire:model="tipo_cliente" />
                    </div>
                </div>

                <div class=" w-full">
                    <x-frk.components.label label="DETALLE FACTURA:" />

                </div>


                <div class="flex w-full ">

                    <div class="flex flex-wrap md:w-1/3">
                        <x-frk.components.label label="Total:  Q. {{$total}}" />
                        <x-frk.components.label label="Descuento:  {{$descuento}} %" />
                    </div>

                    <div class="flex flex-wrap  md:w-1/3">
                        <x-frk.components.label label="Ahorro:  Q. {{$ahorro}}" />

                        <x-frk.components.label label="Total con Descuento:  Q. {{$total_descuento}}" />
                    </div>

                    <div class="flex flex-wrap md:w-1/3">
                        <x-frk.components.label-input-h label="Efectivo:" wire:model="cantidad_efectivo"/>
                        <x-frk.components.label-input-h label="Credito:" :disabled="$disabledCredito" wire:model="cantidad_credito"/>
                        <x-frk.components.error error="limite_credito" />
                    </div>
                </div>
                <div class="flex w-full ">

                </div>


                <div class="w-full relative overflow-x-auto shadow-md sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-2 py-1">
                                    Codigo
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Producto
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Precio Venta
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Cantidad
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Subtotal
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Op
                                </th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($productosDetalle as $key => $value)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                                    {{$value['codigo']}}

                                </th>
                                <th scope="col" class="px-2 py-1">

                                    {{$value['nombre']}}
                                </th>

                                <th scope="col" class="px-2 py-1">
                                    Q. {{$value['precio_venta_producto']}}
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    {{$value['cantidad_producto']}}
                                </th>
                                <th scope="col" class="px-2 py-1">
                                    Q. {{$value['subtotal_producto']}}
                                </th>

                                <th scope="col" class="px-2 py-1">

                                    <div class="flex w-full md:w-1/4">
                                        <x-frk.buttons.trash-button label="Remover" wire:click.prevent="removeDetalle({{$key}})" />
                                    </div>
                                </th>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>


                <div class="flex w-full">



                    <x-frk.components.button label="guardar"  color="blue" wire:click.prevent="store()" />

                    <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
                </div>


            </div>
        </div>
    </x-slot>
    <x-slot:footer>

    </x-slot>
</x-frk.modal>

