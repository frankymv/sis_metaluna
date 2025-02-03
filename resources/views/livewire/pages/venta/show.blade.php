<x-frk.components.template-crud>
    <x-slot:title>
        <x-frk.components.title label="Detalle {{$title}}" />
    </x-slot>
    <x-slot:body>

    <div class="flex flex-wrap w-full">

        <div class="flex w-full">
            <div class="flex md:w-1/5">
                <x-frk.components.label-input label="nit" :disabled="$disabledInput" wire:model="nit" />
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.label-input label="codigo" :disabled="$disabledInput" wire:model="codigo" />
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.label-input label="no_venta" :disabled="$disabledInput" wire:model="no_venta" />
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.input-datetime :disabled="$disabledInput" wire:model="fecha_venta" label="Fecha de Venta"/>
            </div>

            <div class="flex md:w-1/5 ">
                <x-frk.components.input-datetime :disabled="$disabledInput" wire:model="tipo_envio" label="Envio"/>
            </div>
        </div>


        <div class="flex w-full ">

            <div class="flex md:w-1/2">
                <x-frk.components.label-input label="nombres_cliente" :disabled="$disabledInput" wire:model="nombres_cliente" />
            </div>
            <div class="flex md:w-1/2">
                <x-frk.components.label-input label="nombre_empresa" :disabled="$disabledInput" wire:model="nombre_empresa" />
            </div>
        </div>
        <div class="flex w-full ">

            <div class="flex md:w-2/5">
                <x-frk.components.label-input label="direccion_fisica" :disabled="$disabledInput" wire:model="direccion_fisica" />
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.input-datetime :disabled="$disabledInput" wire:model="direccion_departamento" label="Departamento"/>
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.input-datetime :disabled="$disabledInput" wire:model="direccion_municipio" label="Municipio"/>
            </div>
            <div class="flex md:w-1/5">
                <x-frk.components.label-input label="Tipo Cliente" :disabled="$disabledInput"  wire:model="tipo_cliente" />
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
                <x-frk.components.label label="Efectivo: {{$cantidad_efectivo}}  "/>
                <x-frk.components.label label="Credito:  {{$cantidad_credito}} " />
            </div>
        </div>











        <!--   -->


        <div class="w-full relative  shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-2 py-1">
                            Codigo
                        </th>

                        <th scope="col" class="px-2 py-1">
                            Nombre Producto
                        </th>
                        <th scope="col" class="px-2 py-1">
                            Cantidad
                        </th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($venta->productos as $key => $value)
                    <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                        <th scope="row" class="px-2 py-1 font-medium text-gray-900 whitespace-prewrap dark:text-white">
                            {{$value->codigo}}


                        </th>
                        <td class="px-2 py-1">
                            {{$value->nombre}}
                        </td>

                        <td class="px-2 py-1">
                            {{$value->producto_venta->cantidad}}

                        </td>



                    </tr>
                    @endforeach



                </tbody>
            </table>
        </div>


    </div>













    </x-slot>
    <x-slot:footer>
        <x-frk.components.button label="guardar"  color="blue" wire:click.prevent="store()" />
        <x-frk.components.button label="cancelar" wire:click.prevent="cancel()" />
    </x-slot>
</x-frk.modal>

